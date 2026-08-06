@include('Parent.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-journal-check" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Overview</p>
          <h1 class="h3 mb-1">ពិន្ទុ / Grades</h1>
          <p class="text-muted mb-0">Grades across all your children.</p>
        </div>
      </div>
    </div>

    <div class="panel mt-3">
      <form method="GET" action="{{ route('parent.grades.index') }}" class="row g-2 align-items-end">
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
          <a href="{{ route('parent.grades.index') }}" class="btn btn-outline-secondary">Clear</a>
        </div>
      </form>
    </div>

    <section class="panel mt-3">
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th>កូន / Child</th>
              <th>មុខវិជ្ជា / Subject</th>
              <th>ឆមាស / Semester</th>
              <th>ពាក់កណ្ដាល / Midterm</th>
              <th>ចុងឆមាស / Final</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($grades as $grade)
              <tr>
                <td>{{ $grade->student->first_name ?? '' }} {{ $grade->student->last_name ?? '' }}</td>
                <td>{{ $grade->subject->subject_name ?? '—' }}</td>
                <td>{{ $grade->semester }}</td>
                <td>{{ $grade->midterm_score ?? '—' }}</td>
                <td>{{ $grade->final_score ?? '—' }}</td>
              </tr>
            @empty
              <tr><td colspan="5" class="text-center text-muted py-4">No grades recorded yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="mt-3">{{ $grades->links() }}</div>
    </section>

  </div>
</main>

@include('Parent.include.footer')