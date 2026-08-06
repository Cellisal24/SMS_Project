@include('Parent.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-cash-coin" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Overview</p>
          <h1 class="h3 mb-1">ការទូទាត់ / Payments</h1>
          <p class="text-muted mb-0">Fees across all your children.</p>
        </div>
      </div>
    </div>

    <div class="panel mt-3">
      <form method="GET" action="{{ route('parent.payments.index') }}" class="row g-2 align-items-end">
        <div class="col-12 col-md-5">
          <label class="form-label small">កូន / Child</label>
          <select name="student_id" class="form-select">
            <option value="">-- All children --</option>
            @foreach ($myChildren as $child)
              <option value="{{ $child->student_id }}" {{ request('student_id') === $child->student_id ? 'selected' : '' }}>
                {{ $child->first_name }} {{ $child->last_name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-12 col-md-3 d-flex gap-2">
          <button type="submit" class="btn btn-outline-secondary"><i class="bi bi-funnel" aria-hidden="true"></i> Filter</button>
          <a href="{{ route('parent.payments.index') }}" class="btn btn-outline-secondary">Clear</a>
        </div>
      </form>
    </div>

    <section class="panel mt-3">
      <div class="table-responsive">
        <table class="table align-middle mb-0">
          <thead>
            <tr>
              <th>កូន / Child</th>
              <th>ការពិពណ៌នា / Description</th>
              <th>សរុប / Total</th>
              <th>បានបង់ / Paid</th>
              <th>ស្ថានភាព / Status</th>
              <th>កាលបរិច្ឆេទ / Date</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($payments as $payment)
              @php $balance = $payment->total_fee - ($payment->discount ?? 0) - $payment->amount_paid; @endphp
              <tr>
                <td>{{ $payment->student->first_name ?? '' }} {{ $payment->student->last_name ?? '' }}</td>
                <td>{{ $payment->description ?? '—' }}</td>
                <td>${{ number_format($payment->total_fee, 2) }}</td>
                <td>${{ number_format($payment->amount_paid, 2) }}</td>
                <td>
                  @if ($balance > 0)
                    <span class="badge text-bg-danger">${{ number_format($balance, 2) }} due</span>
                  @else
                    <span class="badge text-bg-success">Paid</span>
                  @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('M j, Y') }}</td>
              </tr>
            @empty
              <tr><td colspan="6" class="text-center text-muted py-4">No payment records found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="mt-3">{{ $payments->links() }}</div>
    </section>

  </div>
</main>

@include('Parent.include.footer')