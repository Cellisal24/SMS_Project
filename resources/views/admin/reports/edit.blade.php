@include('admin.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-file-earmark-text" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Edit</p>
          <h1 class="h3 mb-1">
            របាយការណ៍ / Report — {{ $report->student->first_name ?? '' }} {{ $report->student->last_name ?? '' }}
          </h1>
          <p class="text-muted mb-0">{{ $report->semester }} · {{ $report->academic_year }} · {{ $report->schoolClass->class_name ?? $report->class_id }}</p>
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
      <div class="row g-3 mb-3">
        <div class="col-6 col-md-3">
          <div class="text-muted small">សរុប / Total</div>
          <div class="fw-semibold">{{ $report->total_score !== null ? number_format($report->total_score, 2) : '—' }}</div>
        </div>
        <div class="col-6 col-md-3">
          <div class="text-muted small">មធ្យមភាគ / Average</div>
          <div class="fw-semibold">{{ $report->average_score !== null ? number_format($report->average_score, 2) : '—' }}</div>
        </div>
        <div class="col-6 col-md-3">
          <div class="text-muted small">ចំណាត់ថ្នាក់ / Rank</div>
          <div class="fw-semibold">{{ $report->class_rank ?? '—' }}</div>
        </div>
        <div class="col-6 col-md-3">
          <div class="text-muted small">វត្តមាន / Attendance</div>
          <div class="fw-semibold">{{ $report->attendance_percentage !== null ? number_format($report->attendance_percentage, 1) . '%' : '—' }}</div>
        </div>
      </div>

      <form method="POST" action="{{ route('admin.reports.update', $report->report_id) }}">
        @csrf
        @method('PUT')

        <div class="row g-3">
          <div class="col-12">
            <label class="form-label" for="teacher_comments">មតិយោបល់គ្រូ / Teacher Comments</label>
            <textarea name="teacher_comments" id="teacher_comments" class="form-control" rows="4">{{ old('teacher_comments', $report->teacher_comments) }}</textarea>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label" for="generated_by">គ្រូទទួលបន្ទុក / Reviewed By</label>
            <select name="generated_by" id="generated_by" class="form-select">
              <option value="">-- None --</option>
              @foreach ($teachers as $teacher)
                <option value="{{ $teacher->teacher_id }}" {{ old('generated_by', $report->generated_by) === $teacher->teacher_id ? 'selected' : '' }}>
                  {{ $teacher->first_name }} {{ $teacher->last_name }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label" for="status">ស្ថានភាព / Status</label>
            <select name="status" id="status" class="form-select" required>
              <option value="draft" {{ old('status', $report->status) === 'draft' ? 'selected' : '' }}>Draft</option>
              <option value="published" {{ old('status', $report->status) === 'published' ? 'selected' : '' }}>Published</option>
            </select>
          </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">
          <i class="bi bi-save" aria-hidden="true"></i> រក្សាទុក / Save
        </button>
        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary mt-3">បោះបង់ / Cancel</a>
      </form>
    </section>

  </div>
</main>

@include('admin.include.footer')
