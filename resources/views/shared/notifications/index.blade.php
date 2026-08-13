@php
  $headerView = match(auth()->user()->role) {
      'teacher' => 'teacher.include.header',
      'student' => 'student.include.header',
      'parent' => 'parent.include.header',
      default => 'admin.include.header',
  };
  $footerView = match(auth()->user()->role) {
      'teacher' => 'teacher.include.footer',
      'student' => 'student.include.footer',
      'parent' => 'parent.include.footer',
      default => 'admin.include.footer',
  };
@endphp
@include($headerView)

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-bell" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Overview</p>
          <h1 class="h3 mb-1">សេចក្តីជូនដំណឹង / Notifications</h1>
        </div>
      </div>
      <div class="heading-actions">
        <form method="POST" action="{{ route('notifications.read-all') }}">
          @csrf
          <button type="submit" class="btn btn-outline-secondary btn-sm">Mark all as read</button>
        </form>
      </div>
    </div>

    @if (session('success'))
      <div class="alert alert-success alert-dismissible mt-3">{{ session('success') }}</div>
    @endif

    <section class="panel mt-3">
      <div class="list-group list-group-flush">
        @forelse ($notifications as $note)
          <div class="list-group-item d-flex justify-content-between align-items-start {{ $note->read_at ? '' : 'bg-light' }}">
            <div>
              <p class="fw-semibold mb-1">
                {{ $note->title }}
                @if (! $note->read_at)
                  <span class="badge text-bg-primary ms-1">New</span>
                @endif
              </p>
              <p class="text-muted small mb-1">{{ $note->body }}</p>
              <p class="text-muted small mb-0">{{ \Carbon\Carbon::parse($note->sent_at)->format('M j, Y g:i A') }}</p>
            </div>
            @if (! $note->read_at)
              <form method="POST" action="{{ route('notifications.read', $note->notif_id) }}">
                @csrf
                <button type="submit" class="btn btn-light btn-sm">
                  <i class="bi bi-check2" aria-hidden="true"></i> Mark read
                </button>
              </form>
            @endif
          </div>
        @empty
          <p class="text-muted mb-0 py-4 text-center">No notifications yet.</p>
        @endforelse
      </div>

      <div class="mt-3">
        {{ $notifications->links() }}
      </div>
    </section>

  </div>
</main>

@include($footerView)
