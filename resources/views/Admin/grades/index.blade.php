@include('Admin.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-journal-check" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Overview</p>
          <h1 class="h3 mb-1">ពិន្ទុ / Grades</h1>
          <p class="text-muted mb-0">Oversight of all student grades across every class and subject.</p>
        </div>
      </div>
      <div class="heading-actions">
        <a href="{{ route('admin.grades.create') }}" class="btn btn-primary btn-sm">
          <i class="bi bi-plus-lg" aria-hidden="true"></i> បញ្ចូលពិន្ទុ / Enter Grades
        </a>
      </div>
    </div>

    @if (session('status'))
      <div class="alert alert-success alert-dismissible mt-3">{{ session('status') }}</div>
    @endif

    <div class="panel mt-3">
      <form method="GET" action="{{ route('admin.grades.index') }}" class="row g-2 align-items-end">
        <div class="col-12 col-md-3">
          <label class="form-label small">ថ្នាក់ / Class</label>
          <select name="class_id" class="form-select">
            <option value="">-- All classes --</option>
            @foreach ($classes as $class)
              <option value="{{ $class->class_id }}" {{ request('class_id') === $class->class_id ? 'selected' : '' }}>
                {{ $class->class_name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-12 col-md-3">
          <label class="form-label small">មុខវិជ្ជា / Subject</label>
          <select name="subject_id" class="form-select">
            <option value="">-- All subjects --</option>
            @foreach ($subjects as $subject)
              <option value="{{ $subject->subject_id }}" {{ request('subject_id') === $subject->subject_id ? 'selected' : '' }}>
                {{ $subject->subject_name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-12 col-md-3">
          <label class="form-label small">ឆមាស / Semester</label>
          <input type="text" name="semester" class="form-control" placeholder="e.g. Semester 1" value="{{ request('semester') }}">
        </div>
        <div class="col-12 col-md-3 d-flex gap-2">
          <button type="submit" class="btn btn-outline-secondary"><i class="bi bi-funnel" aria-hidden="true"></i> Filter</button>
          <a href="{{ route('admin.grades.index') }}" class="btn btn-outline-secondary">Clear</a>
        </div>
      </form>
    </div>

    <section class="panel mt-3">
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th>សិស្ស / Student</th>
              <th>មុខវិជ្ជា / Subject</th>
              <th>ឆមាស / Semester</th>
              <th>ពិន្ទុពាក់កណ្ដាល / Midterm</th>
              <th>ពិន្ទុចុងឆមាស / Final</th>
              <th class="text-end">សកម្មភាព / Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($grades as $grade)
              <tr>
                <td>
                  {{ $grade->student->first_name ?? '' }} {{ $grade->student->last_name ?? '' }}
                  <div class="text-muted small">{{ $grade->student_id }}</div>
                </td>
                <td>{{ $grade->subject->subject_name ?? '—' }}</td>
                <td>{{ $grade->semester }}</td>
                <td>{{ $grade->midterm_score ?? '—' }}</td>
                <td>{{ $grade->final_score ?? '—' }}</td>
                <td class="text-end">
                  <a href="{{ route('admin.grades.edit', $grade->grade_id) }}" class="btn btn-light btn-sm">
                    <i class="bi bi-pencil" aria-hidden="true"></i>
                  </a>
                  <form method="POST" action="{{ route('admin.grades.destroy', $grade->grade_id) }}" class="d-inline" onsubmit="return confirm('Delete this grade record?');">
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
                <td colspan="6" class="text-center text-muted py-4">No grade records found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-3">
        {{ $grades->links() }}
      </div>
    </section>

  </div>
</main>

@include('Admin.include.footer')