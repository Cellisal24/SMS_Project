<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        // Every class this teacher actually teaches, derived from their own schedule
        $classIds = Schedule::where('teacher_id', auth()->user()->teacher_id)
            ->distinct()
            ->pluck('class_id');

        $query = Student::whereIn('class_id', $classIds)->with('schoolClass');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        $students = $query->orderBy('first_name')->paginate(20)->withQueryString();

        // For the class filter dropdown — only classes this teacher teaches, not every class in the school
        $classes = Schedule::where('teacher_id', auth()->user()->teacher_id)
            ->with('schoolClass')
            ->get()
            ->pluck('schoolClass')
            ->filter()
            ->unique('class_id');

        return view('Teacher.students.index', compact('students', 'classes'));
    }
}