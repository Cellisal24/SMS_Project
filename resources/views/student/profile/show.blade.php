@include('student.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-person-circle" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Account</p>
          <h1 class="h3 mb-1">ប្រវត្តិរូប / Profile</h1>
        </div>
      </div>
      <div class="heading-actions">
        <a href="{{ route('student.settings.edit') }}" class="btn btn-outline-secondary btn-sm">
          <i class="bi bi-gear" aria-hidden="true"></i> Account Settings
        </a>
      </div>
    </div>

    <section class="panel mt-3">
      <div class="row g-3 align-items-center mb-3">
        <div class="col-auto">
          @if ($student->photo)
            <img src="{{ asset('storage/' . $student->photo) }}" alt="Profile photo" class="rounded-circle" style="width:96px;height:96px;object-fit:cover;">
          @else
            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width:96px;height:96px;">
              <i class="bi bi-person fs-2 text-muted" aria-hidden="true"></i>
            </div>
          @endif
        </div>
        <div class="col">
          <h2 class="h5 mb-1">{{ $student->first_name }} {{ $student->last_name }}</h2>
          <p class="text-muted mb-0">Student ID: {{ $student->student_id }}</p>
        </div>
      </div>

      <div class="row g-3">
        <div class="col-12 col-md-4">
          <div class="text-muted small">ថ្នាក់ / Class</div>
          <div class="fw-semibold">{{ $student->schoolClass->class_name ?? 'No class assigned' }}</div>
        </div>
        <div class="col-12 col-md-4">
          <div class="text-muted small">ភេទ / Gender</div>
          <div class="fw-semibold">{{ $student->gender === 'M' ? 'Male' : ($student->gender === 'F' ? 'Female' : '—') }}</div>
        </div>
        <div class="col-12 col-md-4">
          <div class="text-muted small">ថ្ងៃខែឆ្នាំកំណើត / Date of Birth</div>
          <div class="fw-semibold">{{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('M j, Y') : '—' }}</div>
        </div>
        <div class="col-12 col-md-4">
          <div class="text-muted small">លេខទូរស័ព្ទឪពុកម្តាយ / Parent Phone</div>
          <div class="fw-semibold">{{ $student->parent_phone ?? '—' }}</div>
        </div>
        <div class="col-12 col-md-4">
          <div class="text-muted small">ស្ថានភាព / Status</div>
          <div class="fw-semibold text-capitalize">{{ $student->status }}</div>
        </div>
      </div>
    </section>

  </div>
</main>

@include('student.include.footer')
