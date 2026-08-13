@include('student.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-file-text" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Overview</p>
          <h1 class="h3 mb-1">ការប្រឡង / Exams</h1>
          <p class="text-muted mb-0">Upcoming exams and your past results.</p>
        </div>
      </div>
    </div>

    <section class="panel mt-3">
      <div class="panel-header">
        <h2 class="h5 mb-0 section-title"><i class="bi bi-calendar-event" aria-hidden="true"></i><span>ការប្រឡងខាងមុខ / Upcoming Exams</span></h2>
      </div>
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th>មុខវិជ្ជា / Subject</th>
              <th>កាលបរិច្ឆេទ / Date</th>
              <th>ម៉ោង / Time</th>
              <th>បន្ទប់ / Room</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($upcomingExams as $exam)
              <tr>
                <td>{{ $exam->subject->subject_name ?? '—' }}</td>
                <td>{{ \Carbon\Carbon::parse($exam->exam_date)->format('M j, Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($exam->start_time)->format('g:i A') }} – {{ \Carbon\Carbon::parse($exam->end_time)->format('g:i A') }}</td>
                <td>{{ $exam->room->room_name ?? '—' }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="text-center text-muted py-4">No upcoming exams scheduled.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </section>

    <section class="panel mt-3">
      <div class="panel-header">
        <h2 class="h5 mb-0 section-title"><i class="bi bi-file-earmark-check" aria-hidden="true"></i><span>លទ្ធផលរបស់ខ្ញុំ / My Results</span></h2>
      </div>
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th>មុខវិជ្ជា / Subject</th>
              <th>កាលបរិច្ឆេទ / Date</th>
              <th>ពិន្ទុ / Score</th>
              <th>ចំណាំ / Remarks</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($results as $result)
              <tr>
                <td>{{ $result->exam->subject->subject_name ?? '—' }}</td>
                <td>{{ $result->exam ? \Carbon\Carbon::parse($result->exam->exam_date)->format('M j, Y') : '—' }}</td>
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
                <td colspan="4" class="text-center text-muted py-4">No results recorded yet.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </section>

  </div>
</main>

@include('student.include.footer')
