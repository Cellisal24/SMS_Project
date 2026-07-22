<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParentModel;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Room;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query()->with('schoolClass');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $students = $query->orderBy('last_name')->paginate(15)->withQueryString();

        return view('admin.students.index', compact('students'));
    }

   public function create()
{
    $parents = ParentModel::orderBy('first_name')->get();
    $rooms = Room::orderBy('room_name')->get();

    return view('admin.students.create', compact('parents', 'rooms'));
}

   public function store(Request $request)
{
    $validated = $this->validateStudent($request);

    $student = Student::create($validated);

    $this->syncParents($student, $request);

    return redirect()
        ->route('admin.students.index')
        ->with('success', "Student {$student->fullName()} created successfully.");
}

   public function edit(Student $student)
{
    $student->load('parents');
    $parents = ParentModel::orderBy('first_name')->get();
    $rooms = Room::orderBy('room_name')->get();

    return view('admin.students.edit', compact('student', 'parents', 'rooms'));
}

    public function update(Request $request, Student $student)
{
    $validated = $this->validateStudent($request, $student->student_id);

    $student->update($validated);

    $this->syncParents($student, $request);

    return redirect()
        ->route('admin.students.index')
        ->with('success', "Student {$student->fullName()} updated successfully.");
}

    public function destroy(Student $student)
    {
        $name = $student->fullName();
        $student->delete();

        return redirect()
            ->route('admin.students.index')
            ->with('success', "Student {$name} deleted successfully.");
    }

    private function validateStudent(Request $request, ?string $studentId = null): array
{
    return $request->validate([
        'first_name'    => ['required', 'string', 'max:50'],
        'last_name'     => ['required', 'string', 'max:50'],
        'gender'        => ['required', 'in:M,F'],
        'date_of_birth' => ['required', 'date'],
        'class_id'      => ['nullable', 'string', 'max:10', 'exists:rooms,room_id'],
        'parent_phone'  => ['nullable', 'string', 'max:20'],
        'status'        => ['required', 'in:active,inactive,graduated,transferred'],
    ]);
}

    private function syncParents(Student $student, Request $request): void
    {
        $parentIds = $request->input('parent_ids', []);
        $relationships = $request->input('relationships', []);
        $primaryParentId = $request->input('primary_parent_id');

        $syncData = [];
        foreach ($parentIds as $parentId) {
            $syncData[$parentId] = [
                'relationship' => $relationships[$parentId] ?? null,
                'is_primary'   => $parentId === $primaryParentId,
            ];
        }

        $student->parents()->sync($syncData);
    }
}