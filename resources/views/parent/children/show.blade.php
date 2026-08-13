@include('parent.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        @if ($student->photo)
          <img src="{{ asset('storage/' . $student->photo) }}" alt="{{ $student->first_name }}" class="rounded-circle" style="width:56px;height:56px;object-fit:cover;">
        @else
          <span class="page-icon"><i class="bi bi-person" aria-hidden="true"></i></span>
        @endif
        <div>
          <p class="eyebrow mb-1">Student Details</p>
          <h1 class="h3 mb-1">{{ $student->first_name }} {{ $student->last_name }}</h1>
          <p class="text-muted mb-0">{{ $student->schoolClass->class_name ?? 'No class assigned' }} — {{ $student->student_id }}</p>
        </div>
      </div>
      <div class="heading-actions">
        <a href="{{ route('parent.children.index') }}" class="btn btn-outline-secondary btn-sm">
          <i class="bi bi-arrow-left" aria-hidden="true"></i> ត្រឡប់ក្រោយ / Back
        </a>
      </div>
    </div>

    <section class="row g-3 mt-1">
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

    <section class="panel mt-3">
      <div class="panel-header">
        <h2 class="h5 mb-0 section-title"><i class="bi bi-award" aria-hidden="true"></i><span>ពិន្ទុ / Grades</span></h2>
      </div>
      @forelse ($grades as $semester => $subjectGrades)
        <p class="fw-semibold mt-2 mb-1">{{ $semester }}</p>
        <div class="table-responsive mb-3">
          <table class="table align-middle mb-0">
            <thead>
              <tr>
                <th>មុខវិជ្ជា / Subject</th>
                <th>ពាក់កណ្ដាល / Midterm</th>
                <th>ចុងឆមាស / Final</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($subjectGrades as $grade)
                <tr>
                  <td>{{ $grade->subject->subject_name ?? '—' }}</td>
                  <td>{{ $grade->midterm_score ?? '—' }}</td>
                  <td>{{ $grade->final_score ?? '—' }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @empty
        <p class="text-muted mb-0">No grades recorded yet.</p>
      @endforelse
    </section>

    <section class="row g-3 mt-1">
      <div class="col-12 col-xl-6">
        <div class="panel h-100">
          <div class="panel-header">
            <h2 class="h5 mb-0 section-title"><i class="bi bi-calendar-event" aria-hidden="true"></i><span>ការប្រឡងខាងមុខ / Upcoming Exams</span></h2>
          </div>
          @forelse ($upcomingExams as $exam)
            <div class="activity-item">
              <span class="activity-dot bg-primary"></span>
              <div>
                <p class="mb-1 fw-semibold">{{ $exam->subject->subject_name ?? 'Subject' }}</p>
                <p class="text-muted small mb-0">{{ \Carbon\Carbon::parse($exam->exam_date)->format('M j, Y') }}</p>
              </div>
            </div>
          @empty
            <p class="text-muted mb-0">No upcoming exams.</p>
          @endforelse
        </div>
      </div>

      <div class="col-12 col-xl-6">
        <div class="panel h-100">
          <div class="panel-header">
            <h2 class="h5 mb-0 section-title"><i class="bi bi-cash-coin" aria-hidden="true"></i><span>ការទូទាត់ / Payments</span></h2>
          </div>
          @if ($payments->isEmpty())
            <p class="text-muted mb-0">No payment records yet.</p>
          @else
            <div class="table-responsive">
              <table class="table align-middle mb-0">
                <thead>
                  <tr>
                    <th>ការពិពណ៌នា / Description</th>
                    <th>សរុប / Total</th>
                    <th>បានបង់ / Paid</th>
                    <th>ស្ថានភាព / Status</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($payments as $payment)
                    @php $balance = $payment->total_fee - ($payment->discount ?? 0) - $payment->amount_paid; @endphp
                    <tr>
                      <td>{{ $payment->description ?? '—' }}</td>
                      <td>${{ number_format($payment->total_fee, 2) }}</td>
                      <td>${{ number_format($payment->amount_paid, 2) }}</td>
                      <td>
                        @if ($balance > 0)
                          <span class="badge text-bg-danger">${{ number_format($balance, 2) }} due</span>
                        @else
                          <span class="badge text-bg-success">Paid</span>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @endif
        </div>
      </div>
    </section>

  </div>
</main>

@include('parent.include.footer')
