<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamResult;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class ExamResultController extends Controller
{
    // បង្ហាញបញ្ជីពិន្ទុ + Search/Filter
    public function index(Request $request)
    {
        $query = ExamResult::with(['exam.subject', 'exam.schoolClass', 'student']);

        // Search តាមឈ្មោះ ឬ ID សិស្ស
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('student_id', 'like', "%{$search}%")
                  ->orWhereHas('student', function ($sq) use ($search) {
                      $sq->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter តាមថ្នាក់
        if ($classId = $request->input('class_id')) {
            $query->whereHas('exam', function ($q) use ($classId) {
                $q->where('class_id', $classId);
            });
        }

        // Filter តាមមុខវិជ្ជា
        if ($subjectId = $request->input('subject_id')) {
            $query->whereHas('exam', function ($q) use ($subjectId) {
                $q->where('subject_id', $subjectId);
            });
        }

        $results = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();
        $classes = SchoolClass::all();
        $subjects = Subject::all();

        return view('admin.exam_results.index', compact('results', 'classes', 'subjects'));
    }

    // បញ្ចូលពិន្ទុតាមថ្នាក់
    public function enterScores(Exam $exam)
    {
        $exam->load('schoolClass', 'subject');
        $students = Student::where('class_id', $exam->class_id)->get();
        $existingResults = ExamResult::where('exam_id', $exam->exam_id)->get()->keyBy('student_id');

        return view('admin.exam_results.enter_scores', compact('exam', 'students', 'existingResults'));
    }

    // រក្សាទុកពិន្ទុ
  public function storeScores(Request $request, Exam $exam)
{
    $maxScore = $exam->max_score ?? 100;

    $request->validate([
        'scores' => 'required|array',
        'scores.*' => 'nullable|numeric|min:0|max:' . $maxScore,
    ]);

    foreach ($request->scores as $studentId => $score) {
        if ($score !== null) {
            
            // គណនាភាគរយ (Percentage) ដើម្បីយកទៅប្រៀបធៀបជាមួយ Grade A, B, C, D, E, F
            $percentage = $maxScore > 0 ? ($score / $maxScore) * 100 : 0;
            $remarks = $this->calculateRemark($percentage);

            ExamResult::updateOrCreate(
                [
                    'exam_id' => $exam->exam_id,
                    'student_id' => $studentId,
                ],
                [
                    'score' => $score,
                    'max_score' => $maxScore,
                    'remarks' => $remarks, // រក្សាទុក "A", "B", "C", "D", "E", ឬ "F"
                ]
            );
        }
    }

    return redirect()->back()->with('success', 'រក្សាទុកពិន្ទុបានជោគជ័យ!');
}

// 🧠 Function លក្ខខណ្ឌតាមរូបភាព (Python logic -> PHP logic)
private function calculateRemark($marks)
{
    if ($marks >= 90) {
        return "A";
    } elseif ($marks >= 80) {
        return "B";
    } elseif ($marks >= 70) {
        return "C";
    } elseif ($marks >= 60) {
        return "D";
    } elseif ($marks >= 50) {
        return "E";
    } else {
        return "F";
    }
}

    // លុបពិន្ទុ single row
    public function destroy(ExamResult $examResult)
    {
        $examResult->delete();
        return redirect()->back()->with('success', 'លុបទិន្នន័យពិន្ទុរួចរាល់!');
    }
}
