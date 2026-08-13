@include('student.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-journal-check" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Overview</p>
          <h1 class="h3 mb-1">ពិន្ទុ / My Grades</h1>
          <p class="text-muted mb-0">Your grades across all subjects and semesters.</p>
        </div>
      </div>
    </div>

    @forelse ($grades as $semester => $subjectGrades)
      <section class="panel mt-3">
        <div class="panel-header">
          <h2 class="h5 mb-0 section-title">{{ $semester }}</h2>
        </div>
        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead>
              <tr>
                <th>មុខវិជ្ជា / Subject</th>
                <th>ពិន្ទុពាក់កណ្ដាល / Midterm</th>
                <th>ពិន្ទុចុងឆមាស / Final</th>
                <th>មធ្យម / Average</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($subjectGrades as $grade)
                @php
                  $avg = collect([$grade->midterm_score, $grade->final_score])->filter()->avg();
                @endphp
                <tr>
                  <td>{{ $grade->subject->subject_name ?? '—' }}</td>
                  <td>{{ $grade->midterm_score ?? '—' }}</td>
                  <td>{{ $grade->final_score ?? '—' }}</td>
                  <td>
                    @if ($avg !== null)
                      <span class="badge text-bg-{{ $avg >= 50 ? 'success' : 'danger' }}">{{ number_format($avg, 1) }}</span>
                    @else
                      —
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </section>
    @empty
      <div class="panel mt-3">
        <p class="text-muted mb-0">No grades recorded yet.</p>
      </div>
    @endforelse

  </div>
</main>

@include('student.include.footer')
