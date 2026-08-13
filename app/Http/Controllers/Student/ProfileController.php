<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $student = Auth::user()->student()->with('schoolClass')->firstOrFail();

        return view('student.profile.show', compact('student'));
    }

    public function editSettings()
    {
        return view('student.profile.settings');
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

        return redirect()->route('student.settings.edit')->with('success', 'Password updated.');
    }
}
