@include('Admin.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-bell" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Overview</p>
          <h1 class="h3 mb-1">សេចក្តីជូនដំណឹង / Notifications</h1>
          <p class="text-muted mb-0">Messages sent to students, teachers, and parents.</p>
        </div>
      </div>
      <div class="heading-actions">
        <a href="{{ route('admin.notifications.create') }}" class="btn btn-primary btn-sm">
          <i class="bi bi-send" aria-hidden="true"></i> ផ្ញើសារ / Send Notification
        </a>
      </div>
    </div>

    @if (session('success'))
      <div class="alert alert-success alert-dismissible mt-3">{{ session('success') }}</div>
    @endif

    <div class="panel mt-3">
      <form method="GET" action="{{ route('admin.notifications.index') }}" class="row g-2 align-items-end">
        <div class="col-12 col-md-4">
          <label class="form-label small">ប្រភេទអ្នកទទួល / Recipient Type</label>
          <select name="recipient_type" class="form-select">
            <option value="">-- All --</option>
            <option value="student" {{ request('recipient_type') === 'student' ? 'selected' : '' }}>Student</option>
            <option value="teacher" {{ request('recipient_type') === 'teacher' ? 'selected' : '' }}>Teacher</option>
            <option value="parent" {{ request('recipient_type') === 'parent' ? 'selected' : '' }}>Parent</option>
          </select>
        </div>
        <div class="col-12 col-md-3 d-flex gap-2">
          <button type="submit" class="btn btn-outline-secondary"><i class="bi bi-funnel" aria-hidden="true"></i> Filter</button>
          <a href="{{ route('admin.notifications.index') }}" class="btn btn-outline-secondary">Clear</a>
        </div>
      </form>
    </div>

    <section class="panel mt-3">
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th>ចំណងជើង / Title</th>
              <th>អ្នកទទួល / Recipient</th>
              <th>ផ្ញើនៅ / Sent</th>
              <th>ស្ថានភាព / Status</th>
              <th class="text-end">សកម្មភាព / Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($notifications as $notification)
              <tr>
                <td>{{ $notification->title }}</td>
                <td>{{ ucfirst($notification->recipient_type) }} — {{ $notification->recipient_id }}</td>
                <td>{{ \Carbon\Carbon::parse($notification->sent_at)->format('M j, Y g:i A') }}</td>
                <td>
                  @if ($notification->read_at)
                    <span class="badge text-bg-success">Read</span>
                  @else
                    <span class="badge text-bg-secondary">Unread</span>
                  @endif
                </td>
                <td class="text-end">
                  <form method="POST" action="{{ route('admin.notifications.destroy', $notification->notif_id) }}" class="d-inline" onsubmit="return confirm('Delete this notification?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-light btn-sm text-danger">
                      <i class="bi bi-trash" aria-hidden="true"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted py-4">No notifications sent yet.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-3">
        {{ $notifications->links() }}
      </div>
    </section>

  </div>
</main>

@include('Admin.include.footer')