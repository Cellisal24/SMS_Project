<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Exam;
use App\Models\Grade;
use App\Models\Payment;
use App\Models\Student;
use App\Models\StudentParent;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class ChildController extends Controller
{
    public function index()
    {
        $parent = auth()->user()->parentProfile()->firstOrFail();

        $children = StudentParent::where('parent_id', $parent->parent_id)
            ->with('student.schoolClass')
            ->get()
            ->map(function (StudentParent $link) {
                $student = $link->student;

                return [
                    'student' => $student,
                    'is_primary' => $link->is_primary,
                    'relationship' => $link->relationship,
                ];
            });

        return view('Parent.children.index', compact('parent', 'children'));
    }

    public function show(Student $student)
    {
        $this->assertIsMyChild($student);

        $attendanceSummary = Attendance::where('student_id', $student->student_id)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $grades = Grade::where('student_id', $student->student_id)
            ->with('subject')
            ->orderBy('semester')
            ->get()
            ->groupBy('semester');

        $upcomingExams = Exam::where('class_id', $student->class_id)
            ->where('exam_date', '>=', now()->toDateString())
            ->with('subject')
            ->orderBy('exam_date')
            ->take(5)
            ->get();

        $payments = Payment::where('student_id', $student->student_id)
            ->orderByDesc('payment_date')
            ->get();

        return view('Parent.children.show', compact(
            'student', 'attendanceSummary', 'grades', 'upcomingExams', 'payments'
        ));
    }

    /**
     * A parent may only view children actually linked to them via
     * student_parents — never someone else's child by guessing an ID.
     */
    protected function assertIsMyChild(Student $student): void
    {
        $parent = auth()->user()->parentProfile;

        $isLinked = $parent && StudentParent::where('parent_id', $parent->parent_id)
            ->where('student_id', $student->student_id)
            ->exists();

        if (! $isLinked) {
            throw new AccessDeniedHttpException('This student is not linked to your account.');
        }
    }
}