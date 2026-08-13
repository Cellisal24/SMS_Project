@include('admin.include.header')

<main class="dashboard-content py-4">
  <div class="container-fluid px-3 px-lg-4">

    <!-- Page Header -->
    <div class="page-heading d-flex justify-content-between align-items-center mb-4">
      <div class="page-heading-copy d-flex align-items-center gap-3">
        <span class="page-icon bg-primary text-white p-3 rounded-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
          <i class="bi bi-file-earmark-text fs-4" aria-hidden="true"></i>
        </span>
        <div>
          <p class="eyebrow text-uppercase text-muted fw-bold mb-0" style="font-size: 0.75rem; letter-spacing: 0.5px;">Overview</p>
          <h1 class="h3 mb-0 fw-bold">ការប្រឡង / Exams</h1>
          <p class="text-muted small mb-0">គ្រប់គ្រងការប្រឡងតាមថ្នាក់ និងមុខវិជ្ជា / Manage exam schedules and settings.</p>
        </div>
      </div>
      <div class="heading-actions">
        <a href="{{ route('admin.exams.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2 px-3 py-2 fw-medium shadow-sm">
          <i class="bi bi-plus-lg" aria-hidden="true"></i> បង្កើតការប្រឡង / Add Exam
        </a>
      </div>
    </div>

    <!-- Alert Success -->
    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <!-- Filter Card Panel -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
      <div class="card-body p-3 p-md-4">
        <form method="GET" action="{{ route('admin.exams.index') }}" class="row g-3 align-items-end">
          
          <div class="col-12 col-md-3">
            <label class="form-label text-muted fw-semibold small">ស្វែងរក / Search</label>
            <input type="text" name="search" value="{{ request('search') }}" class="form-control shadow-none" placeholder="ឈ្មោះមុខវិជ្ជា...">
          </div>

          <div class="col-12 col-md-3">
            <label class="form-label text-muted fw-semibold small">ថ្នាក់ / Class</label>
            <select name="class_id" class="form-select shadow-none">
              <option value="">-- ថ្នាក់ទាំងអស់ (All classes) --</option>
              @foreach ($classes as $class)
                <option value="{{ $class->class_id }}" {{ request('class_id') === $class->class_id ? 'selected' : '' }}>
                  {{ $class->class_name }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="col-12 col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary d-inline-flex align-items-center justify-content-center gap-2 flex-grow-1">
              <i class="bi bi-funnel" aria-hidden="true"></i> ស្វែងរក (Filter)
            </button>
            <a href="{{ route('admin.exams.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center justify-content-center">
              Clear
            </a>
          </div>

        </form>
      </div>
    </div>

    <!-- Data Table Card Panel -->
    <section class="card border-0 shadow-sm rounded-3 overflow-hidden">
      <div class="table-responsive">
        <table class="table align-middle mb-0 table-hover">
          <!-- ប្តូរ bg-light មកប្រើ bg-body-tertiary ដើម្បីឱ្យអក្សរក្បាលតារាងភ្លឺច្បាស់ dynamic -->
          <thead class="bg-body-tertiary border-bottom">
            <tr class="text-muted small text-uppercase fw-bold">
              <th class="py-3 px-3">មុខវិជ្ជា / Subject</th>
              <th class="py-3 px-3">ថ្នាក់ / Class</th>
              <th class="py-3 px-3">កាលបរិច្ឆេទ / Date & Time</th>
              <th class="py-3 px-3">ពិន្ទុពេញ / Max Score</th>
              <th class="py-3 px-3">ឆមាស / Semester</th>
              <th class="py-3 px-3 text-center">បញ្ចូលពិន្ទុ / Enter Scores</th>
              <th class="py-3 px-3 text-end">សកម្មភាព / Action</th>
            </tr>
          </thead>
          <tbody class="border-top-0">
            @forelse ($exams as $exam)
              <tr>
                <!-- មុខវិជ្ជា -->
                <td class="px-3 fw-bold">
                  {{ $exam->subject->subject_name ?? '—' }}
                </td>

                <!-- ថ្នាក់ -->
                <td class="px-3">
                  <span class="badge bg-secondary-subtle text-body px-2 py-1 rounded-2 fw-semibold border border-secondary-subtle">
                    {{ $exam->schoolClass->class_name ?? '—' }}
                  </span>
                </td>

                <!-- កាលបរិច្ឆេទ & ម៉ោង -->
                <td class="px-3 fw-medium">
                  <div><i class="bi bi-calendar-event me-1 text-muted"></i> {{ \Carbon\Carbon::parse($exam->exam_date)->format('d-M-Y') }}</div>
                  @if($exam->start_time && $exam->end_time)
                    <small class="text-muted"><i class="bi bi-clock me-1"></i> {{ \Carbon\Carbon::parse($exam->start_time)->format('g:i A') }} – {{ \Carbon\Carbon::parse($exam->end_time)->format('g:i A') }}</small>
                  @endif
                </td>

                <!-- ពិន្ទុពេញ -->
                <td class="px-3">
                  <span class="fw-bold text-primary">{{ $exam->max_score ?? 100 }}</span>
                </td>

                <!-- ឆមាស -->
                <td class="px-3 text-muted">
                  {{ $exam->semester ?? '—' }}
                </td>

                <!-- បញ្ចូលពិន្ទុ Button -->
                <td class="px-3 text-center">
                  <a href="{{ route('admin.exams.scores.enter', $exam->exam_id) }}" class="btn btn-sm btn-outline-success d-inline-flex align-items-center gap-1 shadow-none">
                    <i class="bi bi-pencil-square"></i> បញ្ចូលពិន្ទុ
                  </a>
                </td>

                <!-- Action Buttons -->
                <td class="px-3 text-end">
                  <div class="d-inline-flex gap-1">
                    <a href="{{ route('admin.exams.edit', $exam->exam_id) }}" class="btn btn-sm btn-outline-primary border-0 shadow-none" title="កែប្រែ / Edit">
                      <i class="bi bi-pencil" aria-hidden="true"></i>
                    </a>
                    
                    <form method="POST" action="{{ route('admin.exams.destroy', $exam->exam_id) }}" class="d-inline" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបការប្រឡងនេះមែនទេ?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-outline-danger border-0 shadow-none" title="លុប / Delete">
                        <i class="bi bi-trash" aria-hidden="true"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center text-muted py-5">
                  <i class="bi bi-folder-x fs-1 d-block opacity-50 mb-2"></i>
                  មិនទាន់មានទិន្នន័យប្រឡងនៅឡើយទេ (No exam records found.)
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      @if($exams->hasPages())
        <div class="card-footer border-top-0 py-3 px-3">
          {{ $exams->links() }}
        </div>
      @endif
    </section>

  </div>
</main>

@include('admin.include.footer')
