@include('teacher.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Overview</p>
          <h1 class="h3 mb-1">សិស្សរបស់ខ្ញុំ / My Students</h1>
          <p class="text-muted mb-0">Students across all classes you teach.</p>
        </div>
      </div>
    </div>

    <div class="panel mt-3">
      <form method="GET" action="{{ route('teacher.students.index') }}" class="row g-2 align-items-end">
        <div class="col-12 col-md-5">
          <label class="form-label small">ស្វែងរក / Search</label>
          <input type="text" name="search" class="form-control" placeholder="Name or student ID" value="{{ request('search') }}">
        </div>
        <div class="col-12 col-md-4">
          <label class="form-label small">ថ្នាក់ / Class</label>
          <select name="class_id" class="form-select">
            <option value="">-- All my classes --</option>
            @foreach ($classes as $class)
              <option value="{{ $class->class_id }}" {{ request('class_id') === $class->class_id ? 'selected' : '' }}>
                {{ $class->class_name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-12 col-md-3 d-flex gap-2">
          <button type="submit" class="btn btn-outline-secondary"><i class="bi bi-funnel" aria-hidden="true"></i> Filter</button>
          <a href="{{ route('teacher.students.index') }}" class="btn btn-outline-secondary">Clear</a>
        </div>
      </form>
    </div>

    <section class="panel mt-3">
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th>រូបថត / Photo</th>
              <th>សិស្ស / Student</th>
              <th>ថ្នាក់ / Class</th>
              <th>ភេទ / Gender</th>
              <th>លេខទំនាក់ទំនងឪពុកម្តាយ / Parent Phone</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($students as $student)
              <tr>
                <td>
                  @if ($student->photo)
                    <img src="{{ asset('storage/' . $student->photo) }}" alt="{{ $student->first_name }}" class="rounded-circle" style="width:36px;height:36px;object-fit:cover;">
                  @else
                    <span class="rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                      {{ strtoupper(substr($student->first_name, 0, 1)) }}
                    </span>
                  @endif
                </td>
                <td>
                  {{ $student->first_name }} {{ $student->last_name }}
                  <div class="text-muted small">{{ $student->student_id }}</div>
                </td>
                <td>{{ $student->schoolClass->class_name ?? '—' }}</td>
                <td>{{ $student->gender }}</td>
                <td>{{ $student->parent_phone ?? '—' }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted py-4">No students found in your assigned classes.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-3">
        {{ $students->links() }}
      </div>
    </section>

  </div>
</main>

@include('teacher.include.footer')
