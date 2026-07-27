<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student()->firstOrFail();

        $schedules = Schedule::where('class_id', $student->class_id)
            ->with(['subject', 'teacher'])
            ->orderByRaw("FIELD(day_of_week, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')")
            ->orderBy('start_time')
            ->get()
            ->groupBy('day_of_week');

        return view('Student.schedule.index', compact('student', 'schedules'));
    }
}