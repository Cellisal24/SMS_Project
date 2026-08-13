@include('parent.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-clipboard-check" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Overview</p>
          <h1 class="h3 mb-1">វត្តមាន / Attendance</h1>
          <p class="text-muted mb-0">Attendance history across all your children.</p>
        </div>
      </div>
    </div>

    <div class="panel mt-3">
      <form method="GET" action="{{ route('parent.attendance.index') }}" class="row g-2 align-items-end">
        <div class="col-12 col-md-5">
          <label class="form-label small">កូន / Child</label>
          <select name="student_id" class="form-select">
            <option value="">-- All children --</option>
            @foreach ($myChildren as $child)
              <option value="{{ $child->student_id }}" {{ request('student_id') === $child->student_id ? 'selected' : '' }}>
                {{ $child->first_name }} {{ $child->last_name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-12 col-md-3 d-flex gap-2">
          <button type="submit" class="btn btn-outline-secondary"><i class="bi bi-funnel" aria-hidden="true"></i> Filter</button>
          <a href="{{ route('parent.attendance.index') }}" class="btn btn-outline-secondary">Clear</a>
        </div>
      </form>
    </div>

    <section class="panel mt-3">
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th>កូន / Child</th>
              <th>កាលបរិច្ឆេទ / Date</th>
              <th>មុខវិជ្ជា / Subject</th>
              <th>ស្ថានភាព / Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($records as $record)
              @php
                $badge = match($record->status) {
                    'present' => 'success', 'absent' => 'danger',
                    'late' => 'warning', 'excused' => 'secondary', default => 'light',
                };
              @endphp
              <tr>
                <td>{{ $record->student->first_name ?? '' }} {{ $record->student->last_name ?? '' }}</td>
                <td>{{ \Carbon\Carbon::parse($record->date)->format('M j, Y') }}</td>
                <td>{{ $record->schedule->subject->subject_name ?? '—' }}</td>
                <td><span class="badge text-bg-{{ $badge }}">{{ ucfirst($record->status) }}</span></td>
              </tr>
            @empty
              <tr><td colspan="4" class="text-center text-muted py-4">No attendance records found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="mt-3">{{ $records->links() }}</div>
    </section>

  </div>
</main>

@include('parent.include.footer')
