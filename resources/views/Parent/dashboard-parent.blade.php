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
      <div class="heading-actions">
        <a href="{{ route('parent.children.index') }}" class="btn btn-primary btn-sm">
          <i class="bi bi-people" aria-hidden="true"></i> All Children
        </a>
      </div>
    </div>

    @if ($children->isEmpty())
      <div class="panel mt-3">
        <p class="text-muted mb-0">No students are linked to this parent account yet.</p>
      </div>
    @endif

    <section class="row g-3 mt-1">
      @foreach ($children as $child)
        <div class="col-12 col-md-6 col-xl-4">
          <div class="panel h-100">
            <div class="d-flex align-items-center gap-3 mb-3">
              @if ($child['student']->photo)
                <img src="{{ asset('storage/' . $child['student']->photo) }}" alt="{{ $child['student']->first_name }}" class="rounded-circle" style="width:48px;height:48px;object-fit:cover;">
              @else
                <span class="rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center" style="width:48px;height:48px;">
                  {{ strtoupper(substr($child['student']->first_name, 0, 1)) }}
                </span>
              @endif
              <div>
                <p class="fw-semibold mb-0">{{ $child['student']->first_name }} {{ $child['student']->last_name }}</p>
                <p class="text-muted small mb-0">{{ $child['student']->schoolClass->class_name ?? 'No class assigned' }}</p>
              </div>
            </div>

            <div class="d-flex justify-content-between text-center mb-3">
              <div>
                <p class="fw-bold text-success mb-0">{{ $child['attendance']['present'] ?? 0 }}</p>
                <p class="text-muted small mb-0">Present</p>
              </div>
              <div>
                <p class="fw-bold text-danger mb-0">{{ $child['attendance']['absent'] ?? 0 }}</p>
                <p class="text-muted small mb-0">Absent</p>
              </div>
              <div>
                @if ($child['outstanding_balance'] > 0)
                  <p class="fw-bold text-danger mb-0">${{ number_format($child['outstanding_balance'], 2) }}</p>
                  <p class="text-muted small mb-0">Due</p>
                @else
                  <p class="fw-bold text-success mb-0"><i class="bi bi-check-circle"></i></p>
                  <p class="text-muted small mb-0">Paid</p>
                @endif
              </div>
            </div>

            <a href="{{ route('parent.children.show', $child['student']->student_id) }}" class="btn btn-outline-primary btn-sm w-100">
              <i class="bi bi-eye" aria-hidden="true"></i> View Full Details
            </a>
          </div>
        </div>
      @endforeach
    </section>

  </div>
</main>

@include('Parent.include.footer')