@include('teacher.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-file-earmark-plus" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">New</p>
          <h1 class="h3 mb-1">បញ្ចូលពិន្ទុ / Enter Exam Results</h1>
          <p class="text-muted mb-0">Choose one of your exams to load its student roster.</p>
        </div>
      </div>
      <div class="heading-actions">
        <a href="{{ route('teacher.exam-results.index') }}" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left" aria-hidden="true"></i> ត្រឡប់ក្រោយ / Back
        </a>
      </div>
    </div>

    @if (session('success'))
      <div class="alert alert-success alert-dismissible mt-3">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger mt-3">{{ $errors->first() }}</div>
    @endif

    <section class="panel mt-3">
      <div class="row g-3 align-items-end">
        <div class="col-12 col-md-10">
          <label class="form-label small" for="exam_id">ការប្រឡង / Exam</label>
          <select id="exam_id" class="form-select">
            <option value="">-- Select an exam --</option>
            @foreach ($exams as $exam)
              <option value="{{ $exam->exam_id }}">
                {{ $exam->subject->subject_name ?? '' }} — {{ $exam->schoolClass->class_name ?? '' }} — {{ \Carbon\Carbon::parse($exam->exam_date)->format('M j, Y') }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-12 col-md-2">
          <button type="button" id="loadResultRosterBtn" class="btn btn-outline-primary w-100">
            <i class="bi bi-arrow-repeat" aria-hidden="true"></i> Load
          </button>
        </div>
      </div>
    </section>

    <section class="panel mt-3" id="resultRosterPanel" style="display:none;">
      <form method="POST" action="{{ route('teacher.exam-results.store') }}" id="resultForm">
        @csrf
        <input type="hidden" name="exam_id" id="form_exam_id">

        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead>
              <tr>
                <th>អត្តលេខ / ID</th>
                <th>ឈ្មោះសិស្ស / Student Name</th>
                <th>ពិន្ទុទទួលបាន / Score</th>
                <th>ពិន្ទុអតិបរមា / Max Score</th>
                <th>ចំណាំ / Remarks</th>
              </tr>
            </thead>
            <tbody id="resultRosterBody"></tbody>
          </table>
        </div>

        <button type="submit" class="btn btn-primary mt-3">
          <i class="bi bi-save" aria-hidden="true"></i> រក្សាទុកលទ្ធផល / Save Results
        </button>
      </form>
    </section>

    <p class="text-muted mt-3" id="emptyResultMsg">Select an exam, then click "Load."</p>

  </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const loadBtn = document.getElementById('loadResultRosterBtn');
  const panel = document.getElementById('resultRosterPanel');
  const body = document.getElementById('resultRosterBody');
  const emptyMsg = document.getElementById('emptyResultMsg');

  loadBtn.addEventListener('click', function () {
    const examId = document.getElementById('exam_id').value;

    if (!examId) {
      alert('Please select an exam first.');
      return;
    }

    fetch(`{{ route('teacher.exam-results.roster') }}?exam_id=${examId}`)
      .then(res => res.json())
      .then(data => {
        document.getElementById('form_exam_id').value = examId;

        body.innerHTML = '';

        if (data.students.length === 0) {
          emptyMsg.textContent = 'No students found for this exam\'s class.';
          emptyMsg.style.display = 'block';
          panel.style.display = 'none';
          return;
        }

        data.students.forEach((student, index) => {
          const row = document.createElement('tr');
          row.innerHTML = `
            <td>
              ${student.student_id}
              <input type="hidden" name="students[${index}][student_id]" value="${student.student_id}">
            </td>
            <td>${student.name}</td>
            <td>
              <input type="number" step="0.01" min="0" name="students[${index}][score]" class="form-control form-control-sm" value="${student.score}" required>
            </td>
            <td>
              <input type="number" step="0.01" min="1" name="students[${index}][max_score]" class="form-control form-control-sm" value="${student.max_score}" required>
            </td>
            <td>
              <input type="text" name="students[${index}][remarks]" class="form-control form-control-sm" value="${student.remarks}">
            </td>
          `;
          body.appendChild(row);
        });

        panel.style.display = 'block';
        emptyMsg.style.display = 'none';
      })
      .catch(() => alert('Could not load the roster. Please try again.'));
  });
});
</script>

@include('teacher.include.footer')
