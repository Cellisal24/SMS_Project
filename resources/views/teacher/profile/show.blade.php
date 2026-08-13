@include('teacher.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-person-circle" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Account</p>
          <h1 class="h3 mb-1">Profile</h1>
        </div>
      </div>
      <div class="heading-actions">
        <a href="{{ route('teacher.settings.edit') }}" class="btn btn-outline-secondary btn-sm">
          <i class="bi bi-gear" aria-hidden="true"></i> Account Settings
        </a>
      </div>
    </div>

    <section class="panel mt-3">
      <div class="row g-3 align-items-center mb-3">
        <div class="col-auto">
          @if ($teacher->photo)
            <img src="{{ asset('storage/' . $teacher->photo) }}" alt="Profile photo" class="rounded-circle" style="width:96px;height:96px;object-fit:cover;">
          @else
            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width:96px;height:96px;">
              <i class="bi bi-person fs-2 text-muted" aria-hidden="true"></i>
            </div>
          @endif
        </div>
        <div class="col">
          <h2 class="h5 mb-1">{{ $teacher->first_name }} {{ $teacher->last_name }}</h2>
          <p class="text-muted mb-0">Teacher ID: {{ $teacher->teacher_id }}</p>
        </div>
      </div>

      <div class="row g-3">
        <div class="col-12 col-md-4">
          <div class="text-muted small">Gender</div>
          <div class="fw-semibold">{{ $teacher->gender }}</div>
        </div>
        <div class="col-12 col-md-4">
          <div class="text-muted small">Email</div>
          <div class="fw-semibold">{{ $teacher->email }}</div>
        </div>
        <div class="col-12 col-md-4">
          <div class="text-muted small">Contact Number</div>
          <div class="fw-semibold">{{ $teacher->contact_number ?? '—' }}</div>
        </div>
      </div>
    </section>

  </div>
</main>

@include('teacher.include.footer')
