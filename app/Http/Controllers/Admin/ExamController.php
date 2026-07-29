<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Room;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $query = Exam::with(['subject', 'schoolClass', 'room']);

        // 1. Search តាមឈ្មោះមុខវិជ្ជា ឬ ID មុខវិជ្ជា
        if ($search = $request->input('search')) {
            $query->whereHas('subject', function ($q) use ($search) {
                $q->where('subject_name', 'like', "%{$search}%")
                  ->orWhere('subject_id', 'like', "%{$search}%");
            });
        }

        // 2. Filter តាមថ្នាក់រៀន
        if ($classId = $request->input('class_id')) {
            $query->where('class_id', $classId);
        }

        // 3. Filter តាមឆមាស
        if ($semester = $request->input('semester')) {
            $query->where('semester', $semester);
        }

        // 4. Filter តាមឆ្នាំសិក្សា
        if ($academicYear = $request->input('academic_year')) {
            $query->where('academic_year', $academicYear);
        }

        $exams = $query->orderBy('exam_date', 'desc')->paginate(15)->withQueryString();
        $classes = SchoolClass::all();

        return view('admin.exams.index', compact('exams', 'classes'));
    }

    public function create()
    {
        $subjects = Subject::all();
        $classes = SchoolClass::all();
        $rooms = Room::all();

        return view('admin.exams.create', compact('subjects', 'classes', 'rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_id'    => 'required|exists:subjects,subject_id',
            'class_id'      => 'nullable|exists:classes,class_id',
            'room_id'       => 'nullable|exists:rooms,room_id',
            'semester'      => 'nullable|string|max:15',
            'exam_date'     => 'required|date',
            'start_time'    => 'nullable',
            'end_time'      => 'nullable',
            'academic_year' => 'nullable|integer',
        ]);

        Exam::create($validated);

        return redirect()->route('admin.exams.index')->with('success', 'បង្កើតការប្រឡងបានជោគជ័យ!');
    }

    public function edit(Exam $exam)
    {
        $subjects = Subject::all();
        $classes = SchoolClass::all();
        $rooms = Room::all();

        return view('admin.exams.edit', compact('exam', 'subjects', 'classes', 'rooms'));
    }

    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'subject_id'    => 'required|exists:subjects,subject_id',
            'class_id'      => 'nullable|exists:classes,class_id',
            'room_id'       => 'nullable|exists:rooms,room_id',
            'semester'      => 'nullable|string|max:15',
            'exam_date'     => 'required|date',
            'start_time'    => 'nullable',
            'end_time'      => 'nullable',
            'academic_year' => 'nullable|integer',
        ]);

        $exam->update($validated);

        return redirect()->route('admin.exams.index')->with('success', 'ធ្វើបច្ចុប្បន្នភាពការប្រឡងបានជោគជ័យ!');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('admin.exams.index')->with('success', 'លុបការប្រឡងរួចរាល់!');
    }
}
