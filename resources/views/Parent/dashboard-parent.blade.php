@include('Parent.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Welcome back</p>
          <h1 class="h3 mb-1">{{ $parent->first_name }} {{ $parent->last_name }}</h1>
          <p class="text-muted mb-0">{{ $children->count() }} linked {{ Str::plural('child', $children->count()) }}</p>
        </div>
      </div>
    </div>

    @if ($children->isEmpty())
      <div class="panel mt-3">
        <p class="text-muted mb-0">No students are linked to this parent account yet.</p>
      </div>
    @endif

    @foreach ($children as $child)
      <section class="panel mt-3">
        <div class="panel-header">
          <div>
            <h2 class="h5 mb-1 section-title">
              <i class="bi bi-person-circle" aria-hidden="true"></i>
              <span>{{ $child['student']->first_name }} {{ $child['student']->last_name }}</span>
              @if ($child['is_primary'])
                <span class="badge text-bg-primary ms-2">Primary Guardian</span>
              @endif
            </h2>
            <p class="text-muted mb-0">{{ $child['student']->schoolClass->class_name ?? 'No class assigned' }}</p>
          </div>
        </div>

        <div class="row g-3 mt-1">
          <div class="col-12 col-md-4">
            <p class="fw-semibold mb-2">Attendance</p>
            <p class="mb-1 text-success">Present: {{ $child['attendance']['present'] ?? 0 }}</p>
            <p class="mb-1 text-danger">Absent: {{ $child['attendance']['absent'] ?? 0 }}</p>
            <p class="mb-0 text-warning">Late: {{ $child['attendance']['late'] ?? 0 }}</p>
          </div>

          <div class="col-12 col-md-4">
            <p class="fw-semibold mb-2">Recent Grades</p>
            @forelse ($child['grades'] as $grade)
              <p class="mb-1 small">{{ $grade->subject->subject_name ?? '—' }}: {{ $grade->final_score ?? $grade->midterm_score ?? '—' }}</p>
            @empty
              <p class="text-muted small mb-0">No grades recorded yet.</p>
            @endforelse
          </div>

          <div class="col-12 col-md-4">
            <p class="fw-semibold mb-2">Outstanding Payments</p>
            @forelse ($child['payments'] as $payment)
              <p class="mb-1 small text-danger">{{ $payment->description }}: ${{ number_format($payment->total_fee - $payment->amount_paid, 2) }} due</p>
            @empty
              <p class="text-muted small mb-0">No outstanding fees.</p>
            @endforelse
          </div>
        </div>
      </section>
    @endforeach

  </div>
</main>

@include('Parent.include.footer')