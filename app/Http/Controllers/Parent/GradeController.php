<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\StudentParent;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $parent = auth()->user()->parentProfile()->firstOrFail();

        $myChildren = StudentParent::where('parent_id', $parent->parent_id)
            ->with('student')
            ->get()
            ->pluck('student');

        $childIds = $myChildren->pluck('student_id');

        $query = Grade::whereIn('student_id', $childIds)->with(['student', 'subject']);

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        $grades = $query->orderByDesc('semester')->paginate(20)->withQueryString();

        return view('Parent.grades.index', compact('grades', 'myChildren'));
    }
}