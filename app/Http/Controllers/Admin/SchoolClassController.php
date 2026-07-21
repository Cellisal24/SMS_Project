<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GradeLevel;
use App\Models\Room;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    // 1. បង្ហាញបញ្ជីថ្នាក់រៀន + Search & Filter
    public function index(Request $request)
    {
        $search = $request->input('search');
        $level_id = $request->input('level_id');
        $academic_year = $request->input('academic_year');

        $classes = SchoolClass::with(['gradeLevel', 'room'])
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('class_id', 'LIKE', "%{$search}%")
                      ->orWhere('class_name', 'LIKE', "%{$search}%");
                });
            })
            ->when($level_id, function ($query, $level_id) {
                return $query->where('level_id', $level_id);
            })
            ->when($academic_year, function ($query, $academic_year) {
                return $query->where('academic_year', $academic_year);
            })
            ->orderBy('class_id', 'asc')
            ->paginate(10)
            ->withQueryString();

        // ទាញយកទិន្នន័យ Filter Dropdown
        $gradeLevels = GradeLevel::orderBy('sort_order')->get();
        
        // ទាញយកឆ្នាំសិក្សាពី Database មកដាក់ក្នុង Dropdown Filter
        $academicYears = SchoolClass::select('academic_year')->distinct()->orderBy('academic_year', 'desc')->pluck('academic_year');

        return view('admin.schoolclass.index', compact('classes', 'gradeLevels', 'academicYears'));
    }

    // 2. ផ្ទាំងបង្កើតថ្នាក់រៀនថ្មី
    public function create()
    {
        $gradeLevels = GradeLevel::orderBy('sort_order')->get();
        $rooms = Room::orderBy('room_id')->get();
        
        return view('admin.schoolclass.create', compact('gradeLevels', 'rooms'));
    }

    // 3. រក្សាទុកទិន្នន័យ
    public function store(Request $request)
    {
        $request->validate([
            'class_id'      => 'required|string|max:10|unique:classes,class_id', // unique ទៅកាន់តារាង classes
            'class_name'    => 'required|string|max:30',
            'level_id'      => 'required|exists:grade_levels,level_id',
            'room_id'       => 'nullable|exists:rooms,room_id',
            'academic_year' => 'required|integer|digits:4',
        ]);

        SchoolClass::create($request->all());

        return redirect()->route('school-classes.index')->with('success', 'បានបង្កើតថ្នាក់រៀនថ្មីជោគជ័យ!');
    }

    // 4. ផ្ទាំងកែប្រែទិន្នន័យ
    public function edit(SchoolClass $schoolClass)
    {
        $gradeLevels = GradeLevel::orderBy('sort_order')->get();
        $rooms = Room::orderBy('room_id')->get();
        
        return view('admin.schoolclass.edit', compact('schoolClass', 'gradeLevels', 'rooms'));
    }

    // 5. ធ្វើបច្ចុប្បន្នភាពទិន្នន័យ
    public function update(Request $request, SchoolClass $schoolClass)
    {
        $request->validate([
            'class_name'    => 'required|string|max:30',
            'level_id'      => 'required|exists:grade_levels,level_id',
            'room_id'       => 'nullable|exists:rooms,room_id',
            'academic_year' => 'required|integer|digits:4',
        ]);

        $schoolClass->update($request->all());

        return redirect()->route('school-classes.index')->with('success', 'បានកែប្រែព័ត៌មានថ្នាក់រៀនជោគជ័យ!');
    }

    // 6. លុបទិន្នន័យ
    public function destroy(SchoolClass $schoolClass)
    {
        $schoolClass->delete();
        
        return redirect()->route('school-classes.index')->with('success', 'បានលុបថ្នាក់រៀនជោគជ័យ!');
    }
}