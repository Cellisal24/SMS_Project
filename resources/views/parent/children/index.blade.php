@include('parent.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Overview</p>
          <h1 class="h3 mb-1">កូនរបស់ខ្ញុំ / My Children</h1>
          <p class="text-muted mb-0">{{ $children->count() }} linked {{ Str::plural('child', $children->count()) }}</p>
        </div>
      </div>
    </div>

    <section class="row g-3 mt-1">
      @forelse ($children as $child)
        <div class="col-12 col-md-6 col-xl-4">
          <div class="panel h-100">
            <div class="d-flex align-items-center gap-3 mb-3">
              @if ($child['student']->photo)
                <img src="{{ asset('storage/' . $child['student']->photo) }}" alt="{{ $child['student']->first_name }}" class="rounded-circle" style="width:56px;height:56px;object-fit:cover;">
              @else
                <span class="rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center" style="width:56px;height:56px;font-size:1.25rem;">
                  {{ strtoupper(substr($child['student']->first_name, 0, 1)) }}
                </span>
              @endif
              <div>
                <p class="fw-semibold mb-0">{{ $child['student']->first_name }} {{ $child['student']->last_name }}</p>
                <p class="text-muted small mb-0">{{ $child['student']->schoolClass->class_name ?? 'No class assigned' }}</p>
              </div>
            </div>

            <p class="text-muted small mb-1">
              <i class="bi bi-person-heart" aria-hidden="true"></i> {{ $child['relationship'] ?? 'Guardian' }}
              @if ($child['is_primary'])
                <span class="badge text-bg-primary ms-1">Primary</span>
              @endif
            </p>
            <p class="text-muted small mb-3">
              <i class="bi bi-card-text" aria-hidden="true"></i> {{ $child['student']->student_id }}
            </p>

            <a href="{{ route('parent.children.show', $child['student']->student_id) }}" class="btn btn-primary btn-sm w-100">
              <i class="bi bi-eye" aria-hidden="true"></i> មើលព័ត៌មានលម្អិត / View Details
            </a>
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="panel">
            <p class="text-muted mb-0">No children are linked to this parent account yet.</p>
          </div>
        </div>
      @endforelse
    </section>

  </div>
</main>

@include('parent.include.footer')
