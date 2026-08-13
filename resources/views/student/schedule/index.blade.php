@include('student.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-calendar3" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Overview</p>
          <h1 class="h3 mb-1">កាលវិភាគ / My Schedule</h1>
          <p class="text-muted mb-0">Your full weekly class timetable.</p>
        </div>
      </div>
    </div>

    @forelse ($schedules as $day => $periods)
      <section class="panel mt-3">
        <div class="panel-header">
          <h2 class="h5 mb-0 section-title">{{ $day }}</h2>
        </div>
        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead>
              <tr>
                <th>ម៉ោង / Time</th>
                <th>មុខវិជ្ជា / Subject</th>
                <th>គ្រូ / Teacher</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($periods as $period)
                <tr>
                  <td>{{ \Carbon\Carbon::parse($period->start_time)->format('g:i A') }} – {{ \Carbon\Carbon::parse($period->end_time)->format('g:i A') }}</td>
                  <td>{{ $period->subject->subject_name ?? '—' }}</td>
                  <td>{{ $period->teacher->first_name ?? '' }} {{ $period->teacher->last_name ?? '' }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </section>
    @empty
      <div class="panel mt-3">
        <p class="text-muted mb-0">No schedule found for your class yet.</p>
      </div>
    @endforelse

  </div>
</main>

@include('student.include.footer')
