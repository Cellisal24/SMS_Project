<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\StudentParent;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $parent = auth()->user()->parentProfile()->firstOrFail();

        $myChildren = StudentParent::where('parent_id', $parent->parent_id)
            ->with('student')
            ->get()
            ->pluck('student');

        $childIds = $myChildren->pluck('student_id');

        $query = Attendance::whereIn('student_id', $childIds)->with(['student', 'schedule.subject']);

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        $records = $query->orderByDesc('date')->paginate(20)->withQueryString();

        return view('Parent.attendance.index', compact('records', 'myChildren'));
    }
}
