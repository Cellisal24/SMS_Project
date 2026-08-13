@include(auth()->user()->role === 'teacher' ? 'teacher.include.header' : 'admin.include.header')
<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-clipboard-check" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">New</p>
          <h1 class="h3 mb-1">កត់ត្រាវត្តមាន / Mark Attendance</h1>
          <p class="text-muted mb-0">Choose a class period and date to load the student roster.</p>
        </div>
      </div>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger mt-3">{{ $errors->first() }}</div>
    @endif

    <section class="panel mt-3">
      <div class="row g-3 align-items-end">
        <div class="col-12 col-md-6">
          <label class="form-label small" for="schedule_id">កាលវិភាគ / Class Period</label>
          <select id="schedule_id" class="form-select">
            <option value="">-- Select a class period --</option>
            @foreach ($schedules as $schedule)
              <option value="{{ $schedule->schedule_id }}">
                {{ $schedule->day_of_week }} {{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }} —
                {{ $schedule->schoolClass->class_name ?? '' }} — {{ $schedule->subject->subject_name ?? '' }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="col-12 col-md-4">
          <label class="form-label small" for="attendance_date">កាលបរិច្ឆេទ / Date</label>
          <input type="date" id="attendance_date" class="form-control" value="{{ now()->toDateString() }}">
        </div>

        <div class="col-12 col-md-2">
          <button type="button" id="loadRosterBtn" class="btn btn-outline-primary w-100">
            <i class="bi bi-arrow-repeat" aria-hidden="true"></i> Load
          </button>
        </div>
      </div>
    </section>

    <section class="panel mt-3" id="rosterPanel" style="display:none;">
      <form method="POST" action="{{ route('admin.attendance.store') }}" id="attendanceForm">
        @csrf
        <input type="hidden" name="schedule_id" id="form_schedule_id">
        <input type="hidden" name="date" id="form_date">

        <div class="d-flex justify-content-between align-items-center mb-3">
          <h2 class="h6 mb-0">សិស្ស / Students</h2>
          <div class="d-flex gap-2">
            <button type="button" class="btn btn-sm btn-outline-success" data-mark-all="present">Mark all present</button>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead>
              <tr>
                <th>សិស្ស / Student</th>
                <th>ស្ថានភាព / Status</th>
                <th>មូលហេតុច្បាប់ឈប់ / Leave Reason</th>
              </tr>
            </thead>
            <tbody id="rosterBody">
              {{-- populated by JS --}}
            </tbody>
          </table>
        </div>

        <button type="submit" class="btn btn-primary mt-3">
          <i class="bi bi-save" aria-hidden="true"></i> រក្សាទុក / Save Attendance
        </button>
      </form>
    </section>

    <p class="text-muted mt-3" id="emptyRosterMsg">Select a class period and date, then click "Load" to see the student list.</p>

  </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const loadBtn = document.getElementById('loadRosterBtn');
  const rosterPanel = document.getElementById('rosterPanel');
  const rosterBody = document.getElementById('rosterBody');
  const emptyMsg = document.getElementById('emptyRosterMsg');

  loadBtn.addEventListener('click', function () {
    const scheduleId = document.getElementById('schedule_id').value;
    const date = document.getElementById('attendance_date').value;

    if (!scheduleId || !date) {
      alert('Please select a class period and date first.');
      return;
    }

    fetch(`{{ route('admin.attendance.roster') }}?schedule_id=${scheduleId}&date=${date}`)
      .then(res => res.json())
      .then(data => {
        document.getElementById('form_schedule_id').value = scheduleId;
        document.getElementById('form_date').value = date;

        rosterBody.innerHTML = '';

        if (data.students.length === 0) {
          emptyMsg.textContent = 'No students found for this class.';
          emptyMsg.style.display = 'block';
          rosterPanel.style.display = 'none';
          return;
        }

        data.students.forEach((student, index) => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>
              ${student.name}
              <input type="hidden" name="students[${index}][student_id]" value="${student.student_id}">
            </td>
            <td>
              <select name="students[${index}][status]" class="form-select form-select-sm status-select">
                <option value="present" ${student.status === 'present' ? 'selected' : ''}>Present</option>
                <option value="absent" ${student.status === 'absent' ? 'selected' : ''}>Absent</option>
                <option value="late" ${student.status === 'late' ? 'selected' : ''}>Late</option>
                <option value="excused" ${student.status === 'excused' ? 'selected' : ''}>Excused</option>
              </select>
            </td>
            <td>
              <input type="text" name="students[${index}][leave_reason]" class="form-control form-control-sm" placeholder="Optional">
            </td>
          `;
          rosterBody.appendChild(row);
        });

        rosterPanel.style.display = 'block';
        emptyMsg.style.display = 'none';
      })
      .catch(() => alert('Could not load the roster. Please try again.'));
  });

  document.querySelectorAll('[data-mark-all]').forEach(btn => {
    btn.addEventListener('click', function () {
      const status = this.dataset.markAll;
      document.querySelectorAll('.status-select').forEach(select => {
        select.value = status;
      });
    });
  });
});
</script>
@include(auth()->user()->role === 'teacher' ? 'teacher.include.footer' : 'admin.include.footer')

