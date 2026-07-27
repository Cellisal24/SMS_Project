@extends('layouts.auth')

@section('title', 'Student Dashboard')

@section('content')
    <h5 class="card-title mb-3">Student dashboard</h5>
    <p class="text-muted small mb-3">Placeholder — build out the real student dashboard here.</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-danger w-100">Log out</button>
    </form>
@endsection
