@include(auth()->user()->role === 'teacher' ? 'teacher.include.header' : 'admin.include.header')
<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-clipboard-check" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Overview</p>
          <h1 class="h3 mb-1">វត្តមាន / Attendance</h1>
          <p class="text-muted mb-0">Track and manage student attendance records.</p>
        </div>
      </div>
      <div class="heading-actions">
        <a href="{{ route('admin.attendance.create') }}" class="btn btn-primary btn-sm">
          <i class="bi bi-plus-lg" aria-hidden="true"></i> កត់ត្រាវត្តមាន / Mark Attendance
        </a>
      </div>
    </div>

    @if (session('status'))
      <div class="alert alert-success alert-dismissible mt-3">{{ session('status') }}</div>
    @endif

    {{-- Filters --}}
    <div class="panel mt-3">
      <form method="GET" action="{{ route('admin.attendance.index') }}" class="row g-2 align-items-end">
        <div class="col-12 col-md-4">
          <label class="form-label small">កាលបរិច្ឆេទ / Date</label>
          <input type="date" name="date" class="form-control" value="{{ request('date') }}">
        </div>
        <div class="col-12 col-md-4">
          <label class="form-label small">ថ្នាក់ / Class ID</label>
          <input type="text" name="class_id" class="form-control" placeholder="e.g. C-001" value="{{ request('class_id') }}">
        </div>
        <div class="col-12 col-md-4 d-flex gap-2">
          <button type="submit" class="btn btn-outline-secondary">
            <i class="bi bi-funnel" aria-hidden="true"></i> Filter
          </button>
          <a href="{{ route('admin.attendance.index') }}" class="btn btn-outline-secondary">Clear</a>
        </div>
      </form>
    </div>

    <section class="panel mt-3">
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th>សិស្ស / Student</th>
              <th>មុខវិជ្ជា / Subject</th>
              <th>ថ្នាក់ / Class</th>
              <th>កាលបរិច្ឆេទ / Date</th>
              <th>ស្ថានភាព / Status</th>
              <th class="text-end">សកម្មភាព / Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($records as $record)
              <tr>
                <td>
                  {{ $record->student->first_name ?? '' }} {{ $record->student->last_name ?? '' }}
                  <div class="text-muted small">{{ $record->student_id }}</div>
                </td>
                <td>{{ $record->schedule->subject->subject_name ?? '—' }}</td>
                <td>{{ $record->schedule->schoolClass->class_name ?? '—' }}</td>
                <td>{{ \Carbon\Carbon::parse($record->date)->format('M j, Y') }}</td>
                <td>
                  @php
                    $badge = match($record->status) {
                        'present' => 'success',
                        'absent' => 'danger',
                        'late' => 'warning',
                        'excused' => 'secondary',
                        default => 'light',
                    };
                  @endphp
                  <span class="badge text-bg-{{ $badge }}">{{ ucfirst($record->status) }}</span>
                </td>
                <td class="text-end">
                  <a href="{{ route('admin.attendance.edit', $record->attendance_id) }}" class="btn btn-light btn-sm">
                    <i class="bi bi-pencil" aria-hidden="true"></i>
                  </a>
                  <form method="POST" action="{{ route('admin.attendance.destroy', $record->attendance_id) }}" class="d-inline" onsubmit="return confirm('Delete this attendance record?');">
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
                <td colspan="6" class="text-center text-muted py-4">No attendance records found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-3">
        {{ $records->links() }}
      </div>
    </section>

  </div>
</main>
@include(auth()->user()->role === 'teacher' ? 'teacher.include.footer' : 'admin.include.footer')

