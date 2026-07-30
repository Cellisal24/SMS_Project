<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $teacher = Auth::user()->teacher()->firstOrFail();

        return view('Teacher.profile.show', compact('teacher'));
    }

    public function editSettings()
    {
        return view('Teacher.profile.settings');
    }

    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = Auth::user();

        if (! Hash::check($data['current_password'], $user->password_hash)) {
            return back()->withErrors(['current_password' => 'Your current password is incorrect.']);
        }

        $user->update(['password_hash' => Hash::make($data['password'])]);

        return redirect()->route('teacher.settings.edit')->with('success', 'Password updated.');
    }
}