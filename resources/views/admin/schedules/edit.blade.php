@include('admin.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-pencil-square" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Edit</p>
          <h1 class="h3 mb-1">កែប្រែកាលវិភាគ / Edit Schedule</h1>
        </div>
      </div>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger mt-3">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <section class="panel mt-3">
      <form method="POST" action="{{ route('admin.schedules.update', $schedule->schedule_id) }}">
        @csrf
        @method('PUT')

        <div class="row g-3">
          <div class="col-12 col-md-6">
            <label class="form-label" for="class_id">ថ្នាក់ / Class</label>
            <select name="class_id" id="class_id" class="form-select" required>
              @foreach ($classes as $class)
                <option value="{{ $class->class_id }}" {{ $schedule->class_id === $class->class_id ? 'selected' : '' }}>
                  {{ $class->class_name }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label" for="subject_id">មុខវិជ្ជា / Subject</label>
            <select name="subject_id" id="subject_id" class="form-select" required>
              @foreach ($subjects as $subject)
                <option value="{{ $subject->subject_id }}" {{ $schedule->subject_id === $subject->subject_id ? 'selected' : '' }}>
                  {{ $subject->subject_name }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label" for="teacher_id">គ្រូ / Teacher</label>
            <select name="teacher_id" id="teacher_id" class="form-select" required>
              @foreach ($teachers as $teacher)
                <option value="{{ $teacher->teacher_id }}" {{ $schedule->teacher_id === $teacher->teacher_id ? 'selected' : '' }}>
                  {{ $teacher->first_name }} {{ $teacher->last_name }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label" for="day_of_week">ថ្ងៃ / Day</label>
            <select name="day_of_week" id="day_of_week" class="form-select" required>
              @foreach ($days as $day)
                <option value="{{ $day }}" {{ $schedule->day_of_week === $day ? 'selected' : '' }}>{{ $day }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label" for="start_time">ម៉ោងចាប់ផ្ដើម / Start Time</label>
            <input type="time" name="start_time" id="start_time" class="form-control" value="{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}" required>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label" for="end_time">ម៉ោងបញ្ចប់ / End Time</label>
            <input type="time" name="end_time" id="end_time" class="form-control" value="{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}" required>
          </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">
          <i class="bi bi-save" aria-hidden="true"></i> ធ្វើបច្ចុប្បន្នភាព / Update
        </button>
        <a href="{{ route('admin.schedules.index') }}" class="btn btn-outline-secondary mt-3">បោះបង់ / Cancel</a>
      </form>
    </section>

  </div>
</main>

@include('admin.include.footer')
