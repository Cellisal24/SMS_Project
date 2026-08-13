@include('Admin.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">

    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-person-circle" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Account</p>
          <h1 class="h3 mb-1">ប្រវត្តិរូប / Profile</h1>
        </div>
      </div>
      <div class="heading-actions">
        <a href="{{ route('admin.settings.edit') }}" class="btn btn-outline-secondary btn-sm">
          <i class="bi bi-gear" aria-hidden="true"></i> Account Settings
        </a>
      </div>
    </div>

    <section class="panel mt-3">
      <div class="row g-3">
        <div class="col-12 col-md-6">
          <div class="text-muted small">ឈ្មោះអ្នកប្រើ / Username</div>
          <div class="fw-semibold">{{ $user->username }}</div>
        </div>
        <div class="col-12 col-md-6">
          <div class="text-muted small">តួនាទី / Role</div>
          <div class="fw-semibold">{{ ucfirst($user->role) }}</div>
        </div>
        <div class="col-12 col-md-6">
          <div class="text-muted small">សមាជិកតាំងពី / Member Since</div>
          <div class="fw-semibold">{{ $user->created_at->format('M j, Y') }}</div>
        </div>

        @if ($linked)
          <div class="col-12 col-md-6">
            <div class="text-muted small">ភ្ជាប់ជាមួយ / Linked Record</div>
            <div class="fw-semibold">{{ $linked->first_name }} {{ $linked->last_name }}</div>
          </div>
        @endif
      </div>
    </section>

  </div>
</main>

@include('Admin.include.footer')