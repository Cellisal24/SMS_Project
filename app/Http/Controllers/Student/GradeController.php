<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Grade;

class GradeController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student()->firstOrFail();

        $grades = Grade::where('student_id', $student->student_id)
            ->with('subject')
            ->orderBy('semester')
            ->get()
            ->groupBy('semester');

        return view('Student.grades.index', compact('student', 'grades'));
    }
}