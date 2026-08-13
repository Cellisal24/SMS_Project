<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $query = Grade::with(['student', 'subject']);

        if ($request->filled('class_id')) {
            $query->whereHas('student', fn ($q) => $q->where('class_id', $request->class_id));
        }

        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        $grades = $query->latest('grade_id')->paginate(20)->withQueryString();

        $classes = SchoolClass::orderBy('class_name')->get();
        $subjects = Subject::orderBy('subject_name')->get();

        return view('admin.grades.index', compact('grades', 'classes', 'subjects'));
    }

    public function create()
    {
        $classes = SchoolClass::orderBy('class_name')->get();
        $subjects = Subject::orderBy('subject_name')->get();

        return view('admin.grades.create', compact('classes', 'subjects'));
    }

    /**
     * Load the student roster for a class, so the bulk-entry form
     * can render one row per student (same UX pattern as attendance).
     */
    public function roster(Request $request)
    {
        $data = $request->validate([
            'class_id' => ['required', 'exists:classes,class_id'],
            'subject_id' => ['required', 'exists:subjects,subject_id'],
            'semester' => ['required', 'string'],
        ]);

        $students = Student::where('class_id', $data['class_id'])
            ->orderBy('first_name')
            ->get();

        $existing = Grade::where('subject_id', $data['subject_id'])
            ->where('semester', $data['semester'])
            ->whereIn('student_id', $students->pluck('student_id'))
            ->get()
            ->keyBy('student_id');

        return response()->json([
            'students' => $students->map(fn ($s) => [
                'student_id' => $s->student_id,
                'name' => "{$s->first_name} {$s->last_name}",
                'midterm_score' => $existing[$s->student_id]->midterm_score ?? '',
                'final_score' => $existing[$s->student_id]->final_score ?? '',
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'class_id' => ['required', 'exists:classes,class_id'],
            'subject_id' => ['required', 'exists:subjects,subject_id'],
            'semester' => ['required', 'string'],
            'students' => ['required', 'array', 'min:1'],
            'students.*.student_id' => ['required', 'exists:students,student_id'],
            'students.*.midterm_score' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'students.*.final_score' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        foreach ($data['students'] as $entry) {
            Grade::updateOrCreate(
                [
                    'student_id' => $entry['student_id'],
                    'subject_id' => $data['subject_id'],
                    'semester' => $data['semester'],
                ],
                [
                    'midterm_score' => $entry['midterm_score'] !== '' ? $entry['midterm_score'] : null,
                    'final_score' => $entry['final_score'] !== '' ? $entry['final_score'] : null,
                ]
            );
        }

        return redirect()->route('admin.grades.index')
            ->with('status', 'Grades saved for ' . count($data['students']) . ' students.');
    }

    public function edit(Grade $grade)
    {
        return view('admin.grades.edit', compact('grade'));
    }

    public function update(Request $request, Grade $grade)
    {
        $data = $request->validate([
            'midterm_score' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'final_score' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        $grade->update($data);

        return redirect()->route('admin.grades.index')->with('status', 'Grade updated.');
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();

        return redirect()->route('admin.grades.index')->with('status', 'Grade record deleted.');
    }
}
