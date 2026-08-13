<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Schedule;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::where('teacher_id', auth()->user()->teacher_id)
            ->with(['subject', 'schoolClass'])
            ->orderByRaw("FIELD(day_of_week, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')")
            ->orderBy('start_time')
            ->get()
            ->groupBy('day_of_week');

        return view('teacher.schedule.index', compact('schedules'));
    }
}
