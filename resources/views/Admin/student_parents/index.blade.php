@include('Admin.include.header')

<main class="dashboard-content">
  <div class="container-fluid px-3 px-lg-4 py-4">
    <div class="page-heading">
      <div class="page-heading-copy">
        <span class="page-icon"><i class="bi bi-link-45deg" aria-hidden="true"></i></span>
        <div>
          <p class="eyebrow mb-1">Management</p>
          <h1 class="h3 mb-1">Student ↔ Parent Links</h1>
          <p class="text-muted mb-0">Manage which parents are linked to which students.</p>
        </div>
      </div>
      <div class="heading-actions">
        <a class="btn btn-outline-secondary btn-sm" href="#"><i class="bi bi-download" aria-hidden="true"></i> Export</a>
        <a class="btn btn-primary btn-sm" href="{{ route('admin.student_parents.create') }}"><i class="bi bi-plus-lg" aria-hidden="true"></i> Add Link</a>
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

    <section class="row g-3 mt-1" aria-label="Links summary">
      <div class="col-12 col-sm-6 col-xl-3">
        <article class="metric-card metric-primary">
          <div class="metric-top">
            <span class="metric-label">Total Links</span>
            <span class="metric-icon"><i class="bi bi-link-45deg" aria-hidden="true"></i></span>
          </div>
          <div class="metric-value">{{ $studentParents->total() }}</div>
          <div class="metric-meta">
            <span class="text-success"><i class="bi bi-arrow-up-right"></i> Active</span>
            <span>relationships</span>
          </div>
        </article>
      </div>
    </section>

    <section class="panel mt-3">
      <div class="panel-header flex-column flex-md-row gap-3">
        <div>
          <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i><span>Links List</span></h2>
          <p class="text-muted mb-0">Search, review, and manage student-parent links.</p>
        </div>

        <div class="d-flex flex-grow-1 justify-content-end w-100">
          <form class="d-flex flex-wrap gap-2 w-100 justify-content-md-end" method="GET" action="{{ route('admin.student_parents.index') }}">
            <div style="min-width: 220px;">
              <input
                name="search"
                class="form-control form-control-sm"
                type="search"
                value="{{ request('search') }}"
                placeholder="ស្វែងរកឈ្មោះសិស្ស ឬឪពុកម្តាយ..."
                aria-label="Search links"
              >
            </div>
            <button type="submit" class="btn btn-secondary btn-sm px-3">Apply</button>

            @if(request()->filled('search'))
              <a class="btn btn-link btn-sm text-decoration-none" href="{{ route('admin.student_parents.index') }}">Reset</a>
            @endif
          </form>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table align-middle mb-0" id="studentParentsTable">
          <thead>
            <tr>
              <th scope="col" class="ps-3">សិស្ស (Student)</th>
              <th scope="col">ឪពុកម្តាយ (Parent)</th>
              <th scope="col">ទំនាក់ទំនង (Relationship)</th>
              <th scope="col">ចម្បង (Primary)</th>
              <th scope="col" class="text-end pe-3">សកម្មភាព (Action)</th>
            </tr>
          </thead>
          <tbody>
            @forelse($studentParents as $link)
              <tr>
                <td class="ps-3">
                  <div class="d-flex align-items-center gap-2">
                    <div class="bg-primary-subtle text-primary rounded px-2 py-1 small">
                      <i class="bi bi-person"></i>
                    </div>
                    <span class="fw-semibold text-dark">{{ $link->student?->fullName() ?? '—' }}</span>
                    <span class="text-muted small">({{ $link->student_id }})</span>
                  </div>
                </td>

                <td>
                  <div class="d-flex align-items-center gap-2">
                    <div class="bg-secondary-subtle text-secondary rounded px-2 py-1 small">
                      <i class="bi bi-person-heart"></i>
                    </div>
                    <span class="fw-semibold text-dark">{{ $link->parent?->fullName() ?? '—' }}</span>
                    <span class="text-muted small">({{ $link->parent_id }})</span>
                  </div>
                </td>

                <td>{{ $link->relationship ?? '—' }}</td>

                <td>
                  @if ($link->is_primary)
                    <span class="badge bg-success">Primary</span>
                  @else
                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle">—</span>
                  @endif
                </td>

                <td class="text-end pe-3">
                  <div class="d-flex justify-content-end gap-1">
                    <a class="btn btn-light btn-sm text-primary border" href="{{ route('admin.student_parents.edit', $link->id) }}">
                      <i class="bi bi-pencil-square"></i> កែប្រែ
                    </a>

                    <form action="{{ route('admin.student_parents.destroy', $link->id) }}" method="POST"
                          onsubmit="return confirm('តើអ្នកពិតជាចង់លុបការភ្ជាប់នេះមែនទេ?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-light btn-sm text-danger border">
                        <i class="bi bi-trash"></i> លុប
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center py-4 text-muted italic">
                  <i class="bi bi-folder-x me-1"></i> មិនមានទិន្នន័យការភ្ជាប់ដែលត្រូវនឹងការស្វែងរករបស់អ្នកឡើយ។
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mt-3">
        <p class="text-muted small mb-0">Showing {{ $studentParents->firstItem() ?? 0 }} to {{ $studentParents->lastItem() ?? 0 }} of {{ $studentParents->total() }} links</p>
        <nav aria-label="Links pagination">
          <ul class="pagination pagination-sm mb-0">
            <li class="page-item {{ $studentParents->onFirstPage() ? 'disabled' : '' }}">
              <a class="page-link" href="{{ $studentParents->previousPageUrl() ?: '#' }}" aria-label="Previous">Previous</a>
            </li>

            @foreach(range(1, $studentParents->lastPage()) as $page)
              <li class="page-item {{ $studentParents->currentPage() == $page ? 'active' : '' }}">
                <a class="page-link" href="{{ $studentParents->url($page) }}">{{ $page }}</a>
              </li>
            @endforeach

            <li class="page-item {{ $studentParents->hasMorePages() ? '' : 'disabled' }}">
              <a class="page-link" href="{{ $studentParents->nextPageUrl() ?: '#' }}" aria-label="Next">Next</a>
            </li>
          </ul>
        </nav>
      </div>
    </section>
  </div>
</main>

@include('Admin.include.footer')