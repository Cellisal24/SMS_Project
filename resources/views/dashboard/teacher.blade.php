@extends('layouts.auth')

@section('title', 'Teacher Dashboard')

@section('content')
    <h5 class="card-title mb-3">Teacher dashboard</h5>
    <p class="text-muted small mb-3">Placeholder — build out the real teacher dashboard here.</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-danger w-100">Log out</button>
    </form>
@endsection
