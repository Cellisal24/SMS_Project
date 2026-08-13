<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Schedule;
use App\Models\Student;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index()
    {
        // Distinct class+subject combos this teacher actually teaches,
        // derived from their own schedule (never let them pick someone else's).
        $combos = Schedule::where('teacher_id', auth()->user()->teacher_id)
            ->with(['subject', 'schoolClass'])
            ->get()
            ->unique(fn ($s) => $s->class_id . '-' . $s->subject_id);

        return view('teacher.grades.index', compact('combos'));
    }

    public function roster(Request $request)
    {
        $data = $request->validate([
            'class_id' => ['required', 'string'],
            'subject_id' => ['required', 'string'],
            'semester' => ['required', 'string'],
        ]);

        $this->assertTeachesClassSubject($data['class_id'], $data['subject_id']);

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
            'class_id' => ['required', 'string'],
            'subject_id' => ['required', 'string'],
            'semester' => ['required', 'string'],
            'students' => ['required', 'array', 'min:1'],
            'students.*.student_id' => ['required', 'exists:students,student_id'],
            'students.*.midterm_score' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'students.*.final_score' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        $this->assertTeachesClassSubject($data['class_id'], $data['subject_id']);

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

        return redirect()->route('teacher.grades.index')
            ->with('status', 'Grades saved for ' . count($data['students']) . ' students.');
    }

    /**
     * A teacher may only enter grades for a class+subject they actually
     * teach, per their own schedule — never someone else's.
     */
    protected function assertTeachesClassSubject(string $classId, string $subjectId): void
    {
        $owns = Schedule::where('teacher_id', auth()->user()->teacher_id)
            ->where('class_id', $classId)
            ->where('subject_id', $subjectId)
            ->exists();

        if (! $owns) {
            abort(403, 'You do not teach this class/subject.');
        }
    }
}
