@include('admin.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-pencil-square" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Edit</p>
          <h1 class="h3 mb-1">កែប្រែការទូទាត់ / Edit Payment</h1>
          <p class="text-muted mb-0">Invoice: {{ $payment->invoice_id }}</p>
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
      <form method="POST" action="{{ route('admin.payments.update', $payment->invoice_id) }}">
        @csrf
        @method('PUT')

        <div class="row g-3">
          <div class="col-12 col-md-6">
            <label class="form-label" for="student_id">សិស្ស / Student</label>
            <select name="student_id" id="student_id" class="form-select" required>
              @foreach ($students as $student)
                <option value="{{ $student->student_id }}" {{ $payment->student_id === $student->student_id ? 'selected' : '' }}>
                  {{ $student->first_name }} {{ $student->last_name }} ({{ $student->student_id }})
                </option>
              @endforeach
            </select>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label" for="description">ការពិពណ៌នា / Description</label>
            <input type="text" name="description" id="description" class="form-control" value="{{ $payment->description }}">
          </div>

          <div class="col-12 col-md-4">
            <label class="form-label" for="total_fee">តម្លៃសរុប / Total Fee</label>
            <input type="number" step="0.01" min="0" name="total_fee" id="total_fee" class="form-control" value="{{ $payment->total_fee }}" required>
          </div>

          <div class="col-12 col-md-4">
            <label class="form-label" for="discount">បញ្ចុះតម្លៃ / Discount</label>
            <input type="number" step="0.01" min="0" name="discount" id="discount" class="form-control" value="{{ $payment->discount }}">
          </div>

          <div class="col-12 col-md-4">
            <label class="form-label" for="amount_paid">ចំនួនបានបង់ / Amount Paid</label>
            <input type="number" step="0.01" min="0" name="amount_paid" id="amount_paid" class="form-control" value="{{ $payment->amount_paid }}" required>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label" for="payment_date">កាលបរិច្ឆេទ / Payment Date</label>
            <input type="date" name="payment_date" id="payment_date" class="form-control" value="{{ \Carbon\Carbon::parse($payment->payment_date)->toDateString() }}" required>
          </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">
          <i class="bi bi-save" aria-hidden="true"></i> ធ្វើបច្ចុប្បន្នភាព / Update
        </button>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary mt-3">បោះបង់ / Cancel</a>
      </form>
    </section>

  </div>
</main>

@include('admin.include.footer')
