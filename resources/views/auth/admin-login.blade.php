@extends('layouts.app-auth')

@section('title', 'Admin Login')

@section('content')
<div class="admin-login-shell">
    <div class="admin-login-card">
        <div class="admin-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M12 2l8 4v6c0 5-3.5 8.5-8 10-4.5-1.5-8-5-8-10V6l8-4z" stroke="#fff" stroke-width="1.8" stroke-linejoin="round"/><path d="M9 12l2 2 4-4" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
        <h1 class="admin-title">Admin Login</h1>
        <p class="admin-subtitle">{{ config('app.name', 'SCHOOL NAME') }} — restricted access</p>

        @if ($errors->any())
            <div class="alert alert-danger py-2 small mb-3">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}" novalidate>
            @csrf

            <label class="field-label" for="username">USERNAME</label>
            <input type="text" class="field-input" id="username" name="username" placeholder="Enter your username" value="{{ old('username') }}" required autofocus>

            <label class="field-label mt-3" for="password">PASSWORD</label>
            <div class="password-wrap">
                <input type="password" class="field-input" id="password" name="password" placeholder="Enter your password" required>
                <button type="button" class="password-toggle" id="togglePassword" aria-label="Show password">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" stroke="currentColor" stroke-width="1.6"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.6"/></svg>
                </button>
            </div>

            <div class="d-flex justify-content-between align-items-center my-3">
                <label class="remember-check">
                    <input type="checkbox" name="remember">
                    <span>Remember me</span>
                </label>
            </div>

            <button type="submit" class="btn-signin">Sign in</button>
        </form>
    </div>
</div>

<style>
    .admin-login-shell {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #1c2340;
        padding: 24px;
    }
    .admin-login-card {
        width: 100%;
        max-width: 380px;
        background: #fff;
        border-radius: 18px;
        padding: 40px 36px;
        box-shadow: 0 24px 60px rgba(0,0,0,.35);
    }
    .admin-icon {
        width: 52px; height: 52px; border-radius: 14px;
        background: linear-gradient(135deg, #2b3568, #171d3b);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px;
    }
    .admin-title { font-size: 20px; font-weight: 800; color: #1c2340; text-align: center; margin-bottom: 2px; }
    .admin-subtitle { font-size: 13px; color: #7f889f; text-align: center; margin-bottom: 24px; }

    .field-label { display: block; font-size: 11.5px; font-weight: 700; letter-spacing: .6px; color: #7f889f; margin-bottom: 6px; }
    .field-input {
        width: 100%; border: none; border-bottom: 1.5px solid #e2e6f2; padding: 8px 2px;
        font-size: 15px; color: #1c2340; background: transparent; outline: none;
    }
    .field-input:focus { border-color: #1c2340; }
    .field-input::placeholder { color: #a7aec4; }

    .password-wrap { position: relative; }
    .password-toggle {
        position: absolute; right: 0; top: 6px; border: none; background: none;
        color: #9aa1b6; cursor: pointer; padding: 4px;
    }

    .remember-check { display: flex; align-items: center; gap: 8px; font-size: 14px; color: #33406b; cursor: pointer; }
    .remember-check input { width: 16px; height: 16px; accent-color: #1c2340; }

    .btn-signin {
        width: 100%; border: none; border-radius: 12px; padding: 13px;
        background: #1c2340; color: #fff; font-weight: 700; font-size: 15.5px;
    }
    .btn-signin:hover { background: #141a2e; }
</style>

<script>
    (function () {
        const toggleBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        toggleBtn.addEventListener('click', () => {
            const isHidden = passwordInput.type === 'password';
            passwordInput.type = isHidden ? 'text' : 'password';
            toggleBtn.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
        });
    })();
</script>
@endsection