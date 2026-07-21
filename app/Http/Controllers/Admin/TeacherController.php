<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    private function normalizeGender(string $gender): string
    {
        return match ($gender) {
            'Male', 'M' => 'M',
            'Female', 'F' => 'F',
            'Other', 'O' => 'O',
            default => 'O',
        };
    }

    // Display list with search & filter
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search'));
        $gender = $request->input('gender');

        $teachers = Teacher::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('teacher_id', $search)
                      ->orWhere('teacher_id', 'like', "%{$search}%")
                      ->orWhere('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('contact_number', 'like', "%{$search}%");
                });
            })
            ->when($gender !== null && $gender !== '', function ($query) use ($gender) {
                $query->where('gender', $this->normalizeGender($gender));
            })
            ->orderBy('teacher_id')
            ->paginate(10)
            ->withQueryString(); // Keeps search & filter params in pagination links

        return view('Admin.Teacher.index', compact('teachers', 'search', 'gender'));
    }

    // Show create form
    public function create()
    {
        return view('Admin.Teacher.create');
    }

    // Store new teacher
    public function store(Request $request)
    {
        $validated = $request->validate([
            'teacher_id'     => 'required|string|max:50|unique:teachers,teacher_id',
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'gender'         => 'required|in:Male,Female,Other',
            'email'          => 'required|email|unique:teachers,email',
            'contact_number' => 'nullable|string|max:20',
        ]);

        $validated['gender'] = $this->normalizeGender($validated['gender']);

        Teacher::create($validated);

        return redirect()->route('teachers.index')->with('success', 'Teacher added successfully!');
    }

    public function show(Teacher $teacher)
    {
        return view('Admin.Teacher.show', compact('teacher'));
    }

    // Show edit form
    public function edit(Teacher $teacher)
    {
        return view('Admin.Teacher.edit', compact('teacher'));
    }

    // Update teacher details
    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'first_name'     => 'required|string|max:100',
            'last_name'      => 'required|string|max:100',
            'gender'         => 'required|in:Male,Female,Other',
            'email'          => 'required|email|unique:teachers,email,' . $teacher->teacher_id . ',teacher_id',
            'contact_number' => 'nullable|string|max:20',
        ]);

        $validated['gender'] = $this->normalizeGender($validated['gender']);

        $teacher->update($validated);

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully!');
    }

    // Delete teacher
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully!');
    }
}