@include(auth()->user()->role === 'teacher' ? 'teacher.include.header' : 'admin.include.header')
<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-pencil-square" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Edit</p>
          <h1 class="h3 mb-1">កែប្រែវត្តមាន / Edit Attendance</h1>
          <p class="text-muted mb-0">
            {{ $attendance->student->first_name ?? '' }} {{ $attendance->student->last_name ?? '' }}
            — {{ \Carbon\Carbon::parse($attendance->date)->format('M j, Y') }}
          </p>
        </div>
      </div>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger mt-3">{{ $errors->first() }}</div>
    @endif

    <section class="panel mt-3">
      <form method="POST" action="{{ route('admin.attendance.update', $attendance->attendance_id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label class="form-label" for="status">ស្ថានភាព / Status</label>
          <select name="status" id="status" class="form-select" required>
            <option value="present" {{ $attendance->status === 'present' ? 'selected' : '' }}>Present</option>
            <option value="absent" {{ $attendance->status === 'absent' ? 'selected' : '' }}>Absent</option>
            <option value="late" {{ $attendance->status === 'late' ? 'selected' : '' }}>Late</option>
            <option value="excused" {{ $attendance->status === 'excused' ? 'selected' : '' }}>Excused</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label" for="leave_reason">មូលហេតុច្បាប់ឈប់ / Leave Reason</label>
          <input type="text" name="leave_reason" id="leave_reason" class="form-control" value="{{ $attendance->leave_reason }}">
        </div>

        <button type="submit" class="btn btn-primary">
          <i class="bi bi-save" aria-hidden="true"></i> ធ្វើបច្ចុប្បន្នភាព / Update
        </button>
        <a href="{{ route('admin.attendance.index') }}" class="btn btn-outline-secondary">បោះបង់ / Cancel</a>
      </form>
    </section>

  </div>
</main>
@include(auth()->user()->role === 'teacher' ? 'teacher.include.footer' : 'admin.include.footer')

