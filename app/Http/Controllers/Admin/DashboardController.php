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

class DashboardController extends Controller
{
    public function dashboard()
    {
        $subjectCount = Subject::count();
        $recentSubjects = Subject::latest('created_at')->take(5)->get();

        return view('Admin.dashboard', compact('subjectCount', 'recentSubjects'));
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

            $recentGrades = Grade::where('student_id', $student->student_id)
                ->with('subject')
                ->latest('grade_id')
                ->take(3)
                ->get();

            $outstandingPayments = Payment::where('student_id', $student->student_id)
                ->whereColumn('amount_paid', '<', 'total_fee')
                ->get();

            return [
                'student' => $student,
                'is_primary' => $link->is_primary,
                'attendance' => $attendanceSummary,
                'grades' => $recentGrades,
                'payments' => $outstandingPayments,
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
