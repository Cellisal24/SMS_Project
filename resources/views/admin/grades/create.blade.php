@include('admin.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-journal-plus" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">New</p>
          <h1 class="h3 mb-1">បញ្ចូលពិន្ទុ / Enter Grades</h1>
          <p class="text-muted mb-0">Choose a class, subject, and semester to load the roster.</p>
        </div>
      </div>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger mt-3">{{ $errors->first() }}</div>
    @endif

    <section class="panel mt-3">
      <div class="row g-3 align-items-end">
        <div class="col-12 col-md-4">
          <label class="form-label small" for="class_id">ថ្នាក់ / Class</label>
          <select id="class_id" class="form-select">
            <option value="">-- Select --</option>
            @foreach ($classes as $class)
              <option value="{{ $class->class_id }}">{{ $class->class_name }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-12 col-md-4">
          <label class="form-label small" for="subject_id">មុខវិជ្ជា / Subject</label>
          <select id="subject_id" class="form-select">
            <option value="">-- Select --</option>
            @foreach ($subjects as $subject)
              <option value="{{ $subject->subject_id }}">{{ $subject->subject_name }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-12 col-md-3">
          <label class="form-label small" for="semester">ឆមាស / Semester</label>
          <input list="semesterOptions" id="semester" class="form-control" placeholder="e.g. Semester 1">
          <datalist id="semesterOptions">
            <option value="Semester 1">
            <option value="Semester 2">
          </datalist>
        </div>

        <div class="col-12 col-md-1">
          <button type="button" id="loadGradeRosterBtn" class="btn btn-outline-primary w-100">
            <i class="bi bi-arrow-repeat" aria-hidden="true"></i>
          </button>
        </div>
      </div>
    </section>

    <section class="panel mt-3" id="gradeRosterPanel" style="display:none;">
      <form method="POST" action="{{ route('admin.grades.store') }}" id="gradeForm">
        @csrf
        <input type="hidden" name="class_id" id="form_class_id">
        <input type="hidden" name="subject_id" id="form_subject_id">
        <input type="hidden" name="semester" id="form_semester">

        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead>
              <tr>
                <th>សិស្ស / Student</th>
                <th>ពិន្ទុពាក់កណ្ដាលឆមាស / Midterm</th>
                <th>ពិន្ទុចុងឆមាស / Final</th>
              </tr>
            </thead>
            <tbody id="gradeRosterBody"></tbody>
          </table>
        </div>

        <button type="submit" class="btn btn-primary mt-3">
          <i class="bi bi-save" aria-hidden="true"></i> រក្សាទុកពិន្ទុ / Save Grades
        </button>
      </form>
    </section>

    <p class="text-muted mt-3" id="emptyGradeMsg">Select a class, subject, and semester, then click load.</p>

  </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const loadBtn = document.getElementById('loadGradeRosterBtn');
  const panel = document.getElementById('gradeRosterPanel');
  const body = document.getElementById('gradeRosterBody');
  const emptyMsg = document.getElementById('emptyGradeMsg');

  loadBtn.addEventListener('click', function () {
    const classId = document.getElementById('class_id').value;
    const subjectId = document.getElementById('subject_id').value;
    const semester = document.getElementById('semester').value.trim();

    if (!classId || !subjectId || !semester) {
      alert('Please select class, subject, and semester first.');
      return;
    }

    fetch(`{{ route('admin.grades.roster') }}?class_id=${classId}&subject_id=${subjectId}&semester=${encodeURIComponent(semester)}`)
      .then(res => res.json())
      .then(data => {
        document.getElementById('form_class_id').value = classId;
        document.getElementById('form_subject_id').value = subjectId;
        document.getElementById('form_semester').value = semester;

        body.innerHTML = '';

        if (data.students.length === 0) {
          emptyMsg.textContent = 'No students found for this class.';
          emptyMsg.style.display = 'block';
          panel.style.display = 'none';
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
              <input type="number" step="0.01" min="0" max="100" name="students[${index}][midterm_score]" class="form-control form-control-sm" value="${student.midterm_score}">
            </td>
            <td>
              <input type="number" step="0.01" min="0" max="100" name="students[${index}][final_score]" class="form-control form-control-sm" value="${student.final_score}">
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

@include('admin.include.footer')
