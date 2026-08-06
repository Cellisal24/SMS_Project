@extends('layouts.app-auth')

@section('title', 'Login')

@section('content')
<div class="login-shell">
    <div class="login-card">
        {{-- Left: illustration panel --}}
        <div class="login-illustration d-none d-md-flex">
            <button type="button" class="back-btn" onclick="history.back()" aria-label="Go back">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>

            <div class="deco-circle deco-circle--top"></div>
            <div class="deco-circle deco-circle--bottom"></div>

            <svg class="hero-art" width="260" height="220" viewBox="0 0 260 220" fill="none" xmlns="http://www.w3.org/2000/svg">
                <ellipse cx="130" cy="196" rx="85" ry="12" fill="#C9D3F5"/>
                <rect x="70" y="95" width="120" height="82" rx="8" fill="#1E2A5E"/>
                <rect x="80" y="105" width="100" height="62" rx="3" fill="#4C5FD6"/>
                <rect x="115" y="177" width="30" height="10" fill="#1E2A5E"/>
                <rect x="95" y="187" width="70" height="6" rx="3" fill="#1E2A5E"/>
                <rect x="212" y="118" width="8" height="30" rx="2" fill="#AEB9E8"/>
                <circle cx="216" cy="112" r="4" fill="#AEB9E8"/>
                <g transform="translate(60,40) rotate(-8 70 40)">
                    <polygon points="70,0 140,28 70,56 0,28" fill="#1E2A5E"/>
                    <polygon points="70,56 140,28 140,40 70,68" fill="#141d47"/>
                    <line x1="122" y1="20" x2="132" y2="55" stroke="#E8B84B" stroke-width="3"/>
                    <circle cx="132" cy="57" r="4" fill="#E8B84B"/>
                </g>
            </svg>
        </div>

        {{-- Right: form panel --}}
        <div class="login-form-panel">
            <div class="login-domain">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M10 13a5 5 0 007.07 0l2.83-2.83a5 5 0 00-7.07-7.07l-1.5 1.5M14 11a5 5 0 00-7.07 0l-2.83 2.83a5 5 0 007.07 7.07l1.5-1.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
                <span>{{ config('app.school_domain', 'www.SMSschool.edu') }}</span>
            </div>

            <div class="login-brand text-center">
                <div class="brand-icon">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none"><path d="M16 11a4 4 0 10-8 0 4 4 0 008 0zM4 21c0-3.3 3.6-6 8-6s8 2.7 8 6" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><circle cx="19" cy="8" r="2.4" stroke="#fff" stroke-width="1.6"/><path d="M22 17.2c0-1.9-1.8-3.3-4-3.5" stroke="#fff" stroke-width="1.6" stroke-linecap="round"/></svg>
                </div>
                <h1 class="brand-title">{{ config('app.name', 'SCHOOL NAME') }}</h1>
                <p class="brand-subtitle" id="panelLabel">STUDENT PANEL</p>
            </div>

            <div class="role-tabs" role="tablist" aria-label="Login as">
                <button type="button" class="role-tab is-active" data-role="student" data-label="STUDENT PANEL" data-field-label="Student Username" data-placeholder="Enter Username">Student</button>
                <button type="button" class="role-tab" data-role="teacher" data-label="TEACHER PANEL" data-field-label="Teacher Username" data-placeholder="Enter Username">Teacher</button>
                <button type="button" class="role-tab" data-role="parent" data-label="PARENT PANEL" data-field-label="Parent Username" data-placeholder="Enter Username">Parent</button>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger py-2 small mb-3">{{ $errors->first() }}</div>
            @endif
            @if (session('status'))
                <div class="alert alert-success py-2 small mb-3">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf
                {{-- UX hint only — the server always trusts the user's actual role column, never this field --}}
                <input type="hidden" name="login_role_hint" id="loginRoleHint" value="student">

                <label class="field-label" id="fieldLabel" for="username">Student Username</label>
                <input type="text" class="field-input" id="username" name="username" placeholder="Enter Username" value="{{ old('username') }}" required autofocus>

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
                    <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password?</a>
                </div>

                <button type="submit" class="btn-signin">Sign in</button>
            </form>
        </div>
    </div>
</div>

<style>
    .login-shell {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #dfe6f7;
        padding: 24px;
    }
    .login-card {
        display: flex;
        width: 100%;
        max-width: 900px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(30, 42, 94, 0.18);
        overflow: hidden;
        min-height: 560px;
    }
    .login-illustration {
        position: relative;
        flex: 0 0 42%;
        background: #eef1fb;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .deco-circle { position: absolute; border-radius: 50%; background: #d3ddf6; }
    .deco-circle--top { width: 220px; height: 220px; top: -60px; right: -70px; }
    .deco-circle--bottom { width: 160px; height: 160px; bottom: -60px; left: -50px; opacity: .8; }
    .hero-art { position: relative; z-index: 1; }
    .back-btn {
        position: absolute; top: 20px; left: 20px; z-index: 2;
        width: 34px; height: 34px; border-radius: 50%; border: none;
        background: #fff; color: #33406b;
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 10px rgba(30,42,94,0.12); cursor: pointer;
    }

    .login-form-panel {
        flex: 1;
        padding: 44px 48px;
        display: flex;
        flex-direction: column;
    }
    .login-domain {
        display: flex; align-items: center; gap: 8px;
        color: #6b7590; font-size: 13px; margin-bottom: 18px;
    }
    .brand-icon {
        width: 54px; height: 54px; border-radius: 14px;
        background: linear-gradient(135deg, #4453c9, #35408f);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 14px;
    }
    .brand-title { font-size: 22px; font-weight: 800; color: #1c2340; letter-spacing: .3px; margin-bottom: 2px; }
    .brand-subtitle { font-size: 13px; font-weight: 700; letter-spacing: .8px; color: #4453c9; margin-bottom: 22px; }

    .role-tabs {
        display: flex; background: #eef1fb; border-radius: 12px; padding: 4px;
        margin-bottom: 26px; gap: 4px;
    }
    .role-tab {
        flex: 1; border: none; background: transparent; padding: 9px 6px;
        font-size: 13.5px; font-weight: 600; color: #5b6480; border-radius: 9px;
        cursor: pointer; transition: background .15s ease, color .15s ease;
    }
    .role-tab.is-active { background: #4453c9; color: #fff; box-shadow: 0 4px 10px rgba(68,83,201,.35); }

    .field-label { display: block; font-size: 11.5px; font-weight: 700; letter-spacing: .6px; color: #7f889f; margin-bottom: 6px; }
    .field-input {
        width: 100%; border: none; border-bottom: 1.5px solid #e2e6f2; padding: 8px 2px;
        font-size: 15px; color: #1c2340; background: transparent; outline: none;
    }
    .field-input:focus { border-color: #4453c9; }
    .field-input::placeholder { color: #a7aec4; }

    .password-wrap { position: relative; }
    .password-toggle {
        position: absolute; right: 0; top: 6px; border: none; background: none;
        color: #9aa1b6; cursor: pointer; padding: 4px;
    }

    .remember-check { display: flex; align-items: center; gap: 8px; font-size: 14px; color: #33406b; cursor: pointer; }
    .remember-check input { width: 16px; height: 16px; accent-color: #4453c9; }
    .forgot-link { font-size: 14px; color: #4453c9; text-decoration: none; font-weight: 600; }
    .forgot-link:hover { text-decoration: underline; }

    .btn-signin {
        width: 100%; border: none; border-radius: 12px; padding: 13px;
        background: #4453c9; color: #fff; font-weight: 700; font-size: 15.5px;
        box-shadow: 0 8px 20px rgba(68,83,201,.3);
    }
    .btn-signin:hover { background: #38449e; }

    @media (max-width: 767px) {
        .login-form-panel { padding: 34px 24px; }
    }
</style>

<script>
    (function () {
        const tabs = document.querySelectorAll('.role-tab');
        const panelLabel = document.getElementById('panelLabel');
        const fieldLabel = document.getElementById('fieldLabel');
        const usernameInput = document.getElementById('username');
        const roleHint = document.getElementById('loginRoleHint');

        tabs.forEach((tab) => {
            tab.addEventListener('click', () => {
                tabs.forEach((t) => t.classList.remove('is-active'));
                tab.classList.add('is-active');

                panelLabel.textContent = tab.dataset.label;
                fieldLabel.textContent = tab.dataset.fieldLabel;
                usernameInput.placeholder = tab.dataset.placeholder;
                roleHint.value = tab.dataset.role;
                usernameInput.focus();
            });
        });

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