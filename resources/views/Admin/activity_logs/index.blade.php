@include('Admin.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-clock-history" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Overview</p>
          <h1 class="h3 mb-1">កំណត់ត្រាសកម្មភាព / Activity Logs</h1>
          <p class="text-muted mb-0">System audit trail — who changed what, and when.</p>
        </div>
      </div>
      <div class="heading-actions">
        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#purgeModal">
          <i class="bi bi-trash3" aria-hidden="true"></i> Purge Old Logs
        </button>
      </div>
    </div>

    @if (session('success'))
      <div class="alert alert-success alert-dismissible mt-3">{{ session('success') }}</div>
    @endif

    <div class="panel mt-3">
      <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="row g-2 align-items-end">
        <div class="col-12 col-md-3">
          <label class="form-label small">ស្វែងរក / Search</label>
          <input type="text" name="search" class="form-control" placeholder="Username or record ID" value="{{ request('search') }}">
        </div>
        <div class="col-12 col-md-2">
          <label class="form-label small">សកម្មភាព / Action</label>
          <select name="action" class="form-select">
            <option value="">-- All --</option>
            @foreach ($actions as $action)
              <option value="{{ $action }}" {{ request('action') === $action ? 'selected' : '' }}>{{ $action }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-12 col-md-2">
          <label class="form-label small">តារាង / Table</label>
          <select name="table_name" class="form-select">
            <option value="">-- All --</option>
            @foreach ($tables as $table)
              <option value="{{ $table }}" {{ request('table_name') === $table ? 'selected' : '' }}>{{ $table }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-12 col-md-2">
          <label class="form-label small">ពីថ្ងៃ / From</label>
          <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
        </div>
        <div class="col-12 col-md-2">
          <label class="form-label small">ដល់ថ្ងៃ / To</label>
          <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
        </div>
        <div class="col-12 col-md-1 d-flex gap-2">
          <button type="submit" class="btn btn-outline-secondary"><i class="bi bi-funnel" aria-hidden="true"></i></button>
        </div>
      </form>
    </div>

    <section class="panel mt-3">
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th>ពេលវេលា / Time</th>
              <th>អ្នកប្រើ / User</th>
              <th>សកម្មភាព / Action</th>
              <th>តារាង / Table</th>
              <th>លេខកូដកំណត់ត្រា / Record ID</th>
              <th>ការផ្លាស់ប្តូរ / Changes</th>
              <th class="text-end">សកម្មភាព / Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($logs as $log)
              <tr>
                <td>{{ \Carbon\Carbon::parse($log->created_at)->format('M j, Y H:i') }}</td>
                <td>{{ $log->user->username ?? 'System' }}</td>
                <td>
                  @php
                    $badge = match(strtolower($log->action)) {
                      'create', 'created', 'insert' => 'success',
                      'update', 'updated' => 'warning',
                      'delete', 'deleted' => 'danger',
                      default => 'secondary',
                    };
                  @endphp
                  <span class="badge text-bg-{{ $badge }}">{{ $log->action }}</span>
                </td>
                <td>{{ $log->table_name }}</td>
                <td>{{ $log->record_id }}</td>
                <td>
                  @if ($log->old_value || $log->new_value)
                    <button type="button" class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#logDetail{{ $log->log_id }}">
                      <i class="bi bi-eye" aria-hidden="true"></i> View
                    </button>

                    <div class="modal fade" id="logDetail{{ $log->log_id }}" tabindex="-1">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">{{ $log->table_name }} #{{ $log->record_id }} — {{ $log->action }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col-6">
                                <h6>Before</h6>
                                <pre class="bg-light p-2 small">{{ $log->old_value ? json_encode($log->old_value, JSON_PRETTY_PRINT) : '—' }}</pre>
                              </div>
                              <div class="col-6">
                                <h6>After</h6>
                                <pre class="bg-light p-2 small">{{ $log->new_value ? json_encode($log->new_value, JSON_PRETTY_PRINT) : '—' }}</pre>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  @else
                    —
                  @endif
                </td>
                <td class="text-end">
                  <form method="POST" action="{{ route('admin.activity-logs.destroy', $log->log_id) }}" class="d-inline" onsubmit="return confirm('Delete this log entry?');">
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
                <td colspan="7" class="text-center text-muted py-4">No activity logs found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-3">
        {{ $logs->links() }}
      </div>
    </section>

  </div>
</main>

<!-- Purge modal -->
<div class="modal fade" id="purgeModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="POST" action="{{ route('admin.activity-logs.purge') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Purge Old Logs</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <label class="form-label" for="before_date">Delete all logs before:</label>
          <input type="date" name="before_date" id="before_date" class="form-control" required>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Purge</button>
        </div>
      </form>
    </div>
  </div>
</div>

@include('Admin.include.footer')