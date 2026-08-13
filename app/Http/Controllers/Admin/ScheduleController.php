<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ScheduleController extends Controller
{
    protected array $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    public function index(Request $request)
    {
        $query = Schedule::with(['schoolClass', 'subject', 'teacher']);

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        $schedules = $query
            ->orderByRaw("FIELD(day_of_week, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')")
            ->orderBy('start_time')
            ->paginate(20)
            ->withQueryString();

        $classes = SchoolClass::orderBy('class_name')->get();
        $teachers = Teacher::orderBy('first_name')->get();

        return view('admin.schedules.index', compact('schedules', 'classes', 'teachers'));
    }

    public function create()
    {
        $classes = SchoolClass::orderBy('class_name')->get();
        $subjects = Subject::orderBy('subject_name')->get();
        $teachers = Teacher::orderBy('first_name')->get();
        $days = $this->days;

        return view('admin.schedules.create', compact('classes', 'subjects', 'teachers', 'days'));
    }

    public function store(Request $request)
    {
        $data = $this->validateSchedule($request);

        Schedule::create($data);

        return redirect()->route('admin.schedules.index')->with('status', 'Schedule created successfully.');
    }

    public function edit(Schedule $schedule)
    {
        $classes = SchoolClass::orderBy('class_name')->get();
        $subjects = Subject::orderBy('subject_name')->get();
        $teachers = Teacher::orderBy('first_name')->get();
        $days = $this->days;

        return view('admin.schedules.edit', compact('schedule', 'classes', 'subjects', 'teachers', 'days'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $data = $this->validateSchedule($request, $schedule->schedule_id);

        $schedule->update($data);

        return redirect()->route('admin.schedules.index')->with('status', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('admin.schedules.index')->with('status', 'Schedule deleted.');
    }

    protected function validateSchedule(Request $request, ?int $ignoreId = null): array
    {
        $data = $request->validate([
            'class_id' => ['required', 'exists:classes,class_id'],
            'subject_id' => ['required', 'exists:subjects,subject_id'],
            'teacher_id' => ['required', 'exists:teachers,teacher_id'],
            'day_of_week' => ['required', Rule::in($this->days)],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
        ]);

        // Prevent the same teacher being double-booked at an overlapping time
        $teacherConflict = Schedule::where('teacher_id', $data['teacher_id'])
            ->where('day_of_week', $data['day_of_week'])
            ->where('start_time', '<', $data['end_time'])
            ->where('end_time', '>', $data['start_time'])
            ->when($ignoreId, fn ($q) => $q->where('schedule_id', '!=', $ignoreId))
            ->exists();

        if ($teacherConflict) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'teacher_id' => 'This teacher already has another class scheduled at an overlapping time.',
            ]);
        }

        // Prevent the same class having two subjects scheduled at once
        $classConflict = Schedule::where('class_id', $data['class_id'])
            ->where('day_of_week', $data['day_of_week'])
            ->where('start_time', '<', $data['end_time'])
            ->where('end_time', '>', $data['start_time'])
            ->when($ignoreId, fn ($q) => $q->where('schedule_id', '!=', $ignoreId))
            ->exists();

        if ($classConflict) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'class_id' => 'This class already has another subject scheduled at an overlapping time.',
            ]);
        }

        return $data;
    }
}
