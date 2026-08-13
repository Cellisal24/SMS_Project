<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
    private function createLoginAccount(Teacher $teacher): array
{
    $existing = User::where('teacher_id', $teacher->teacher_id)->first();

    if ($existing) {
        return ['user' => $existing, 'created' => false, 'plainPassword' => null];
    }

    $plainPassword = Str::password(10, symbols: false);

    $user = User::create([
        'username' => strtolower($teacher->teacher_id),
        'password_hash' => Hash::make($plainPassword),
        'teacher_id' => $teacher->teacher_id,
        'role' => 'teacher',
    ]);

    return ['user' => $user, 'created' => true, 'plainPassword' => $plainPassword];
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

        return view('admin.teacher.index', compact('teachers', 'search', 'gender'));
    }

    // Show create form
    public function create()
    {
        return view('admin.teacher.create');
    }

    // Store new teacher
   public function store(Request $request)
{
     $validated = $request->validate([
        'first_name'     => 'required|string|max:100',
        'last_name'      => 'required|string|max:100',
        'gender'         => 'required|in:Male,Female,Other',
        'email'          => 'required|email|unique:teachers,email',
        'contact_number' => 'nullable|string|max:20',
        'photo'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $validated['gender'] = $this->normalizeGender($validated['gender']);

    if ($request->hasFile('photo')) {
        $validated['photo'] = $request->file('photo')->store('photos/teachers', 'public');
    }

    $teacher = Teacher::create($validated);

    $account = $this->createLoginAccount($teacher);

    $response = redirect()->route('teachers.index')->with('success', 'Teacher added successfully!');

    if ($account['created']) {
        $response->with('reset_credentials', [
            'name' => "{$teacher->first_name} {$teacher->last_name}",
            'username' => $account['user']->username,
            'password' => $account['plainPassword'],
        ]);
    }

    return $response;
}

    public function show(Teacher $teacher)
    {
        return view('admin.teacher.show', compact('teacher'));
    }

    // Show edit form
    public function edit(Teacher $teacher)
    {
        return view('admin.teacher.edit', compact('teacher'));
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
        'photo'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $validated['gender'] = $this->normalizeGender($validated['gender']);

    if ($request->hasFile('photo')) {
        if ($teacher->photo) {
            Storage::disk('public')->delete($teacher->photo);
        }
        $validated['photo'] = $request->file('photo')->store('photos/teachers', 'public');
    }

    $teacher->update($validated);

    return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully!');
    }

    // Delete teacher
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully!');
    }
    public function resetPassword(Teacher $teacher)
{
    $user = User::where('teacher_id', $teacher->teacher_id)->first();

    if (! $user) {
        return back()->with('error', "No login account exists yet for {$teacher->first_name} {$teacher->last_name}.");
    }

    $plainPassword = Str::password(10, symbols: false);
    $user->update(['password_hash' => Hash::make($plainPassword)]);

    return back()->with('reset_credentials', [
        'name' => "{$teacher->first_name} {$teacher->last_name}",
        'username' => $user->username,
        'password' => $plainPassword,
    ]);
}
}

