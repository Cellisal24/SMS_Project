<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $student = auth()->user()->student()->firstOrFail();

        $query = Attendance::where('student_id', $student->student_id)
            ->with(['schedule.subject']);

        if ($request->filled('month')) {
            $query->whereMonth('date', $request->month);
        }

        $records = $query->orderByDesc('date')->paginate(20)->withQueryString();

        $summary = Attendance::where('student_id', $student->student_id)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('Student.attendance.index', compact('student', 'records', 'summary'));
    }
}