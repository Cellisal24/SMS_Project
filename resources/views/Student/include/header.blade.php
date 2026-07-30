<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Student dashboard">
  <title>Dashboard | StudentSMS</title>

  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>
  <div class="admin-shell">
    <div class="sidebar-backdrop" data-sidebar-close></div>

    <aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
      <div class="sidebar-header">
        <a class="brand-mark" href="{{ route('student.dashboard') }}" aria-label="StudentHMD dashboard">
          <span class="brand-icon"><i class="bi bi-grid-1x2-fill" aria-hidden="true"></i></span>
          <span class="brand-copy">
            <span class="brand-title">StudentSMS</span>
            <span class="brand-subtitle">Student Panel</span>
          </span>
        </a>
      </div>

      <nav class="sidebar-nav">
        <a class="nav-link{{ request()->routeIs('student.dashboard') ? ' active' : '' }}" href="{{ route('student.dashboard') }}" aria-current="page">
          <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
          <span class="nav-text">Dashboard</span>
        </a>
        <a class="nav-link{{ request()->routeIs('student.schedule.*') ? ' active' : '' }}" href="{{ route('student.schedule.index') }}">
          <span class="nav-icon"><i class="bi bi-calendar3" aria-hidden="true"></i></span>
          <span class="nav-text">My Schedule</span>
        </a>
        <a class="nav-link{{ request()->routeIs('student.attendance.*') ? ' active' : '' }}" href="{{ route('student.attendance.index') }}">
          <span class="nav-icon"><i class="bi bi-clipboard-check" aria-hidden="true"></i></span>
          <span class="nav-text">My Attendance</span>
        </a>
        <a class="nav-link{{ request()->routeIs('student.grades.*') ? ' active' : '' }}" href="{{ route('student.grades.index') }}">
          <span class="nav-icon"><i class="bi bi-journal-check" aria-hidden="true"></i></span>
          <span class="nav-text">My Grades</span>
        </a>
        <a class="nav-link{{ request()->routeIs('student.exams.*') ? ' active' : '' }}" href="{{ route('student.exams.index') }}">
          <span class="nav-icon"><i class="bi bi-file-text" aria-hidden="true"></i></span>
          <span class="nav-text">Exams</span>
        </a>
        <a class="nav-link" href="{{ route('student.profile.show') }}">
          <span class="nav-icon"><i class="bi bi-person-badge" aria-hidden="true"></i></span>
          <span class="nav-text">Profile</span>
        </a>
        <a class="nav-link" href="{{ route('student.settings.edit') }}">
          <span class="nav-icon"><i class="bi bi-gear" aria-hidden="true"></i></span>
          <span class="nav-text">Settings</span>
        </a>
      </nav>

      <!-- <div class="sidebar-user">
        <img class="avatar-img avatar-md sidebar-user-avatar" src="{{ asset('assets/images/avatar/avatar.jpg') }}" alt="{{ auth()->user()->username }}">
        <strong>{{ auth()->user()->username }}</strong>
        <small>Student Workspace</small>
      </div> -->

      <div class="sidebar-footer">
        <span class="status-dot"></span>
        <span class="sidebar-footer-text">System running smoothly</span>
      </div>
    </aside>

    <div class="admin-main">
      <nav class="navbar admin-navbar navbar-expand bg-white">
        <div class="container-fluid px-3 px-lg-4">
          <button class="sidebar-toggle" type="button" data-sidebar-toggle aria-controls="adminSidebar" aria-expanded="true" aria-label="Toggle sidebar">
            <span></span>
            <span></span>
            <span></span>
          </button>

          <form class="d-none d-md-flex ms-3 flex-grow-1" role="search">
            <input class="form-control search-input" type="search" placeholder="Search schedule, grades" aria-label="Search">
          </form>

          <div class="navbar-actions ms-auto">
            <button class="icon-button theme-toggle" type="button" data-theme-toggle aria-label="Switch color theme" title="Switch color theme">
              <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
            </button>
               @php $notif = \App\Http\Controllers\AllNotificationController::forHeader(); @endphp
          
           <button type="button" class="icon-button position-relative" aria-label="Notifications" onclick="window.location.href='{{ route('notifications.index') }}'">
            @if ($notif['unreadCount'] > 0)
              <span class="notification-dot"></span>
            @endif
            <i class="bi bi-bell" aria-hidden="true"></i>
          </button>

             <div class="dropdown">
              <button class="profile-button dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                @if (auth()->user()->student && auth()->user()->student->photo)
                  <img class="avatar-img avatar-sm" src="{{ asset('storage/' . auth()->user()->student->photo) }}" alt="{{ auth()->user()->username }}">
                @else
                  <img class="avatar-img avatar-sm" src="{{ asset('assets/images/avatar/avatar.jpg') }}" alt="{{ auth()->user()->username }}">
                @endif
                <span class=" d-none d-sm-inline">{{ auth()->user()->username }}</span>
              </button>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{ route('student.profile.show') }}">Profile</a></li>
                <li><a class="dropdown-item" href="{{ route('student.settings.edit') }}">Account settings</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item">Sign out</button>
                    </form>
                </li>
              </ul>
          </div>
        </div>
      </nav>