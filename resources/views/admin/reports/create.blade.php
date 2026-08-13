@include('admin.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-file-earmark-text" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">New</p>
          <h1 class="h3 mb-1">បង្កើតរបាយការណ៍ / Generate Reports</h1>
          <p class="text-muted mb-0">Choose a class, semester, and academic year. A report card will be generated for every student in the class, using their existing grades and attendance.</p>
        </div>
      </div>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger mt-3">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <section class="panel mt-3">
      <form method="POST" action="{{ route('admin.reports.store') }}">
        @csrf

        <div class="row g-3">
          <div class="col-12 col-md-5">
            <label class="form-label" for="class_id">ថ្នាក់ / Class</label>
            <select name="class_id" id="class_id" class="form-select" required>
              <option value="">-- Select --</option>
              @foreach ($classes as $class)
                <option value="{{ $class->class_id }}" {{ old('class_id') === $class->class_id ? 'selected' : '' }}>
                  {{ $class->class_name }} ({{ $class->academic_year }})
                </option>
              @endforeach
            </select>
          </div>

          <div class="col-12 col-md-4">
            <label class="form-label" for="semester">ឆមាស / Semester</label>
            <input list="semesterOptions" name="semester" id="semester" class="form-control" placeholder="e.g. Semester 1" value="{{ old('semester') }}" required>
            <datalist id="semesterOptions">
              <option value="Semester 1">
              <option value="Semester 2">
            </datalist>
          </div>

          <div class="col-12 col-md-3">
            <label class="form-label" for="academic_year">ឆ្នាំសិក្សា / Academic Year</label>
            <input type="number" name="academic_year" id="academic_year" class="form-control" value="{{ old('academic_year', now()->year) }}" required>
          </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">
          <i class="bi bi-magic" aria-hidden="true"></i> បង្កើត / Generate
        </button>
        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary mt-3">បោះបង់ / Cancel</a>
      </form>
    </section>

    <p class="text-muted mt-3 small">
      Note: total/average score come from the <code>grades</code> table for the selected semester, and attendance percentage is calculated from all attendance records on file for each student. Running this again for the same class/semester/year will refresh the existing reports rather than duplicate them.
    </p>

  </div>
</main>

@include('admin.include.footer')
