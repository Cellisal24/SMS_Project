@extends('layouts.auth')

@section('title', 'Forgot password')

@section('content')
    <h5 class="card-title mb-3">Reset your password</h5>
    <p class="text-muted small">
        Password-reset isn't wired up yet — this is a placeholder page.
        When you're ready, this is where a "send reset link to email" form goes,
        using Laravel's built-in <code>Password::sendResetLink()</code>.
    </p>
    <a href="{{ route('login') }}" class="btn btn-outline-primary w-100">Back to login</a>
@endsection
