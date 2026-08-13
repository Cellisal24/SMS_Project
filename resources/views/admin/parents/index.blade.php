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

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-person-heart" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Management</p>
          <h1 class="h3 mb-1">Parents</h1>
          <p class="text-muted mb-0">Review and manage parent / guardian records.</p>
        </div>
      </div>
      <div class="heading-actions">
        <a class="btn btn-outline-secondary btn-sm" href="#"><i class="bi bi-download" aria-hidden="true"></i> Export</a>
        <a class="btn btn-primary btn-sm" href="{{ route('admin.parents.create') }}"><i class="bi bi-plus-lg" aria-hidden="true"></i> Add Parent</a>
      </div>
    </div>

    @if (session('success') || session('error') || session('warning'))
      <div class="mt-3">
        @if (session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if (session('error'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if (session('warning'))
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
      </div>
    @endif

    <section class="row g-3 mt-1" aria-label="Parents summary">
      <div class="col-12 col-sm-6 col-xl-3">
        <article class="metric-card metric-primary">
          <div class="metric-top">
            <span class="metric-label">Total Parents</span>
            <span class="metric-icon"><i class="bi bi-person-heart" aria-hidden="true"></i></span>
          </div>
          <div class="metric-value">{{ $parents->total() }}</div>
          <div class="metric-meta">
            <span class="text-success"><i class="bi bi-arrow-up-right"></i> Registered</span>
            <span>guardians</span>
          </div>
        </article>
      </div>
    </section>

    <section class="panel mt-3">
      <div class="panel-header flex-column flex-md-row gap-3">
        <div>
          <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i><span>Parents List</span></h2>
          <p class="text-muted mb-0">Search, review, and manage parents.</p>
        </div>

        <div class="d-flex flex-grow-1 justify-content-end w-100">
          <form class="d-flex flex-wrap gap-2 w-100 justify-content-md-end" method="GET" action="{{ route('admin.parents.index') }}">
            <div style="min-width: 240px;">
              <input
                name="search"
                class="form-control form-control-sm"
                type="search"
                value="{{ request('search') }}"
                placeholder="ស្វែងរកឈ្មោះ លេខទូរស័ព្ទ ឬអ៊ីមែល..."
                aria-label="Search parents"
              >
            </div>
            <button type="submit" class="btn btn-secondary btn-sm px-3">Apply</button>

            @if(request()->filled('search'))
              <a class="btn btn-link btn-sm text-decoration-none" href="{{ route('admin.parents.index') }}">Reset</a>
            @endif
          </form>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table align-middle mb-0" id="parentsTable">
          <thead>
            <tr>
              <th scope="col" class="ps-3" style="width: 140px;">លេខសម្គាល់ (Parent ID)</th>
              <th scope="col">រូបថត (Photo)</th>
              <th scope="col">ឈ្មោះ (Name)</th>
              <th scope="col">លេខទូរស័ព្ទ (Phone)</th>
              <th scope="col">អ៊ីមែល (Email)</th>
              <th scope="col">កូន (Children)</th>
              <th scope="col" class="text-end pe-3">សកម្មភាព (Action)</th>
            </tr>
          </thead>
          <tbody>
            @forelse($parents as $parent)
              <tr>
                <td class="ps-3 fw-bold text-secondary">
                  {{ $parent->parent_id }}
                </td>
                <td>
                  @if ($parent->photo)
                    <img src="{{ asset('storage/' . $parent->photo) }}" alt="{{ $parent->first_name }}" class="rounded-circle" style="width:36px;height:36px;object-fit:cover;">
                  @else
                    <span class="avatar-placeholder rounded-circle bg-secondary text-white d-inline-flex align-items-center justify-content-center" style="width:36px;height:36px;">
                      {{ strtoupper(substr($parent->first_name, 0, 1)) }}
                    </span>
                  @endif
                  {{ $parent->first_name }} {{ $parent->last_name }}
                </td>

                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary-subtle text-primary rounded px-2 py-1 small">
                      <i class="bi bi-person-heart"></i>
                    </div>
                    <span class="fw-semibold text-dark">{{ $parent->fullName() }}</span>
                  </div>
                </td>

                <td>{{ $parent->phone ?? '—' }}</td>
                <td>{{ $parent->email ?? '—' }}</td>

                <td>
                  <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle px-2 py-1">
                    {{ $parent->students_count }}
                  </span>
                </td>

                <td class="text-end pe-3">
                  <div class="d-flex justify-content-end gap-1">
                    <a class="btn btn-light btn-sm text-primary border" href="{{ route('admin.parents.edit', $parent->parent_id) }}">
                      <i class="bi bi-pencil-square"></i> កែប្រែ
                    </a>

                    <form action="{{ route('admin.parents.destroy', $parent->parent_id) }}" method="POST"
                          onsubmit="return confirm('តើអ្នកពិតជាចង់លុបឪពុកម្តាយនេះមែនទេ?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-light btn-sm text-danger border">
                        <i class="bi bi-trash"></i> លុប
                      </button>
                    </form>
                    <form method="POST" action="{{ route('admin.parents.reset-password', $parent->parent_id) }}" class="d-inline" onsubmit="return confirm('Generate a new password for {{ $parent->fullName() }}?');">
                        @csrf
                        <button type="submit" class="btn btn-light btn-sm text-warning" title="Reset password">
                            <i class="bi bi-key" aria-hidden="true"></i>
                        </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center py-4 text-muted italic">
                  <i class="bi bi-folder-x me-1"></i> មិនមានទិន្នន័យឪពុកម្តាយដែលត្រូវនឹងការស្វែងរករបស់អ្នកឡើយ។
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mt-3">
        <p class="text-muted small mb-0">Showing {{ $parents->firstItem() ?? 0 }} to {{ $parents->lastItem() ?? 0 }} of {{ $parents->total() }} parents</p>
        <nav aria-label="Parents pagination">
          <ul class="pagination pagination-sm mb-0">
            <li class="page-item {{ $parents->onFirstPage() ? 'disabled' : '' }}">
              <a class="page-link" href="{{ $parents->previousPageUrl() ?: '#' }}" aria-label="Previous">Previous</a>
            </li>

            @foreach(range(1, $parents->lastPage()) as $page)
              <li class="page-item {{ $parents->currentPage() == $page ? 'active' : '' }}">
                <a class="page-link" href="{{ $parents->url($page) }}">{{ $page }}</a>
              </li>
            @endforeach

            <li class="page-item {{ $parents->hasMorePages() ? '' : 'disabled' }}">
              <a class="page-link" href="{{ $parents->nextPageUrl() ?: '#' }}" aria-label="Next">Next</a>
            </li>
          </ul>
        </nav>
      </div>
    </section>
  </div>
</main>

@include('admin.include.footer')
