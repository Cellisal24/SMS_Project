@include('teacher.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Welcome back</p>
          <h1 class="h3 mb-1">{{ $teacher->first_name }} {{ $teacher->last_name }}</h1>
          <p class="text-muted mb-0">Teacher ID: {{ $teacher->teacher_id }}</p>
        </div>
      </div>
    </div>

    <section class="row g-3 mt-1" aria-label="Teacher metrics">
      <div class="col-12 col-sm-6 col-xl-3">
        <article class="metric-card metric-primary">
          <div class="metric-top">
            <span class="metric-label">Classes</span>
            <span class="metric-icon"><i class="bi bi-door-open" aria-hidden="true"></i></span>
          </div>
          <div class="metric-value">{{ $classCount }}</div>
        </article>
      </div>

      <div class="col-12 col-sm-6 col-xl-3">
        <article class="metric-card metric-success">
          <div class="metric-top">
            <span class="metric-label">Subjects</span>
            <span class="metric-icon"><i class="bi bi-journal-bookmark" aria-hidden="true"></i></span>
          </div>
          <div class="metric-value">{{ $subjectCount }}</div>
        </article>
      </div>

      <div class="col-12 col-sm-6 col-xl-3">
        <article class="metric-card metric-warning">
          <div class="metric-top">
            <span class="metric-label">Pending Grading</span>
            <span class="metric-icon"><i class="bi bi-pencil-square" aria-hidden="true"></i></span>
          </div>
          <div class="metric-value">{{ $pendingGrading }}</div>
        </article>
      </div>

      <div class="col-12 col-sm-6 col-xl-3">
        <article class="metric-card metric-danger">
          <div class="metric-top">
            <span class="metric-label">Today's Periods</span>
            <span class="metric-icon"><i class="bi bi-calendar3" aria-hidden="true"></i></span>
          </div>
          <div class="metric-value">{{ $todaySchedule->count() }}</div>
        </article>
      </div>
    </section>

    <section class="row g-3 mt-1">
      <div class="col-12 col-xl-7">
        <div class="panel">
          <div class="panel-header">
            <div>
              <h2 class="h5 mb-1 section-title"><i class="bi bi-calendar3" aria-hidden="true"></i><span>Today's Schedule</span></h2>
              <p class="text-muted mb-0">{{ now()->format('l, F j, Y') }}</p>
            </div>
          </div>

          @if ($todaySchedule->isEmpty())
            <p class="text-muted mb-0">No classes scheduled for today.</p>
          @else
            <div class="table-responsive">
              <table class="table align-middle mb-0">
                <thead>
                  <tr><th>Time</th><th>Class</th><th>Subject</th></tr>
                </thead>
                <tbody>
                  @foreach ($todaySchedule as $period)
                    <tr>
                      <td>{{ \Carbon\Carbon::parse($period->start_time)->format('g:i A') }} – {{ \Carbon\Carbon::parse($period->end_time)->format('g:i A') }}</td>
                      <td>{{ $period->schoolClass->class_name ?? '—' }}</td>
                      <td>{{ $period->subject->subject_name ?? '—' }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @endif
        </div>
      </div>

      <div class="col-12 col-xl-5">
        <div class="panel h-100">
          <div class="panel-header">
            <div>
              <h2 class="h5 mb-1 section-title"><i class="bi bi-clipboard-check" aria-hidden="true"></i><span>Recent Attendance Taken</span></h2>
            </div>
          </div>

          @if ($recentAttendance->isEmpty())
            <p class="text-muted mb-0">No attendance recorded yet.</p>
          @else
            <div class="activity-list">
              @foreach ($recentAttendance as $record)
                <div class="activity-item">
                  <span class="activity-dot {{ $record->status === 'present' ? 'bg-success' : 'bg-danger' }}"></span>
                  <div>
                    <p class="mb-1 fw-semibold">{{ $record->student->first_name ?? '' }} {{ $record->student->last_name ?? '' }}</p>
                    <p class="text-muted small mb-0">{{ ucfirst($record->status) }} — {{ \Carbon\Carbon::parse($record->date)->format('M j') }}</p>
                  </div>
                </div>
              @endforeach
            </div>
          @endif
        </div>
      </div>
    </section>

  </div>
</main>

@include('teacher.include.footer')
