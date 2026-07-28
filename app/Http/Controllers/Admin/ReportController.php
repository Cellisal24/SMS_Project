<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Report;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::with(['student', 'schoolClass', 'generatedBy']);

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        if ($request->filled('academic_year')) {
            $query->where('academic_year', $request->academic_year);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($search = $request->input('search')) {
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        $reports = $query->orderBy('class_rank')->paginate(20)->withQueryString();
        $classes = SchoolClass::orderBy('class_name')->get();

        return view('Admin.reports.index', compact('reports', 'classes'));
    }

    public function create()
    {
        $classes = SchoolClass::orderBy('class_name')->get();

        return view('Admin.reports.create', compact('classes'));
    }

    /**
     * Generate (or refresh) a summary report card for every student
     * in the selected class/semester/academic year, using existing
     * grades and attendance records. Same "bulk by class" pattern as
     * Grades and Attendance.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'class_id' => ['required', 'exists:classes,class_id'],
            'semester' => ['required', 'string', 'max:15'],
            'academic_year' => ['required', 'integer'],
        ]);

        $students = Student::where('class_id', $data['class_id'])->get();

        $summaries = $students->map(function ($student) use ($data) {
            $grades = Grade::where('student_id', $student->student_id)
                ->where('semester', $data['semester'])
                ->get();

            $scores = $grades->map(fn ($g) => $g->final_score ?? $g->midterm_score)
                ->filter(fn ($v) => $v !== null);

            $attendanceQuery = Attendance::where('student_id', $student->student_id);
            $totalAttendance = $attendanceQuery->count();
            $presentAttendance = (clone $attendanceQuery)->where('status', 'present')->count();

            return [
                'student_id' => $student->student_id,
                'total_score' => $scores->isNotEmpty() ? round($scores->sum(), 2) : null,
                'average_score' => $scores->isNotEmpty() ? round($scores->avg(), 2) : null,
                'attendance_percentage' => $totalAttendance > 0
                    ? round(($presentAttendance / $totalAttendance) * 100, 2)
                    : null,
            ];
        });

        // Rank within the class by average score (highest first, nulls last).
        $ranked = $summaries->sortByDesc(fn ($s) => $s['average_score'] ?? -1)->values();

        foreach ($ranked as $index => $summary) {
            Report::updateOrCreate(
                [
                    'student_id' => $summary['student_id'],
                    'semester' => $data['semester'],
                    'academic_year' => $data['academic_year'],
                ],
                [
                    'class_id' => $data['class_id'],
                    'total_score' => $summary['total_score'],
                    'average_score' => $summary['average_score'],
                    'class_rank' => $summary['average_score'] !== null ? $index + 1 : null,
                    'attendance_percentage' => $summary['attendance_percentage'],
                    'generated_at' => now(),
                ]
            );
        }

        return redirect()->route('admin.reports.index')
            ->with('success', 'Generated ' . $ranked->count() . ' report card(s).');
    }

    public function edit(Report $report)
    {
        $teachers = Teacher::orderBy('first_name')->get();

        return view('Admin.reports.edit', compact('report', 'teachers'));
    }

    public function update(Request $request, Report $report)
    {
        $data = $request->validate([
            'teacher_comments' => ['nullable', 'string'],
            'generated_by' => ['nullable', 'exists:teachers,teacher_id'],
            'status' => ['required', 'in:draft,published'],
        ]);

        $report->update($data);

        return redirect()->route('admin.reports.index')->with('success', 'Report updated.');
    }

    public function destroy(Report $report)
    {
        $report->delete();

        return redirect()->route('admin.reports.index')->with('success', 'Report deleted.');
    }
}