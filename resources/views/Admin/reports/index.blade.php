@include('Admin.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-file-earmark-text" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Overview</p>
          <h1 class="h3 mb-1">របាយការណ៍ / Reports</h1>
          <p class="text-muted mb-0">Student report cards, generated from grades and attendance.</p>
        </div>
      </div>
      <div class="heading-actions">
        <a href="{{ route('admin.reports.create') }}" class="btn btn-primary btn-sm">
          <i class="bi bi-plus-lg" aria-hidden="true"></i> បង្កើត / Generate Reports
        </a>
      </div>
    </div>

    @if (session('success'))
      <div class="alert alert-success alert-dismissible mt-3">{{ session('success') }}</div>
    @endif

    <div class="panel mt-3">
      <form method="GET" action="{{ route('admin.reports.index') }}" class="row g-2 align-items-end">
        <div class="col-12 col-md-3">
          <label class="form-label small">ស្វែងរក / Search</label>
          <input type="text" name="search" class="form-control" placeholder="Student name or ID" value="{{ request('search') }}">
        </div>
        <div class="col-12 col-md-3">
          <label class="form-label small">ថ្នាក់ / Class</label>
          <select name="class_id" class="form-select">
            <option value="">-- All --</option>
            @foreach ($classes as $class)
              <option value="{{ $class->class_id }}" {{ request('class_id') === $class->class_id ? 'selected' : '' }}>
                {{ $class->class_name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-12 col-md-2">
          <label class="form-label small">ឆមាស / Semester</label>
          <input type="text" name="semester" class="form-control" placeholder="Semester 1" value="{{ request('semester') }}">
        </div>
        <div class="col-12 col-md-2">
          <label class="form-label small">ស្ថានភាព / Status</label>
          <select name="status" class="form-select">
            <option value="">-- All --</option>
            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
          </select>
        </div>
        <div class="col-12 col-md-2 d-flex gap-2">
          <button type="submit" class="btn btn-outline-secondary"><i class="bi bi-funnel" aria-hidden="true"></i> Filter</button>
          <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary">Clear</a>
        </div>
      </form>
    </div>

    <section class="panel mt-3">
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th>សិស្ស / Student</th>
              <th>ថ្នាក់ / Class</th>
              <th>ឆមាស / Semester</th>
              <th>ឆំនាំ / Year</th>
              <th>មធ្យមភាគ / Average</th>
              <th>ចំណាត់ថ្នាក់ / Rank</th>
              <th>វត្តមាន / Attendance</th>
              <th>ស្ថានភាព / Status</th>
              <th class="text-end">សកម្មភាព / Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($reports as $report)
              <tr>
                <td>
                  {{ $report->student->first_name ?? '' }} {{ $report->student->last_name ?? '' }}
                  <div class="text-muted small">{{ $report->student_id }}</div>
                </td>
                <td>{{ $report->schoolClass->class_name ?? $report->class_id }}</td>
                <td>{{ $report->semester }}</td>
                <td>{{ $report->academic_year }}</td>
                <td>{{ $report->average_score !== null ? number_format($report->average_score, 2) : '—' }}</td>
                <td>{{ $report->class_rank ?? '—' }}</td>
                <td>{{ $report->attendance_percentage !== null ? number_format($report->attendance_percentage, 1) . '%' : '—' }}</td>
                <td>
                  @if ($report->status === 'published')
                    <span class="badge text-bg-success">Published</span>
                  @else
                    <span class="badge text-bg-secondary">Draft</span>
                  @endif
                </td>
                <td class="text-end">
                  <a href="{{ route('admin.reports.edit', $report->report_id) }}" class="btn btn-light btn-sm">
                    <i class="bi bi-pencil" aria-hidden="true"></i>
                  </a>
                  <form method="POST" action="{{ route('admin.reports.destroy', $report->report_id) }}" class="d-inline" onsubmit="return confirm('Delete this report?');">
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
                <td colspan="9" class="text-center text-muted py-4">No reports found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-3">
        {{ $reports->links() }}
      </div>
    </section>

  </div>
</main>

@include('Admin.include.footer')