@include('student.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Welcome back</p>
          <h1 class="h3 mb-1">{{ $student->first_name }} {{ $student->last_name }}</h1>
          <p class="text-muted mb-0">
            {{ $student->schoolClass->class_name ?? 'No class assigned' }} — Student ID: {{ $student->student_id }}
          </p>
        </div>
      </div>
    </div>

    {{-- Attendance summary cards --}}
    <section class="row g-3 mt-1" aria-label="Attendance summary">
      <div class="col-12 col-sm-6 col-xl-3">
        <article class="metric-card metric-success">
          <div class="metric-top">
            <span class="metric-label">Present</span>
            <span class="metric-icon"><i class="bi bi-check-circle" aria-hidden="true"></i></span>
          </div>
          <div class="metric-value">{{ $attendanceSummary['present'] ?? 0 }}</div>
        </article>
      </div>

      <div class="col-12 col-sm-6 col-xl-3">
        <article class="metric-card metric-danger">
          <div class="metric-top">
            <span class="metric-label">Absent</span>
            <span class="metric-icon"><i class="bi bi-x-circle" aria-hidden="true"></i></span>
          </div>
          <div class="metric-value">{{ $attendanceSummary['absent'] ?? 0 }}</div>
        </article>
      </div>

      <div class="col-12 col-sm-6 col-xl-3">
        <article class="metric-card metric-warning">
          <div class="metric-top">
            <span class="metric-label">Late</span>
            <span class="metric-icon"><i class="bi bi-clock-history" aria-hidden="true"></i></span>
          </div>
          <div class="metric-value">{{ $attendanceSummary['late'] ?? 0 }}</div>
        </article>
      </div>

      <div class="col-12 col-sm-6 col-xl-3">
        <article class="metric-card metric-primary">
          <div class="metric-top">
            <span class="metric-label">Upcoming Exams</span>
            <span class="metric-icon"><i class="bi bi-journal-text" aria-hidden="true"></i></span>
          </div>
          <div class="metric-value">{{ $upcomingExams->count() }}</div>
        </article>
      </div>
    </section>

    <section class="row g-3 mt-1">
      {{-- Today's schedule --}}
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
                  <tr>
                    <th>Time</th>
                    <th>Subject</th>
                    <th>Teacher</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($todaySchedule as $period)
                    <tr>
                      <td>{{ \Carbon\Carbon::parse($period->start_time)->format('g:i A') }} – {{ \Carbon\Carbon::parse($period->end_time)->format('g:i A') }}</td>
                      <td>{{ $period->subject->subject_name ?? '—' }}</td>
                      <td>{{ $period->teacher->first_name ?? '' }} {{ $period->teacher->last_name ?? '' }}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @endif
        </div>
      </div>

      {{-- Upcoming exams --}}
      <div class="col-12 col-xl-5">
        <div class="panel h-100">
          <div class="panel-header">
            <div>
              <h2 class="h5 mb-1 section-title"><i class="bi bi-journal-check" aria-hidden="true"></i><span>Upcoming Exams</span></h2>
            </div>
          </div>

          @if ($upcomingExams->isEmpty())
            <p class="text-muted mb-0">No upcoming exams scheduled.</p>
          @else
            <div class="activity-list">
              @foreach ($upcomingExams as $exam)
                <div class="activity-item">
                  <span class="activity-dot bg-primary"></span>
                  <div>
                    <p class="mb-1 fw-semibold">{{ $exam->subject->subject_name ?? 'Subject' }}</p>
                    <p class="text-muted small mb-0">{{ \Carbon\Carbon::parse($exam->exam_date)->format('M j, Y') }}</p>
                  </div>
                </div>
              @endforeach
            </div>
          @endif
        </div>
      </div>
    </section>

    {{-- Recent grades --}}
    <section class="panel mt-3">
      <div class="panel-header">
        <div>
          <h2 class="h5 mb-1 section-title"><i class="bi bi-award" aria-hidden="true"></i><span>Recent Grades</span></h2>
        </div>
      </div>

      @if ($recentGrades->isEmpty())
        <p class="text-muted mb-0">No grades recorded yet.</p>
      @else
        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead>
              <tr>
                <th>Subject</th>
                <th>Semester</th>
                <th>Midterm</th>
                <th>Final</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($recentGrades as $grade)
                <tr>
                  <td>{{ $grade->subject->subject_name ?? '—' }}</td>
                  <td>{{ $grade->semester }}</td>
                  <td>{{ $grade->midterm_score ?? '—' }}</td>
                  <td>{{ $grade->final_score ?? '—' }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </section>

  </div>
</main>

@include('student.include.footer')
