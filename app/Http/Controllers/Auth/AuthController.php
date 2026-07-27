<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'username' => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    if (Auth::attempt([
        'username' => $credentials['username'],
        'password' => $credentials['password'],
    ], false)) {

        /** @var User $user */
        $user = Auth::user();

        // Admins must use the separate /admin/login page
        if ($user->role === 'admin') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors(['username' => 'Admin accounts must sign in through the admin login page.'])
                ->onlyInput('username');
        }

        $request->session()->regenerate();

        return redirect()->intended($this->redirectPathForRole($user->role));
    }

    return back()
        ->withErrors(['username' => 'Those credentials do not match our records.'])
        ->onlyInput('username');
}

    public function showRegister()
    {
        // Gate this route behind 'role:admin' middleware in routes
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['admin', 'teacher', 'student', 'parent'])],
            'student_id' => ['nullable', 'required_if:role,student', 'exists:students,student_id'],
            'teacher_id' => ['nullable', 'required_if:role,teacher', 'exists:teachers,teacher_id'],
        ]);

        User::create([
            'username' => $data['username'],
            'password_hash' => Hash::make($data['password']),
            'role' => $data['role'],
            'student_id' => $data['student_id'] ?? null,
            'teacher_id' => $data['teacher_id'] ?? null,
        ]);

        return redirect()->route('login')->with('status', 'Account created. You can now log in.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    protected function redirectPathForRole(string $role): string
{
    return match ($role) {
        'admin' => route('admin.dashboard'),
        'teacher' => route('teacher.dashboard'),
        'student' => route('student.dashboard'),
        'parent' => route('parent.dashboard'),
        default => route('login'),
    };
}
}