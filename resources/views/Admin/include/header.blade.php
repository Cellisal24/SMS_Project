<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="adminHMD professional admin dashboard template">
  <title>Dashboard | adminSMS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>
  <div class="admin-shell">
    <div class="sidebar-backdrop" data-sidebar-close></div>

    <aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
      <div class="sidebar-header">
        <a class="brand-mark" href="" aria-label="adminHMD dashboard">
          <span class="brand-icon"><i class="bi bi-grid-1x2-fill" aria-hidden="true"></i></span>
          <span class="brand-copy">
            <span class="brand-title">adminSMS</span>
            <span class="brand-subtitle">Admin Template</span>
          </span>
        </a>
      </div>

      <nav class="sidebar-nav">
        <a class="nav-link{{ request()->routeIs('admin.dashboard') ? ' active' : '' }}" href="{{ route('admin.dashboard') }}" aria-current="page">
          <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
          <span class="nav-text">Dashboard</span>
        </a>
        <a class="nav-link{{ request()->routeIs('grade-levels.*') ? ' active' : '' }}" href="{{ route('grade-levels.index') }}">
          <span class="nav-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
          <span class="nav-text">Grade Levels</span>
        </a>
        <a class="nav-link{{ request()->routeIs('rooms.*') ? ' active' : '' }}" href="{{ route('rooms.index') }}">
          <span class="nav-icon"><i class="bi bi-person-plus" aria-hidden="true"></i></span>
          <span class="nav-text">Rooms</span>
        </a>
        <a class="nav-link{{ request()->routeIs('admin.subjects.*') ? ' active' : '' }}" href="{{ route('admin.subjects.index') }}">
          <span class="nav-icon"><i class="bi bi-person-badge" aria-hidden="true"></i></span>
          <span class="nav-text">Subjects</span>
        </a>
        <a class="nav-link{{ request()->routeIs('school-classes.*') ? ' active' : '' }}" href="{{ route('school-classes.index') }}">
          <span class="nav-icon"><i class="bi bi-bar-chart-line" aria-hidden="true"></i></span>
          <span class="nav-text">Class</span>
        </a>
        <a class="nav-link{{ request()->routeIs('teachers.*') ? ' active' : '' }}" href="{{ route('teachers.index') }}">
          <span class="nav-icon"><i class="bi bi-table" aria-hidden="true"></i></span>
          <span class="nav-text">Teachers</span>
        </a>
        <a class="nav-link{{ request()->routeIs('admin.students.*') ? ' active' : '' }}" href="{{ route('admin.students.index') }}">
          <span class="nav-icon"><i class="bi bi-ui-checks-grid" aria-hidden="true"></i></span>
          <span class="nav-text">Student</span>
        </a>
        <a class="nav-link{{ request()->routeIs('admin.parents.*') ? ' active' : '' }}" href="{{ route('admin.parents.index') }}">
          <span class="nav-icon"><i class="bi bi-grid-3x3-gap" aria-hidden="true"></i></span>
          <span class="nav-text">Parent</span>
        </a>
        <a class="nav-link{{ request()->routeIs('admin.student_parents.*') ? ' active' : '' }}" href="{{ route('admin.student_parents.index') }}">
          <span class="nav-icon"><i class="bi bi-exclamation-triangle" aria-hidden="true"></i></span>
          <span class="nav-text">Student-Parent</span>
        </a>
        <a class="nav-link{{ request()->routeIs('admin.attendance.*') ? ' active' : '' }}" href="{{ route('admin.attendance.index') }}">
          <span class="nav-icon"><i class="bi bi-window-stack" aria-hidden="true"></i></span>
          <span class="nav-text">Attendance</span>
        </a>
        <a class="nav-link{{ request()->routeIs('admin.schedules.*') ? ' active' : '' }}" href="{{ route('admin.schedules.index') }}">
          <span class="nav-icon"><i class="bi bi-gear" aria-hidden="true"></i></span>
          <span class="nav-text">Schedules</span>
        </a>
       <a class="nav-link{{ request()->routeIs('admin.grades.*') ? ' active' : '' }}" href="{{ route('admin.grades.index') }}">
        <span class="nav-icon"><i class="bi bi-file-earmark" aria-hidden="true"></i></span>
        <span class="nav-text">Grades</span>
      </a>
      <a class="nav-link" href="{{ route('admin.payments.index') }}">
          <span class="nav-icon"><i class="bi bi-credit-card" aria-hidden="true"></i></span>
          <span class="nav-text">Payment</span>
        </a>
       <a class="nav-link" href="{{ route('admin.notifications.index') }}">
        <span class="nav-icon"><i class="bi bi-bell" aria-hidden="true"></i></span>
        <span class="nav-text">Notifications</span>
      </a>
        <a class="nav-link{{ request()->routeIs('admin.reports.*') ? ' active' : '' }}" href="{{ route('admin.reports.index') }}">
          <span class="nav-icon"><i class="bi bi-file-earmark-text" aria-hidden="true"></i></span>
          <span class="nav-text">Reports</span>
        </a>
        <a class="nav-link{{ request()->routeIs('admin.activity-logs.*') ? ' active' : '' }}" href="{{ route('admin.activity-logs.index') }}">
          <span class="nav-icon"><i class="bi bi-clock-history" aria-hidden="true"></i></span>
          <span class="nav-text">Activity Logs</span>
        </a>
      <a class="nav-link{{ request()->routeIs('admin.exams.*') ? ' active' : '' }}" href="{{ route('admin.exams.index') }}">
        <span class="nav-icon"><i class="bi bi-file-earmark" aria-hidden="true"></i></span>
        <span class="nav-text">Exams</span>
      </a>
      <a class="nav-link{{ request()->routeIs('exam_results.*') ? ' active' : '' }}" href="{{ route('exam_results.index') }}">
        <span class="nav-icon"><i class="bi bi-file-earmark" aria-hidden="true"></i></span>
        <span class="nav-text">Exam Results</span>
      </a>
      </nav>
      <!-- <div class="sidebar-user">
        <img class="avatar-img avatar-md sidebar-user-avatar" src="../assets/images/avatar/avatar.jpg" alt="Admin">
        <strong>{{ auth()->user()->username }}</strong>
        <small>Active Workspace</small>
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
            <input class="form-control search-input" type="search" placeholder="Search users, orders, reports" aria-label="Search">
          </form>

          <div class="navbar-actions ms-auto">
            <button class="icon-button theme-toggle" type="button" data-theme-toggle aria-label="Switch color theme" title="Switch color theme">
              <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
            </button>
          <div class="dropdown">
  <button class="icon-button" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Notifications">
    @if ($navUnreadCount > 0)
      <span class="notification-dot"></span>
    @endif
    <i class="bi bi-bell" aria-hidden="true"></i>
  </button>
  <div class="dropdown-menu dropdown-menu-end notification-menu">
    <div class="dropdown-header fw-bold text-body d-flex justify-content-between align-items-center">
      Notifications
      @if ($navUnreadCount > 0)
        <form method="POST" action="{{ route('admin.notifications.mark-read') }}">
          @csrf
          <button type="submit" class="btn btn-link btn-sm p-0">Mark all read</button>
        </form>
      @endif
    </div>
    @forelse ($navNotifications as $notif)
      <a class="dropdown-item{{ $notif->read_at ? '' : ' fw-semibold' }}" href="{{ route('admin.notifications.index') }}">
        <span class="notification-title">{{ $notif->title }}</span>
        <span class="notification-time">{{ $notif->sent_at->diffForHumans() }}</span>
      </a>
    @empty
      <div class="dropdown-item text-muted">No notifications.</div>
    @endforelse
    <div class="dropdown-divider"></div>
    <a class="dropdown-item text-center small" href="{{ route('admin.notifications.index') }}">View all</a>
  </div>
</div>

<div class="dropdown">
  <button class="profile-button dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    <img class="avatar-img avatar-sm" src="{{ asset('assets/images/avatar/avatar.jpg') }}" alt="name">
    <span class=" d-none d-sm-inline">{{ auth()->user()->username }}</span>
  </button>
  <ul class="dropdown-menu dropdown-menu-end">
    <li><a class="dropdown-item" href="{{ route('admin.profile.show') }}">Profile</a></li>
    <li><a class="dropdown-item" href="{{ route('admin.settings.edit') }}">Account settings</a></li>
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
        </div>
      </nav>