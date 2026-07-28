@include('Admin.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-cash-coin" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Overview</p>
          <h1 class="h3 mb-1">ការទូទាត់ / Payments</h1>
          <p class="text-muted mb-0">Track student fees and payment status.</p>
        </div>
      </div>
      <div class="heading-actions">
        <a href="{{ route('admin.payments.create') }}" class="btn btn-primary btn-sm">
          <i class="bi bi-plus-lg" aria-hidden="true"></i> បន្ថែមការទូទាត់ / Add Payment
        </a>
      </div>
    </div>

    @if (session('success'))
      <div class="alert alert-success alert-dismissible mt-3">{{ session('success') }}</div>
    @endif

    <div class="panel mt-3">
      <form method="GET" action="{{ route('admin.payments.index') }}" class="row g-2 align-items-end">
        <div class="col-12 col-md-5">
          <label class="form-label small">ស្វែងរក / Search</label>
          <input type="text" name="search" class="form-control" placeholder="Invoice, student ID, description" value="{{ request('search') }}">
        </div>
        <div class="col-12 col-md-4">
          <label class="form-label small">ស្ថានភាព / Status</label>
          <select name="status" class="form-select">
            <option value="">-- All --</option>
            <option value="outstanding" {{ request('status') === 'outstanding' ? 'selected' : '' }}>Outstanding</option>
            <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Fully Paid</option>
          </select>
        </div>
        <div class="col-12 col-md-3 d-flex gap-2">
          <button type="submit" class="btn btn-outline-secondary"><i class="bi bi-funnel" aria-hidden="true"></i> Filter</button>
          <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary">Clear</a>
        </div>
      </form>
    </div>

    <section class="panel mt-3">
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th>វិក័យប័ត្រ / Invoice</th>
              <th>សិស្ស / Student</th>
              <th>ការពិពណ៌នា / Description</th>
              <th>តម្លៃសរុប / Total</th>
              <th>បញ្ចុះតម្លៃ / Discount</th>
              <th>បានបង់ / Paid</th>
              <th>នៅសល់ / Balance</th>
              <th>កាលបរិច្ឆេទ / Date</th>
              <th class="text-end">សកម្មភាព / Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($payments as $payment)
              @php $balance = $payment->total_fee - ($payment->discount ?? 0) - $payment->amount_paid; @endphp
              <tr>
                <td>{{ $payment->invoice_id }}</td>
                <td>
                  {{ $payment->student->first_name ?? '' }} {{ $payment->student->last_name ?? '' }}
                  <div class="text-muted small">{{ $payment->student_id }}</div>
                </td>
                <td>{{ $payment->description ?? '—' }}</td>
                <td>${{ number_format($payment->total_fee, 2) }}</td>
                <td>${{ number_format($payment->discount ?? 0, 2) }}</td>
                <td>${{ number_format($payment->amount_paid, 2) }}</td>
                <td>
                  @if ($balance > 0)
                    <span class="badge text-bg-danger">${{ number_format($balance, 2) }}</span>
                  @else
                    <span class="badge text-bg-success">Paid</span>
                  @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('M j, Y') }}</td>
                <td class="text-end">
                  <a href="{{ route('admin.payments.edit', $payment->invoice_id) }}" class="btn btn-light btn-sm">
                    <i class="bi bi-pencil" aria-hidden="true"></i>
                  </a>
                  <form method="POST" action="{{ route('admin.payments.destroy', $payment->invoice_id) }}" class="d-inline" onsubmit="return confirm('Delete this payment record?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-light btn-sm text-danger">
                      <i class="bi bi-trash" aria-hidden="true"></i>
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="9" class="text-center text-muted py-4">No payment records found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-3">
        {{ $payments->links() }}
      </div>
    </section>

  </div>
</main>

@include('Admin.include.footer')