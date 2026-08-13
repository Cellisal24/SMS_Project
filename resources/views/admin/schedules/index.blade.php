@include('admin.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-calendar3" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Overview</p>
          <h1 class="h3 mb-1">កាលវិភាគ / Schedules</h1>
          <p class="text-muted mb-0">Manage the class timetable.</p>
        </div>
      </div>
      <div class="heading-actions">
        <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary btn-sm">
          <i class="bi bi-plus-lg" aria-hidden="true"></i> បន្ថែមកាលវិភាគ / Add Schedule
        </a>
      </div>
    </div>

    @if (session('status'))
      <div class="alert alert-success alert-dismissible mt-3">{{ session('status') }}</div>
    @endif

    <div class="panel mt-3">
      <form method="GET" action="{{ route('admin.schedules.index') }}" class="row g-2 align-items-end">
        <div class="col-12 col-md-4">
          <label class="form-label small">ថ្នាក់ / Class</label>
          <select name="class_id" class="form-select">
            <option value="">-- All classes --</option>
            @foreach ($classes as $class)
              <option value="{{ $class->class_id }}" {{ request('class_id') === $class->class_id ? 'selected' : '' }}>
                {{ $class->class_name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-12 col-md-4">
          <label class="form-label small">គ្រូ / Teacher</label>
          <select name="teacher_id" class="form-select">
            <option value="">-- All teachers --</option>
            @foreach ($teachers as $teacher)
              <option value="{{ $teacher->teacher_id }}" {{ request('teacher_id') === $teacher->teacher_id ? 'selected' : '' }}>
                {{ $teacher->first_name }} {{ $teacher->last_name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-12 col-md-4 d-flex gap-2">
          <button type="submit" class="btn btn-outline-secondary"><i class="bi bi-funnel" aria-hidden="true"></i> Filter</button>
          <a href="{{ route('admin.schedules.index') }}" class="btn btn-outline-secondary">Clear</a>
        </div>
      </form>
    </div>

    <section class="panel mt-3">
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th>ថ្ងៃ / Day</th>
              <th>ម៉ោង / Time</th>
              <th>ថ្នាក់ / Class</th>
              <th>មុខវិជ្ជា / Subject</th>
              <th>គ្រូ / Teacher</th>
              <th class="text-end">សកម្មភាព / Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($schedules as $schedule)
              <tr>
                <td>{{ $schedule->day_of_week }}</td>
                <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }} – {{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}</td>
                <td>{{ $schedule->schoolClass->class_name ?? '—' }}</td>
                <td>{{ $schedule->subject->subject_name ?? '—' }}</td>
                <td>{{ $schedule->teacher->first_name ?? '' }} {{ $schedule->teacher->last_name ?? '' }}</td>
                <td class="text-end">
                  <a href="{{ route('admin.schedules.edit', $schedule->schedule_id) }}" class="btn btn-light btn-sm">
                    <i class="bi bi-pencil" aria-hidden="true"></i>
                  </a>
                  <form method="POST" action="{{ route('admin.schedules.destroy', $schedule->schedule_id) }}" class="d-inline" onsubmit="return confirm('Delete this schedule entry?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-light btn-sm text-danger">
                      <i class="bi bi-trash" aria-hidden="true"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center text-muted py-4">No schedule entries yet.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-3">
        {{ $schedules->links() }}
      </div>
    </section>

  </div>
</main>

@include('admin.include.footer')
