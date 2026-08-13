@include('admin.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-pencil-square" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Edit</p>
          <h1 class="h3 mb-1">កែប្រែពិន្ទុ / Edit Grade</h1>
          <p class="text-muted mb-0">
            {{ $grade->student->first_name ?? '' }} {{ $grade->student->last_name ?? '' }}
            — {{ $grade->subject->subject_name ?? '' }} — {{ $grade->semester }}
          </p>
        </div>
      </div>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger mt-3">{{ $errors->first() }}</div>
    @endif

    <section class="panel mt-3">
      <form method="POST" action="{{ route('admin.grades.update', $grade->grade_id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
          <label class="form-label" for="midterm_score">ពិន្ទុពាក់កណ្ដាលឆមាស / Midterm Score</label>
          <input type="number" step="0.01" min="0" max="100" name="midterm_score" id="midterm_score" class="form-control" value="{{ $grade->midterm_score }}">
        </div>

        <div class="mb-3">
          <label class="form-label" for="final_score">ពិន្ទុចុងឆមាស / Final Score</label>
          <input type="number" step="0.01" min="0" max="100" name="final_score" id="final_score" class="form-control" value="{{ $grade->final_score }}">
        </div>

        <button type="submit" class="btn btn-primary">
          <i class="bi bi-save" aria-hidden="true"></i> ធ្វើបច្ចុប្បន្នភាព / Update
        </button>
        <a href="{{ route('admin.grades.index') }}" class="btn btn-outline-secondary">បោះបង់ / Cancel</a>
      </form>
    </section>

  </div>
</main>

@include('admin.include.footer')
