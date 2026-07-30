@include('Student.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-gear" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Account</p>
          <h1 class="h3 mb-1">ការកំណត់គណនី / Account Settings</h1>
        </div>
      </div>
    </div>

    @if (session('success'))
      <div class="alert alert-success alert-dismissible mt-3">{{ session('success') }}</div>
    @endif

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
      <h2 class="h5 mb-3">ប្តូរពាក្យសម្ងាត់ / Change Password</h2>

      <form method="POST" action="{{ route('student.settings.password') }}">
        @csrf
        @method('PUT')

        <div class="row g-3">
          <div class="col-12 col-md-4">
            <label class="form-label" for="current_password">ពាក្យសម្ងាត់បច្ចុប្បន្ន / Current Password</label>
            <input type="password" name="current_password" id="current_password" class="form-control" required>
          </div>
          <div class="col-12 col-md-4">
            <label class="form-label" for="password">ពាក្យសម្ងាត់ថ្មី / New Password</label>
            <input type="password" name="password" id="password" class="form-control" required minlength="8">
          </div>
          <div class="col-12 col-md-4">
            <label class="form-label" for="password_confirmation">បញ្ជាក់ពាក្យសម្ងាត់ / Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required minlength="8">
          </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">
          <i class="bi bi-save" aria-hidden="true"></i> រក្សាទុក / Save
        </button>
      </form>
    </section>

  </div>
</main>

@include('Student.include.footer')