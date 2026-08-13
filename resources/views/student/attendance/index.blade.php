@include('student.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-clipboard-check" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Overview</p>
          <h1 class="h3 mb-1">វត្តមានរបស់ខ្ញុំ / My Attendance</h1>
          <p class="text-muted mb-0">Your full attendance history.</p>
        </div>
      </div>
    </div>

    <section class="row g-3 mt-1">
      <div class="col-12 col-sm-6 col-xl-3">
        <article class="metric-card metric-success">
          <div class="metric-top">
            <span class="metric-label">Present</span>
            <span class="metric-icon"><i class="bi bi-check-circle" aria-hidden="true"></i></span>
          </div>
          <div class="metric-value">{{ $summary['present'] ?? 0 }}</div>
        </article>
      </div>
      <div class="col-12 col-sm-6 col-xl-3">
        <article class="metric-card metric-danger">
          <div class="metric-top">
            <span class="metric-label">Absent</span>
            <span class="metric-icon"><i class="bi bi-x-circle" aria-hidden="true"></i></span>
          </div>
          <div class="metric-value">{{ $summary['absent'] ?? 0 }}</div>
        </article>
      </div>
      <div class="col-12 col-sm-6 col-xl-3">
        <article class="metric-card metric-warning">
          <div class="metric-top">
            <span class="metric-label">Late</span>
            <span class="metric-icon"><i class="bi bi-clock-history" aria-hidden="true"></i></span>
          </div>
          <div class="metric-value">{{ $summary['late'] ?? 0 }}</div>
        </article>
      </div>
      <div class="col-12 col-sm-6 col-xl-3">
        <article class="metric-card metric-primary">
          <div class="metric-top">
            <span class="metric-label">Excused</span>
            <span class="metric-icon"><i class="bi bi-shield-check" aria-hidden="true"></i></span>
          </div>
          <div class="metric-value">{{ $summary['excused'] ?? 0 }}</div>
        </article>
      </div>
    </section>

    <div class="panel mt-3">
      <form method="GET" action="{{ route('student.attendance.index') }}" class="row g-2 align-items-end">
        <div class="col-12 col-md-4">
          <label class="form-label small">ខែ / Month</label>
          <select name="month" class="form-select">
            <option value="">-- All months --</option>
            @foreach (range(1, 12) as $m)
              <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                {{ \Carbon\Carbon::create()->month($m)->format('F') }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-12 col-md-3 d-flex gap-2">
          <button type="submit" class="btn btn-outline-secondary"><i class="bi bi-funnel" aria-hidden="true"></i> Filter</button>
          <a href="{{ route('student.attendance.index') }}" class="btn btn-outline-secondary">Clear</a>
        </div>
      </form>
    </div>

    <section class="panel mt-3">
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th>កាលបរិច្ឆេទ / Date</th>
              <th>មុខវិជ្ជា / Subject</th>
              <th>ស្ថានភាព / Status</th>
              <th>មូលហេតុ / Reason</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($records as $record)
              @php
                $badge = match($record->status) {
                    'present' => 'success',
                    'absent' => 'danger',
                    'late' => 'warning',
                    'excused' => 'secondary',
                    default => 'light',
                };
              @endphp
              <tr>
                <td>{{ \Carbon\Carbon::parse($record->date)->format('M j, Y') }}</td>
                <td>{{ $record->schedule->subject->subject_name ?? '—' }}</td>
                <td><span class="badge text-bg-{{ $badge }}">{{ ucfirst($record->status) }}</span></td>
                <td>{{ $record->leave_reason ?? '—' }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center text-muted py-4">No attendance records yet.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="mt-3">{{ $records->links() }}</div>
    </section>

  </div>
</main>

@include('student.include.footer')
