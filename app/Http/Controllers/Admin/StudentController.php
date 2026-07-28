<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParentModel;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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
    $classes = SchoolClass::orderBy('class_name')->get();

    return view('admin.students.create', compact('parents', 'classes'));
}

   public function store(Request $request)
{
    $validated = $this->validateStudent($request);

    $student = Student::create($validated);

    $this->syncParents($student, $request);

    $account = $this->createLoginAccount($student);

    $response = redirect()
        ->route('admin.students.index')
        ->with('success', "Student {$student->fullName()} created successfully.");

    if ($account['created']) {
        $response->with('reset_credentials', [
            'name' => $student->fullName(),
            'username' => $account['user']->username,
            'password' => $account['plainPassword'],
        ]);
    }

    return $response;
}

   public function edit(Student $student)
{
    $student->load('parents');
    $parents = ParentModel::orderBy('first_name')->get();
    $classes = SchoolClass::orderBy('class_name')->get();

    return view('admin.students.edit', compact('student', 'parents', 'classes'));
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
        'class_id'      => ['nullable', 'string', 'max:10', 'exists:classes,class_id'],
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
   private function createLoginAccount(Student $student): array
{
    $existing = User::where('student_id', $student->student_id)->first();

    if ($existing) {
        return ['user' => $existing, 'created' => false, 'plainPassword' => null];
    }

    $plainPassword = Str::password(10, symbols: false); // e.g. "aX7pQr2Zt9" — no symbols, easier to relay verbally/in writing

    $user = User::create([
        'username' => strtolower($student->student_id),
        'password_hash' => Hash::make($plainPassword),
        'student_id' => $student->student_id,
        'role' => 'student',
    ]);

    return ['user' => $user, 'created' => true, 'plainPassword' => $plainPassword];
}
public function resetPassword(Student $student)
{
    $user = User::where('student_id', $student->student_id)->first();

    if (! $user) {
        return back()->with('error', "No login account exists yet for {$student->fullName()}.");
    }

    $plainPassword = Str::password(10, symbols: false);
    $user->update(['password_hash' => Hash::make($plainPassword)]);

    return back()->with('reset_credentials', [
        'name' => $student->fullName(),
        'username' => $user->username,
        'password' => $plainPassword,
    ]);
}
}