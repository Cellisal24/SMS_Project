@extends('layouts.auth')

@section('title', 'Forgot password')

@section('content')
    <h5 class="card-title mb-3">Reset your password</h5>
    <p class="text-muted small">
        Contact your school administrator to reset your password
    </p>
    <a href="{{ route('login') }}" class="btn btn-outline-primary w-100">Back to login</a>
@endsection
