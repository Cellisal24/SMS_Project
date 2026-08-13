@if (session('reset_credentials'))
  @php $cred = session('reset_credentials'); @endphp
  <div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="bi bi-key" aria-hidden="true"></i> Password Reset</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p class="mb-2">New login for <strong>{{ $cred['name'] }}</strong>. Copy this now — it won't be shown again.</p>

          <label class="form-label small text-muted">Username</label>
          <div class="input-group mb-3">
            <input type="text" class="form-control" id="credUsername" value="{{ $cred['username'] }}" readonly>
            <button class="btn btn-outline-secondary copy-btn" type="button" data-target="credUsername">
              <i class="bi bi-clipboard" aria-hidden="true"></i>
            </button>
          </div>

          <label class="form-label small text-muted">Password</label>
          <div class="input-group">
            <input type="text" class="form-control" id="credPassword" value="{{ $cred['password'] }}" readonly>
            <button class="btn btn-outline-secondary copy-btn" type="button" data-target="credPassword">
              <i class="bi bi-clipboard" aria-hidden="true"></i>
            </button>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Done</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const modal = new bootstrap.Modal(document.getElementById('resetPasswordModal'));
      modal.show();

      document.querySelectorAll('.copy-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
          const input = document.getElementById(btn.dataset.target);
          navigator.clipboard.writeText(input.value).then(function () {
            const icon = btn.querySelector('i');
            icon.classList.remove('bi-clipboard');
            icon.classList.add('bi-clipboard-check', 'text-success');
            setTimeout(function () {
              icon.classList.remove('bi-clipboard-check', 'text-success');
              icon.classList.add('bi-clipboard');
            }, 1500);
          });
        });
      });
    });
  </script>
@endif
@include('admin.include.header')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Teacher List</h3>
        <a href="{{ route('teachers.create') }}" class="btn btn-primary">+ Add New Teacher</a>
    </div>

    {{-- Alert Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Search & Filter Section --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form method="GET" action="{{ route('teachers.index') }}" class="row g-2">
                {{-- Search Input --}}
                <div class="col-md-5">
                    <input type="text" name="search" class="form-control" placeholder="Search by teacher ID, name, email, or contact..." value="{{ request('search') }}">
                </div>

                {{-- Gender Filter --}}
                <div class="col-md-3">
                    <select name="gender" class="form-select">
                        <option value="">-- Filter by Gender --</option>
                        <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ request('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-secondary w-100">Search</button>
                    <a href="{{ route('teachers.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Teacher Table --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0 align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Teacher ID</th>
                            <th>Photo</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Gender</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($teachers as $teacher)
                            <tr>
                                <td><strong>{{ $teacher->teacher_id }}</strong></td>
                                 <td>
                                    @if ($teacher->photo)
                                        <img src="{{ asset('storage/' . $teacher->photo) }}" alt="{{ $teacher->first_name }}" class="rounded-circle" style="width:36px;height:36px;object-fit:cover;">
                                    @else
                                        <span class="avatar-placeholder rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                                        {{ strtoupper(substr($teacher->first_name, 0, 1)) }}
                                        </span>
                                    @endif
                                    {{ $teacher->first_name }} {{ $teacher->last_name }}
                                    </td>
                                <td>{{ $teacher->first_name }}</td>
                                <td>{{ $teacher->last_name }}</td>
                                <td>
                                    <span class="badge {{ $teacher->gender == 'Male' ? 'bg-info' : ($teacher->gender == 'Female' ? 'bg-danger' : 'bg-secondary') }}">
                                        {{ $teacher->gender }}
                                    </span>
                                </td>
                                <td>{{ $teacher->email }}</td>
                                <td>{{ $teacher->contact_number ?? 'N/A' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('teachers.edit', $teacher->teacher_id) }}" class="btn btn-sm btn-warning me-1">Edit</a>
                                    
                                    <form action="{{ route('teachers.destroy', $teacher->teacher_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this teacher?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                    <form method="POST" action="{{ route('teachers.reset-password', $teacher->teacher_id) }}" class="d-inline" onsubmit="return confirm('Generate a new password for {{ $teacher->first_name }} {{ $teacher->last_name }}?');">
                                    @csrf
                                    <button type="submit" class="btn btn-light btn-sm text-warning" title="Reset password">
                                        <i class="bi bi-key" aria-hidden="true"></i>
                                    </button>
                                </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No teachers found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination Links --}}
    <div class="d-flex justify-content-end mt-3">
        {{ $teachers->links() }}
    </div>
</div>
@include('admin.include.footer')
