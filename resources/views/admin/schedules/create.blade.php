@include('admin.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-calendar-plus" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">New</p>
          <h1 class="h3 mb-1">បន្ថែមកាលវិភាគ / Add Schedule</h1>
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
      <form method="POST" action="{{ route('admin.schedules.store') }}">
        @csrf

        <div class="row g-3">
          <div class="col-12 col-md-6">
            <label class="form-label" for="class_id">ថ្នាក់ / Class</label>
            <select name="class_id" id="class_id" class="form-select" required>
              <option value="">-- Select --</option>
              @foreach ($classes as $class)
                <option value="{{ $class->class_id }}" {{ old('class_id') === $class->class_id ? 'selected' : '' }}>
                  {{ $class->class_name }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label" for="subject_id">មុខវិជ្ជា / Subject</label>
            <select name="subject_id" id="subject_id" class="form-select" required>
              <option value="">-- Select --</option>
              @foreach ($subjects as $subject)
                <option value="{{ $subject->subject_id }}" {{ old('subject_id') === $subject->subject_id ? 'selected' : '' }}>
                  {{ $subject->subject_name }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label" for="teacher_id">គ្រូ / Teacher</label>
            <select name="teacher_id" id="teacher_id" class="form-select" required>
              <option value="">-- Select --</option>
              @foreach ($teachers as $teacher)
                <option value="{{ $teacher->teacher_id }}" {{ old('teacher_id') === $teacher->teacher_id ? 'selected' : '' }}>
                  {{ $teacher->first_name }} {{ $teacher->last_name }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label" for="day_of_week">ថ្ងៃ / Day</label>
            <select name="day_of_week" id="day_of_week" class="form-select" required>
              <option value="">-- Select --</option>
              @foreach ($days as $day)
                <option value="{{ $day }}" {{ old('day_of_week') === $day ? 'selected' : '' }}>{{ $day }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label" for="start_time">ម៉ោងចាប់ផ្ដើម / Start Time</label>
            <input type="time" name="start_time" id="start_time" class="form-control" value="{{ old('start_time') }}" required>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label" for="end_time">ម៉ោងបញ្ចប់ / End Time</label>
            <input type="time" name="end_time" id="end_time" class="form-control" value="{{ old('end_time') }}" required>
          </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">
          <i class="bi bi-save" aria-hidden="true"></i> រក្សាទុក / Save
        </button>
        <a href="{{ route('admin.schedules.index') }}" class="btn btn-outline-secondary mt-3">បោះបង់ / Cancel</a>
      </form>
    </section>

  </div>
</main>

@include('admin.include.footer')
