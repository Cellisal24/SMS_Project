@include('Admin.include.header')

<main class="dashboard-content py-4">
  <div class="container-fluid px-3 px-lg-4">

    <!-- Page Header Panel -->
    <div class="page-heading d-flex justify-content-between align-items-center mb-4">
      <div class="page-heading-copy d-flex align-items-center gap-3">
        <span class="page-icon bg-success text-white p-3 rounded-3 shadow-sm d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
          <i class="bi bi-pencil-square fs-4" aria-hidden="true"></i>
        </span>
        <div>
          <p class="eyebrow text-uppercase text-muted fw-bold mb-0" style="font-size: 0.75rem; letter-spacing: 0.5px;">Enter Scores</p>
          <h1 class="h3 mb-0 fw-bold text-body">បញ្ចូលពិន្ទុប្រឡង / Enter Exam Scores</h1>
          <p class="text-muted small mb-0">
            មុខវិជ្ជា: <strong class="text-body">{{ $exam->subject->subject_name ?? '—' }}</strong> | 
            ថ្នាក់: <strong class="text-body">{{ $exam->schoolClass->class_name ?? '—' }}</strong> | 
            ពិន្ទុពេញ: <span class="badge bg-primary px-2 py-1">{{ $exam->max_score ?? 100 }}</span>
          </p>
        </div>
      </div>
      <div class="heading-actions">
        <a href="{{ route('admin.exams.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2 px-3 py-2 fw-medium shadow-sm">
          <i class="bi bi-arrow-left" aria-hidden="true"></i> ត្រឡប់ក្រោយ / Back
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

    <!-- Form Container -->
    <form action="{{ route('admin.exams.scores.store', $exam->exam_id) }}" method="POST">
      @csrf

      <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
        <div class="table-responsive">
          <table class="table align-middle mb-0 table-hover">
            
            <!-- Dynamic Table Header -->
            <thead class="bg-body-tertiary border-bottom">
              <tr class="text-muted small text-uppercase fw-bold">
                <th class="py-3 px-3" style="width: 140px;">អត្តលេខ / ID</th>
                <th class="py-3 px-3">ឈ្មោះសិស្ស / Student Name</th>
                <th class="py-3 px-3" style="width: 200px;">ពិន្ទុទទួលបាន / Score</th>
                <th class="py-3 px-3 text-center" style="width: 130px;">ពិន្ទុអតិបរមា</th>
                <th class="py-3 px-3 text-center" style="width: 180px;">កំណត់សម្គាល់ (AUTO GRADE)</th>
              </tr>
            </thead>

            <tbody class="border-top-0">
              @php
                $examMaxScore = $exam->max_score ?? 100;
              @endphp

              @forelse($students as $student)
                @php
                  $result = $existingResults[$student->student_id] ?? null;
                  $currentScore = old('scores.'.$student->student_id, $result->score ?? '');
                  $currentRemark = $result->remarks ?? '-';
                @endphp
                <tr>
                  <!-- ID -->
                  <td class="px-3">
                    <span class="badge bg-secondary-subtle text-body border border-secondary-subtle fw-semibold px-2 py-1 rounded-2">
                      {{ $student->student_id }}
                    </span>
                  </td>

                  <!-- Student Name (កែសម្រួលឱ្យភ្លឺច្បាស់ dynamic) -->
                  <td class="px-3">
                    <div class="d-flex align-items-center gap-2">
                      <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 0.85rem;">
                        {{ mb_substr($student->first_name ?? 'S', 0, 1) }}
                      </div>
                      <span class="fw-bold text-body">{{ $student->first_name }} {{ $student->last_name }}</span>
                    </div>
                  </td>

                  <!-- Input ពិន្ទុ -->
                  <td class="px-3">
                    <input type="number" 
                           step="0.01" 
                           min="0"
                           max="{{ $examMaxScore }}"
                           name="scores[{{ $student->student_id }}]" 
                           value="{{ $currentScore }}" 
                           oninput="updateAutoRemark(this, {{ $examMaxScore }})"
                           class="form-control shadow-none fw-semibold text-body" 
                           placeholder="0 - {{ $examMaxScore }}">
                  </td>

                  <!-- Max Score -->
                  <td class="px-3 text-center fw-bold text-body opacity-75">
                    {{ $examMaxScore }}
                  </td>

                  <!-- Auto Grade -->
                  <td class="px-3 text-center remark-cell">
                    <span class="badge rounded-circle d-inline-flex align-items-center justify-content-center fw-bold fs-6 grade-badge" style="width: 36px; height: 36px; background-color: rgba(108, 117, 125, 0.2); color: var(--bs-body-color);">
                      {{ $currentRemark != '-' ? $currentRemark : '-' }}
                    </span>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" class="text-center text-muted py-5">
                    <i class="bi bi-people fs-1 d-block opacity-50 mb-2"></i>
                    មិនមានទិន្នន័យសិស្សនៅក្នុងថ្នាក់នេះទេ (No students found.)
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        @if(count($students) > 0)
          <!-- Card Footer support Theme -->
          <div class="card-footer bg-body-tertiary border-top-0 p-3 d-flex justify-content-between align-items-center">
            <span class="text-muted small">សិស្សសរុប: <strong class="text-body">{{ count($students) }}</strong> នាក់</span>
            <div class="d-flex gap-2">
              <a href="{{ route('admin.exams.index') }}" class="btn btn-dark px-4">បោះបង់ / Cancel</a>
              <button type="submit" class="btn btn-success d-inline-flex align-items-center gap-2 px-4 shadow-sm fw-medium">
                <i class="bi bi-check-lg"></i> រក្សាទុកពិន្ទុ / Save Scores
              </button>
            </div>
          </div>
        @endif
      </div>
    </form>

  </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('input[name^="scores"]').forEach(function(input) {
        if(input.value !== '') {
            let maxScore = parseFloat(input.getAttribute('max')) || 100;
            updateAutoRemark(input, maxScore);
        }
    });
});

function updateAutoRemark(input, maxScore) {
    let score = parseFloat(input.value);
    let row = input.closest('tr');
    let badge = row.querySelector('.grade-badge');

    if (isNaN(score) || input.value === '') {
        badge.innerText = '-';
        badge.style.backgroundColor = 'rgba(108, 117, 125, 0.2)';
        badge.style.color = 'var(--bs-body-color)';
        return;
    }

    let marks = (score / maxScore) * 100;
    let grade = '';
    let bgColor = '';
    let textColor = '#ffffff';

    if (marks >= 90) {
        grade = 'A'; bgColor = '#198754';
    } else if (marks >= 80) {
        grade = 'B'; bgColor = '#0d6efd';
    } else if (marks >= 70) {
        grade = 'C'; bgColor = '#0dcaf0'; textColor = '#000000';
    } else if (marks >= 60) {
        grade = 'D'; bgColor = '#ffc107'; textColor = '#000000';
    } else if (marks >= 50) {
        grade = 'E'; bgColor = '#fd7e14';
    } else {
        grade = 'F'; bgColor = '#dc3545';
    }

    badge.innerText = grade;
    badge.style.backgroundColor = bgColor;
    badge.style.color = textColor;
}
</script>

@include('Admin.include.footer')