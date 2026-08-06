<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Exam;
use App\Models\StudentParent;
use App\Models\Payment;
use App\Models\ActivityLog;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\User;

class DashboardController extends Controller
{
    public function dashboard()
{
    $studentCount = Student::count();
    $activeStudentCount = Student::where('status', 'active')->count();
    $teacherCount = Teacher::count();
    $classCount = SchoolClass::count();

    $outstandingTotal = Payment::whereColumn('amount_paid', '<', 'total_fee')
        ->get()
        ->sum(fn ($p) => $p->total_fee - $p->amount_paid);

    $studentGrowth = $this->percentChangeThisMonth(Student::class);

    // Payments collected per month, last 6 months — used for the chart.
    $months = collect(range(5, 0))->map(fn ($i) => now()->subMonths($i)->startOfMonth());

    $monthlyCollected = $months->map(function ($month) {
        $total = Payment::whereYear('payment_date', $month->year)
            ->whereMonth('payment_date', $month->month)
            ->sum('amount_paid');

        return ['label' => $month->format('M'), 'total' => (float) $total];
    });

    $maxCollected = max(1, $monthlyCollected->max('total'));

    $recentActivity = ActivityLog::with('user')
        ->latest('created_at')
        ->take(5)
        ->get();

    $recentUsers = User::latest('created_at')->take(5)->get();

    return view('Admin.dashboard', compact(
        'studentCount',
        'activeStudentCount',
        'teacherCount',
        'classCount',
        'outstandingTotal',
        'studentGrowth',
        'monthlyCollected',
        'maxCollected',
        'recentActivity',
        'recentUsers',
    ));
}

/**
 * Percent change in new rows created this calendar month vs last month.
 */
private function percentChangeThisMonth(string $modelClass): ?float
{
    $thisMonth = $modelClass::whereYear('created_at', now()->year)
        ->whereMonth('created_at', now()->month)
        ->count();

    $lastMonthDate = now()->subMonth();
    $lastMonth = $modelClass::whereYear('created_at', $lastMonthDate->year)
        ->whereMonth('created_at', $lastMonthDate->month)
        ->count();

    if ($lastMonth === 0) {
        return null;
    }

    return round((($thisMonth - $lastMonth) / $lastMonth) * 100, 1);
}
public function dashboardParent()
{
    $parent = auth()->user()->parentProfile()->firstOrFail();

    $children = StudentParent::where('parent_id', $parent->parent_id)
        ->with('student.schoolClass')
        ->get()
        ->map(function (StudentParent $link) {
            $student = $link->student;

            $attendanceSummary = Attendance::where('student_id', $student->student_id)
                ->selectRaw('status, count(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status');

            $outstandingBalance = Payment::where('student_id', $student->student_id)
                ->get()
                ->sum(fn ($p) => $p->total_fee - ($p->discount ?? 0) - $p->amount_paid);

            return [
                'student' => $student,
                'is_primary' => $link->is_primary,
                'attendance' => $attendanceSummary,
                'outstanding_balance' => $outstandingBalance,
            ];
        });

    return view('Parent.dashboard-parent', compact('parent', 'children'));
}
    public function dashboardTeacher()
{
    $teacher = auth()->user()->teacher()->firstOrFail();

    $todaySchedule = Schedule::where('teacher_id', $teacher->teacher_id)
        ->where('day_of_week', now()->format('l'))
        ->with(['subject', 'schoolClass'])
        ->orderBy('start_time')
        ->get();

    $mySchedules = Schedule::where('teacher_id', $teacher->teacher_id)->get();

    $classCount = $mySchedules->pluck('class_id')->unique()->count();
    $subjectCount = $mySchedules->pluck('subject_id')->unique()->count();

    $recentAttendance = Attendance::whereIn('schedule_id', $mySchedules->pluck('schedule_id'))
        ->with('student')
        ->latest('date')
        ->take(5)
        ->get();

    // Students taught by this teacher missing a final_score for the current semester
    $studentIdsTaught = Attendance::whereIn('schedule_id', $mySchedules->pluck('schedule_id'))
        ->distinct()
        ->pluck('student_id');

    $pendingGrading = Grade::whereIn('student_id', $studentIdsTaught)
        ->whereIn('subject_id', $mySchedules->pluck('subject_id')->unique())
        ->whereNull('final_score')
        ->count();

    return view('Teacher.dashboardTeacher', compact(
        'teacher', 'todaySchedule', 'classCount', 'subjectCount', 'recentAttendance', 'pendingGrading'
    ));
}
   public function dashboardStudent()
{
    $student = auth()->user()->student()->with('schoolClass')->firstOrFail();

    $todaySchedule = Schedule::where('class_id', $student->class_id)
        ->where('day_of_week', now()->format('l')) // e.g. "Monday"
        ->with(['subject', 'teacher'])
        ->orderBy('start_time')
        ->get();

    $attendanceSummary = Attendance::where('student_id', $student->student_id)
        ->selectRaw('status, count(*) as total')
        ->groupBy('status')
        ->pluck('total', 'status'); // e.g. ['present' => 42, 'absent' => 3]

    $recentGrades = Grade::where('student_id', $student->student_id)
        ->with('subject')
        ->latest('grade_id')
        ->take(5)
        ->get();

    $upcomingExams = Exam::where('class_id', $student->class_id)
        ->where('exam_date', '>=', now()->toDateString())
        ->with('subject')
        ->orderBy('exam_date')
        ->take(5)
        ->get();

    return view('Student.dashboardStudent', compact(
        'student', 'todaySchedule', 'attendanceSummary', 'recentGrades', 'upcomingExams'
    ));
}
}
