@include('admin.include.header')

<main class="dashboard-content py-4">
  <div class="container-fluid px-3 px-lg-4">

    <!-- Page Header -->
    <div class="page-heading d-flex justify-content-between align-items-center mb-4">
      <div class="page-heading-copy d-flex align-items-center gap-3">
        <span class="page-icon bg-primary text-white p-3 rounded-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
          <i class="bi bi-journal-check fs-4" aria-hidden="true"></i>
        </span>
        <div>
          <p class="eyebrow text-uppercase text-muted fw-bold mb-0" style="font-size: 0.75rem; letter-spacing: 0.5px;">Results Overview</p>
          <h1 class="h3 mb-0 fw-bold">បញ្ជីលទ្ធផលប្រឡងសិស្ស (Exam Results)</h1>
          <p class="text-muted small mb-0">គ្រប់គ្រង និងពិនិត្យមើលលទ្ធផលប្រឡងសិស្សតាមថ្នាក់ និងមុខវិជ្ជា</p>
        </div>
      </div>
      <div class="heading-actions">
        <a href="{{ route('admin.exams.index') }}" class="btn btn-primary d-inline-flex align-items-center gap-2 px-3 py-2 fw-medium shadow-sm">
          <i class="bi bi-plus-lg" aria-hidden="true"></i> ទៅកាន់ការប្រឡងដើម្បីបញ្ចូលពិន្ទុ
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

    <!-- Filter Form Container -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
      <div class="card-body p-3 p-md-4">
        <form method="GET" action="{{ route('exam_results.index') }}" class="row g-3 align-items-end">
          
          <!-- Search Input -->
          <div class="col-12 col-md-4 col-lg-3">
            <label class="form-label text-muted fw-semibold small">ស្វែងរកសិស្ស / Search</label>
            <input type="text" name="search" value="{{ request('search') }}" class="form-control shadow-none" placeholder="ឈ្មោះ ឬ អត្តលេខសិស្ស...">
          </div>

          <!-- Class Filter -->
          <div class="col-12 col-md-4 col-lg-3">
            <label class="form-label text-muted fw-semibold small">ថ្នាក់រៀន / Class</label>
            <select name="class_id" class="form-select shadow-none">
              <option value="">-- គ្រប់ថ្នាក់ (All Classes) --</option>
              @foreach($classes as $class)
                <option value="{{ $class->class_id }}" {{ request('class_id') == $class->class_id ? 'selected' : '' }}>
                  {{ $class->class_name }}
                </option>
              @endforeach
            </select>
          </div>

          <!-- Subject Filter -->
          <div class="col-12 col-md-4 col-lg-3">
            <label class="form-label text-muted fw-semibold small">មុខវិជ្ជា / Subject</label>
            <select name="subject_id" class="form-select shadow-none">
              <option value="">-- គ្រប់មុខវិជ្ជា (All Subjects) --</option>
              @foreach($subjects as $subject)
                <option value="{{ $subject->subject_id }}" {{ request('subject_id') == $subject->subject_id ? 'selected' : '' }}>
                  {{ $subject->subject_name }}
                </option>
              @endforeach
            </select>
          </div>

          <!-- Filter & Reset Buttons -->
          <div class="col-12 col-lg-3 d-flex gap-2">
            <button type="submit" class="btn btn-primary d-inline-flex align-items-center justify-content-center gap-2 flex-grow-1 shadow-sm">
              <i class="bi bi-search"></i> ស្វែងរក
            </button>
            <a href="{{ route('exam_results.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center justify-content-center">
              Reset
            </a>
          </div>

        </form>
      </div>
    </div>

    <!-- Data Table Container -->
    <section class="card border-0 shadow-sm rounded-3 overflow-hidden">
      <div class="table-responsive">
        <table class="table align-middle mb-0 table-hover">
          <thead class="bg-body-tertiary border-bottom">
            <tr class="text-muted small text-uppercase fw-bold">
              <th class="py-3 px-3">ID សិស្ស</th>
              <th class="py-3 px-3">ឈ្មោះសិស្ស</th>
              <th class="py-3 px-3">មុខវិជ្ជា</th>
              <th class="py-3 px-3">ថ្នាក់</th>
              <th class="py-3 px-3 text-center">ពិន្ទុ</th>
              <th class="py-3 px-3 text-center">លទ្ធផល</th>
              <th class="py-3 px-3 text-center">កំណត់សម្គាល់</th>
              <th class="py-3 px-3 text-end">សកម្មភាព</th>
            </tr>
          </thead>
          <tbody class="border-top-0">
            @forelse($results as $result)
              @php
                $percentage = $result->max_score > 0 ? ($result->score / $result->max_score) * 100 : 0;
              @endphp
              <tr>
                <!-- ID សិស្ស -->
                <td class="px-3">
                  <span class="badge bg-secondary-subtle text-body border border-secondary-subtle fw-semibold px-2 py-1 rounded-2">
                    {{ $result->student_id }}
                  </span>
                </td>

                <!-- ឈ្មោះសិស្ស -->
                <td class="px-3">
                  <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 0.85rem;">
                      {{ mb_substr($result->student->first_name ?? 'S', 0, 1) }}
                    </div>
                    <span class="fw-bold">{{ $result->student->first_name ?? '' }} {{ $result->student->last_name ?? '' }}</span>
                  </div>
                </td>

                <!-- មុខវិជ្ជា -->
                <td class="px-3 fw-medium">
                  {{ $result->exam->subject->subject_name ?? '—' }}
                </td>

                <!-- ថ្នាក់ -->
                <td class="px-3">
                  <span class="badge bg-secondary-subtle text-body border border-secondary-subtle px-2 py-1 rounded-2 fw-semibold">
                    {{ $result->exam->schoolClass->class_name ?? '—' }}
                  </span>
                </td>

                <!-- ពិន្ទុ -->
                <td class="px-3 text-center fw-bold">
                  <span class="text-primary">{{ $result->score }}</span> / <span class="text-muted">{{ $result->max_score }}</span>
                </td>

                <!-- លទ្ធផល (ជាប់/ធ្លាក់) -->
                <td class="px-3 text-center">
                  @if($percentage >= 50)
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill fw-bold">ជាប់</span>
                  @else
                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1 rounded-pill fw-bold">ធ្លាក់</span>
                  @endif
                </td>

                <!-- កំណត់សម្គាល់ (Grade A-F) -->
                <td class="px-3 text-center">
                  <span class="badge rounded-circle d-inline-flex align-items-center justify-content-center fw-bold fs-6" style="width: 32px; height: 32px; background-color: rgba(108, 117, 125, 0.2); color: var(--bs-body-color);">
                    {{ $result->remarks ?? '-' }}
                  </span>
                </td>

                <!-- Action Buttons -->
                <td class="px-3 text-end">
                  <div class="d-inline-flex gap-1">
                    <a href="{{ route('admin.exams.scores.enter', $result->exam_id) }}" class="btn btn-sm btn-outline-primary border-0 shadow-none" title="កែប្រែ / Edit">
                      <i class="bi bi-pencil" aria-hidden="true"></i>
                    </a> 
                    <form action="{{ route('exam_results.destroy', $result->result_id) }}" method="POST" class="d-inline" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបពិន្ទុនេះមែនទេ?');">
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
                <td colspan="8" class="text-center text-muted py-5">
                  <i class="bi bi-folder-x fs-1 d-block opacity-50 mb-2"></i>
                  រកមិនឃើញទិន្នន័យពិន្ទុឡើយ (No exam results found.)
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Pagination Footer -->
      @if($results->hasPages())
        <div class="card-footer bg-body-tertiary border-top-0 py-3 px-3">
          {{ $results->links() }}
        </div>
      @endif
    </section>

  </div>
</main>

@include('admin.include.footer')
