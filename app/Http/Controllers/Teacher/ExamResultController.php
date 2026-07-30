<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\Schedule;
use App\Models\Student;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ExamResultController extends Controller
{
    public function index(Request $request)
    {
        $teacherId = auth()->user()->teacher_id;

        // Only exams whose subject+class this teacher actually teaches, per their own schedule
        $myClassSubjects = Schedule::where('teacher_id', $teacherId)
            ->get(['class_id', 'subject_id'])
            ->unique(fn ($s) => $s->class_id . '-' . $s->subject_id);

        $examIds = Exam::where(function ($q) use ($myClassSubjects) {
            foreach ($myClassSubjects as $combo) {
                $q->orWhere(function ($sub) use ($combo) {
                    $sub->where('class_id', $combo->class_id)
                        ->where('subject_id', $combo->subject_id);
                });
            }
        })->pluck('exam_id');

        $query = ExamResult::whereIn('exam_id', $examIds)->with(['exam.subject', 'exam.schoolClass', 'student']);

        if ($request->filled('exam_id')) {
            $query->where('exam_id', $request->exam_id);
        }

        $results = $query->latest('result_id')->paginate(20)->withQueryString();

        $exams = Exam::whereIn('exam_id', $examIds)->with(['subject', 'schoolClass'])->orderBy('exam_date', 'desc')->get();

        return view('Teacher.exam_results.index', compact('results', 'exams'));
    }

    public function create()
    {
        $teacherId = auth()->user()->teacher_id;

        $myClassSubjects = Schedule::where('teacher_id', $teacherId)
            ->get(['class_id', 'subject_id'])
            ->unique(fn ($s) => $s->class_id . '-' . $s->subject_id);

        $exams = Exam::where(function ($q) use ($myClassSubjects) {
            foreach ($myClassSubjects as $combo) {
                $q->orWhere(function ($sub) use ($combo) {
                    $sub->where('class_id', $combo->class_id)
                        ->where('subject_id', $combo->subject_id);
                });
            }
        })->with(['subject', 'schoolClass'])->orderBy('exam_date', 'desc')->get();

        return view('Teacher.exam_results.create', compact('exams'));
    }

    public function roster(Request $request)
    {
        $data = $request->validate([
            'exam_id' => ['required', 'exists:exams,exam_id'],
        ]);

        $exam = Exam::findOrFail($data['exam_id']);

        $this->assertOwnsExam($exam);

        $students = Student::where('class_id', $exam->class_id)
            ->orderBy('first_name')
            ->get();

        $existing = ExamResult::where('exam_id', $exam->exam_id)
            ->whereIn('student_id', $students->pluck('student_id'))
            ->get()
            ->keyBy('student_id');

        return response()->json([
            'students' => $students->map(fn ($s) => [
                'student_id' => $s->student_id,
                'name' => "{$s->first_name} {$s->last_name}",
                'score' => $existing[$s->student_id]->score ?? '',
                'max_score' => $existing[$s->student_id]->max_score ?? 100,
                'remarks' => $existing[$s->student_id]->remarks ?? '',
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'exam_id' => ['required', 'exists:exams,exam_id'],
            'students' => ['required', 'array', 'min:1'],
            'students.*.student_id' => ['required', 'exists:students,student_id'],
            'students.*.score' => ['required', 'numeric', 'min:0'],
            'students.*.max_score' => ['required', 'numeric', 'min:1'],
            'students.*.remarks' => ['nullable', 'string', 'max:255'],
        ]);

        $exam = Exam::findOrFail($data['exam_id']);
        $this->assertOwnsExam($exam);

        foreach ($data['students'] as $entry) {
            ExamResult::updateOrCreate(
                [
                    'exam_id' => $data['exam_id'],
                    'student_id' => $entry['student_id'],
                ],
                [
                    'score' => $entry['score'],
                    'max_score' => $entry['max_score'],
                    'remarks' => $entry['remarks'] ?? null,
                ]
            );
        }

        return redirect()->route('teacher.exam-results.index')
            ->with('success', 'Results saved for ' . count($data['students']) . ' students.');
    }

    /**
     * A teacher may only enter results for an exam whose subject+class
     * matches their own schedule — never someone else's exam.
     */
    protected function assertOwnsExam(Exam $exam): void
    {
        $owns = Schedule::where('teacher_id', auth()->user()->teacher_id)
            ->where('class_id', $exam->class_id)
            ->where('subject_id', $exam->subject_id)
            ->exists();

        if (! $owns) {
            throw new AccessDeniedHttpException('You do not teach this class/subject.');
        }
    }
}