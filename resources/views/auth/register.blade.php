@extends('layouts.auth')

@section('title', 'Create account')

@section('content')
    <h5 class="card-title mb-3">Create user account</h5>
    <p class="text-muted small mb-3">Admin use only — links a login to an existing student or teacher record.</p>

    @if ($errors->any())
        <div class="alert alert-danger py-2">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select" id="role" name="role" required>
                <option value="">Select role</option>
                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="teacher" {{ old('role') === 'teacher' ? 'selected' : '' }}>Teacher</option>
                <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Student</option>
                <option value="parent" {{ old('role') === 'parent' ? 'selected' : '' }}>Parent</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="teacher_id" class="form-label">Teacher ID <span class="text-muted">(if role is teacher)</span></label>
            <input type="text" class="form-control" id="teacher_id" name="teacher_id" value="{{ old('teacher_id') }}">
        </div>

        <div class="mb-3">
            <label for="student_id" class="form-label">Student ID <span class="text-muted">(if role is student)</span></label>
            <input type="text" class="form-control" id="student_id" name="student_id" value="{{ old('student_id') }}">
        </div>

        <button type="submit" class="btn btn-primary w-100">Create account</button>
    </form>
@endsection
