@include('teacher.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-file-earmark-check" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Overview</p>
          <h1 class="h3 mb-1">លទ្ធផលប្រឡង / Exam Results</h1>
          <p class="text-muted mb-0">Results for exams in your own subjects.</p>
        </div>
      </div>
      <div class="heading-actions">
        <a href="{{ route('teacher.exam-results.create') }}" class="btn btn-primary btn-sm">
          <i class="bi bi-plus-lg" aria-hidden="true"></i> បញ្ចូលពិន្ទុ / Enter Results
        </a>
      </div>
    </div>

    @if (session('success'))
      <div class="alert alert-success alert-dismissible mt-3">{{ session('success') }}</div>
    @endif

    <div class="panel mt-3">
      <form method="GET" action="{{ route('teacher.exam-results.index') }}" class="row g-2 align-items-end">
        <div class="col-12 col-md-8">
          <label class="form-label small">ការប្រឡង / Exam</label>
          <select name="exam_id" class="form-select">
            <option value="">-- All my exams --</option>
            @foreach ($exams as $exam)
              <option value="{{ $exam->exam_id }}" {{ request('exam_id') == $exam->exam_id ? 'selected' : '' }}>
                {{ $exam->subject->subject_name ?? '' }} — {{ $exam->schoolClass->class_name ?? '' }} — {{ \Carbon\Carbon::parse($exam->exam_date)->format('M j, Y') }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-12 col-md-4 d-flex gap-2">
          <button type="submit" class="btn btn-outline-secondary"><i class="bi bi-funnel" aria-hidden="true"></i> Filter</button>
          <a href="{{ route('teacher.exam-results.index') }}" class="btn btn-outline-secondary">Clear</a>
        </div>
      </form>
    </div>

    <section class="panel mt-3">
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th>សិស្ស / Student</th>
              <th>ការប្រឡង / Exam</th>
              <th>ថ្នាក់ / Class</th>
              <th>ពិន្ទុ / Score</th>
              <th>ចំណាំ / Remarks</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($results as $result)
              <tr>
                <td>
                  {{ $result->student->first_name ?? '' }} {{ $result->student->last_name ?? '' }}
                  <div class="text-muted small">{{ $result->student_id }}</div>
                </td>
                <td>{{ $result->exam->subject->subject_name ?? '—' }}</td>
                <td>{{ $result->exam->schoolClass->class_name ?? '—' }}</td>
                <td>
                  {{ $result->score }} / {{ $result->max_score }}
                  <span class="badge text-bg-{{ ($result->score / $result->max_score) >= 0.5 ? 'success' : 'danger' }}">
                    {{ number_format(($result->score / $result->max_score) * 100, 1) }}%
                  </span>
                </td>
                <td>{{ $result->remarks ?? '—' }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted py-4">No exam results recorded yet.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-3">
        {{ $results->links() }}
      </div>
    </section>

  </div>
</main>

@include('teacher.include.footer')
