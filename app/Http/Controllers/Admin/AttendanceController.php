<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\Student;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with(['student', 'schedule.subject', 'schedule.schoolClass']);

        if (auth()->user()->role === 'teacher') {
            $query->whereHas('schedule', fn ($q) => $q->where('teacher_id', auth()->user()->teacher_id));
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        if ($request->filled('class_id')) {
            $query->whereHas('schedule', fn ($q) => $q->where('class_id', $request->class_id));
        }

        $records = $query->latest('date')->paginate(20)->withQueryString();

        return view('Admin.attendance.index', compact('records'));
    }

    public function create()
    {
        $schedulesQuery = Schedule::with(['subject', 'schoolClass']);

        if (auth()->user()->role === 'teacher') {
            $schedulesQuery->where('teacher_id', auth()->user()->teacher_id);
        }

        $schedules = $schedulesQuery->orderBy('day_of_week')->get();

        return view('Admin.attendance.create', compact('schedules'));
    }

    public function roster(Request $request)
    {
        $data = $request->validate([
            'schedule_id' => ['required', 'exists:schedules,schedule_id'],
            'date' => ['required', 'date'],
        ]);

        $schedule = Schedule::with('schoolClass')->findOrFail($data['schedule_id']);

        $this->assertOwnsSchedule($schedule);

        $students = Student::where('class_id', $schedule->class_id)
            ->orderBy('first_name')
            ->get();

        $existing = Attendance::where('schedule_id', $data['schedule_id'])
            ->whereDate('date', $data['date'])
            ->pluck('status', 'student_id');

        return response()->json([
            'students' => $students->map(fn ($s) => [
                'student_id' => $s->student_id,
                'name' => "{$s->first_name} {$s->last_name}",
                'status' => $existing[$s->student_id] ?? 'present',
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'schedule_id' => ['required', 'exists:schedules,schedule_id'],
            'date' => ['required', 'date'],
            'students' => ['required', 'array', 'min:1'],
            'students.*.student_id' => ['required', 'exists:students,student_id'],
            'students.*.status' => ['required', 'in:present,absent,late,excused'],
            'students.*.leave_reason' => ['nullable', 'string', 'max:255'],
        ]);

        $schedule = Schedule::findOrFail($data['schedule_id']);
        $this->assertOwnsSchedule($schedule);

        foreach ($data['students'] as $entry) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $entry['student_id'],
                    'schedule_id' => $data['schedule_id'],
                    'date' => $data['date'],
                ],
                [
                    'status' => $entry['status'],
                    'leave_reason' => $entry['leave_reason'] ?? null,
                ]
            );
        }

        return redirect()->route('admin.attendance.index')
            ->with('status', 'Attendance saved for ' . count($data['students']) . ' students.');
    }

    public function edit(Attendance $attendance)
    {
        $this->assertOwnsSchedule($attendance->schedule);

        return view('Admin.attendance.edit', compact('attendance'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $this->assertOwnsSchedule($attendance->schedule);

        $data = $request->validate([
            'status' => ['required', 'in:present,absent,late,excused'],
            'leave_reason' => ['nullable', 'string', 'max:255'],
        ]);

        $attendance->update($data);

        return redirect()->route('admin.attendance.index')->with('status', 'Attendance record updated.');
    }

    public function destroy(Attendance $attendance)
    {
        $this->assertOwnsSchedule($attendance->schedule);

        $attendance->delete();

        return redirect()->route('admin.attendance.index')->with('status', 'Attendance record deleted.');
    }

    /**
     * A teacher may only touch schedules that belong to them.
     * Admins bypass this check entirely.
     */
    protected function assertOwnsSchedule($schedule): void
    {
        if (auth()->user()->role === 'teacher' && $schedule->teacher_id !== auth()->user()->teacher_id) {
            throw new AccessDeniedHttpException('You can only manage attendance for your own classes.');
        }
    }
}