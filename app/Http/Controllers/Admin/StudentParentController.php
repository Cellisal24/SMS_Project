<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParentModel;
use App\Models\Student;
use App\Models\StudentParent;
use Illuminate\Http\Request;

class StudentParentController extends Controller
{
    public function index(Request $request)
    {
        $query = StudentParent::query()->with(['student', 'parent']);

        if ($search = $request->input('search')) {
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            })->orWhereHas('parent', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        if ($relationship = $request->input('relationship')) {
            $query->where('relationship', $relationship);
        }

        $studentParents = $query->orderByDesc('id')->paginate(15)->withQueryString();

        return view('Admin.student_parents.index', compact('studentParents'));
    }

    public function create()
    {
        $students = Student::orderBy('first_name')->get();
        $parents = ParentModel::orderBy('first_name')->get();

        return view('Admin.student_parents.create', compact('students', 'parents'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateLink($request);
        $validated['is_primary'] = $request->boolean('is_primary');

        if ($validated['is_primary']) {
            StudentParent::where('student_id', $validated['student_id'])->update(['is_primary' => false]);
        }

        StudentParent::create($validated);

        return redirect()
            ->route('admin.student_parents.index')
            ->with('success', 'Parent-student link created successfully.');
    }

    public function edit(StudentParent $studentParent)
    {
        $students = Student::orderBy('first_name')->get();
        $parents = ParentModel::orderBy('first_name')->get();

        return view('Admin.student_parents.edit', compact('studentParent', 'students', 'parents'));
    }

    public function update(Request $request, StudentParent $studentParent)
    {
        $validated = $this->validateLink($request, $studentParent->id);
        $validated['is_primary'] = $request->boolean('is_primary');

        if ($validated['is_primary']) {
            StudentParent::where('student_id', $validated['student_id'])
                ->where('id', '!=', $studentParent->id)
                ->update(['is_primary' => false]);
        }

        $studentParent->update($validated);

        return redirect()
            ->route('admin.student_parents.index')
            ->with('success', 'Parent-student link updated successfully.');
    }

    public function destroy(StudentParent $studentParent)
    {
        $studentParent->delete();

        return redirect()
            ->route('admin.student_parents.index')
            ->with('success', 'Parent-student link removed successfully.');
    }

    private function validateLink(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'student_id'   => [
                'required', 'string', 'exists:students,student_id',
                'unique:student_parents,student_id,' . ($ignoreId ?? 'NULL') . ',id,parent_id,' . $request->input('parent_id'),
            ],
            'parent_id'    => ['required', 'string', 'exists:parents,parent_id'],
            'relationship' => ['nullable', 'string', 'max:30'],
            'is_primary'   => ['nullable', 'boolean'],
        ]);
    }
}