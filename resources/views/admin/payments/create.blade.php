@include('admin.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-cash-coin" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">New</p>
          <h1 class="h3 mb-1">បន្ថែមការទូទាត់ / Add Payment</h1>
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
      <form method="POST" action="{{ route('admin.payments.store') }}">
        @csrf

        <div class="row g-3">
          <div class="col-12 col-md-6">
            <label class="form-label" for="student_id">សិស្ស / Student</label>
            <select name="student_id" id="student_id" class="form-select" required>
              <option value="">-- Select --</option>
              @foreach ($students as $student)
                <option value="{{ $student->student_id }}" {{ old('student_id') === $student->student_id ? 'selected' : '' }}>
                  {{ $student->first_name }} {{ $student->last_name }} ({{ $student->student_id }})
                </option>
              @endforeach
            </select>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label" for="description">ការពិពណ៌នា / Description</label>
            <input type="text" name="description" id="description" class="form-control" placeholder="e.g. Term 1 Tuition" value="{{ old('description') }}">
          </div>

          <div class="col-12 col-md-4">
            <label class="form-label" for="total_fee">តម្លៃសរុប / Total Fee</label>
            <input type="number" step="0.01" min="0" name="total_fee" id="total_fee" class="form-control" value="{{ old('total_fee') }}" required>
          </div>

          <div class="col-12 col-md-4">
            <label class="form-label" for="discount">បញ្ចុះតម្លៃ / Discount</label>
            <input type="number" step="0.01" min="0" name="discount" id="discount" class="form-control" value="{{ old('discount', 0) }}">
          </div>

          <div class="col-12 col-md-4">
            <label class="form-label" for="amount_paid">ចំនួនបានបង់ / Amount Paid</label>
            <input type="number" step="0.01" min="0" name="amount_paid" id="amount_paid" class="form-control" value="{{ old('amount_paid', 0) }}" required>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label" for="payment_date">កាលបរិច្ឆេទ / Payment Date</label>
            <input type="date" name="payment_date" id="payment_date" class="form-control" value="{{ old('payment_date', now()->toDateString()) }}" required>
          </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">
          <i class="bi bi-save" aria-hidden="true"></i> រក្សាទុក / Save
        </button>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary mt-3">បោះបង់ / Cancel</a>
      </form>
    </section>

  </div>
</main>

@include('admin.include.footer')
