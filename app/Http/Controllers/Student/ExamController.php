<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamResult;

class ExamController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student()->firstOrFail();

        $upcomingExams = Exam::where('class_id', $student->class_id)
            ->where('exam_date', '>=', now()->toDateString())
            ->with(['subject', 'room'])
            ->orderBy('exam_date')
            ->get();

        $results = ExamResult::where('student_id', $student->student_id)
            ->with(['exam.subject'])
            ->get()
            ->sortByDesc(fn ($r) => $r->exam->exam_date ?? null);

        return view('student.exams.index', compact('student', 'upcomingExams', 'results'));
    }
}
