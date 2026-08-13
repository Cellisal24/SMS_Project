@include('admin.include.header')

      <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
          <div class="page-heading">
            <div class="page-heading-copy">
              <span class="page-icon"><i class="bi bi-book" aria-hidden="true"></i></span>
              <div>
                <p class="eyebrow mb-1">Management</p>
                <h1 class="h3 mb-1">Subjects</h1>
                <p class="text-muted mb-0">Review and manage curriculum subjects.</p>
              </div>
            </div>
            <div class="heading-actions">
              <a class="btn btn-outline-secondary btn-sm" href="#"><i class="bi bi-download" aria-hidden="true"></i> Export</a>
              <a class="btn btn-primary btn-sm" href="{{ route('admin.subjects.create') }}"><i class="bi bi-plus-lg" aria-hidden="true"></i> Add Subjects</a>
            </div>
          </div>

          {{-- 🔔 Section: Alert Messages --}}
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

          {{-- 📊 Section: Metric Summary --}}
          <section class="row g-3 mt-1" aria-label="Subjects summary">
            <div class="col-12 col-sm-6 col-xl-3">
              <article class="metric-card metric-primary">
                <div class="metric-top">
                  <span class="metric-label">Total Subjects</span>
                  <span class="metric-icon"><i class="bi bi-book" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">{{ $subjects->total() }}</div>
                <div class="metric-meta">
                  <span class="text-success"><i class="bi bi-arrow-up-right"></i> Active</span>
                  <span>in curriculum</span>
                </div>
              </article>
            </div>
          </section>

          {{-- 📊 Section: Table Control & Data Table --}}
          <section class="panel mt-3">
            <div class="panel-header flex-column flex-md-row gap-3">
              <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i><span>Subjects List</span></h2>
                <p class="text-muted mb-0">Search, review, and manage subjects.</p>
              </div>
              
              <!-- 🔍 Laravel Form Filter & Search -->
              <div class="d-flex flex-grow-1 justify-content-end w-100">
                <form class="d-flex flex-wrap gap-2 w-100 justify-content-md-end" method="GET" action="{{ route('admin.subjects.index') }}">
                  <div style="min-width: 200px;">
                    <input
                      name="search"
                      class="form-control form-control-sm"
                      type="search"
                      value="{{ request('search') }}"
                      placeholder="ស្វែងរកកូដ ឬឈ្មោះមុខវិជ្ជា..."
                      aria-label="Search subjects"
                    >
                  </div>
                  <div style="min-width: 160px;">
                    <select name="department" class="form-select form-select-sm">
                      <option value="">Filter by Department</option>
                      <option value="Information Technology" {{ request('department') === 'Information Technology' ? 'selected' : '' }}>Information Technology</option>
                      <option value="Computer Science" {{ request('department') === 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-secondary btn-sm px-3">Apply</button>
                  
                  @if(request()->filled('search') || request()->filled('department'))
                    <a class="btn btn-link btn-sm text-decoration-none" href="{{ route('admin.subjects.index') }}">Reset</a>
                  @endif
                </form>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table align-middle mb-0" id="subjectsTable">
                <thead>
                  <tr>
                    <th scope="col" class="ps-3" style="width: 180px;">កូដមុខវិជ្ជា (Subject ID)</th>
                    <th scope="col">ឈ្មោះមុខវិជ្ជា (Subject Name)</th>
                    <th scope="col">ដេប៉ាតឺម៉ង់ (Department)</th>
                    <th scope="col">ចំនួនក្រេឌីត (Credit Hours)</th>
                    <th scope="col" class="text-end pe-3">សកម្មភាព (Action)</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($subjects as $subject)
                    <tr>
                      <!-- 1. កូដមុខវិជ្ជា -->
                      <td class="ps-3 fw-bold text-secondary">
                        {{ $subject->subject_id }}
                      </td>

                      <!-- 2. ឈ្មោះមុខវិជ្ជា -->
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <div class="bg-primary-subtle text-primary rounded px-2 py-1 small">
                            <i class="bi bi-journal-text"></i>
                          </div>
                          <span class="fw-semibold text-dark">{{ $subject->subject_name }}</span>
                        </div>
                      </td>

                      <!-- 3. ដេប៉ាតឺម៉ង់ -->
                      <td>
                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary-subtle px-2 py-1">
                          {{ $subject->department ?? 'N/A' }}
                        </span>
                      </td>

                      <!-- 4. ចំនួនក្រេឌីត -->
                      <td>
                        <i class="bi bi-clock text-muted me-1"></i> {{ $subject->credit_hours ?? 0 }} ក្រេឌីត
                      </td>

                      <!-- 5. ប៊ូតុងសកម្មភាព (Edit & Delete) -->
                      <td class="text-end pe-3">
                        <div class="d-flex justify-content-end gap-1">
                          <a class="btn btn-light btn-sm text-primary border" href="{{ route('admin.subjects.edit', $subject->subject_id) }}">
                            <i class="bi bi-pencil-square"></i> កែប្រែ
                          </a>

                          <form action="{{ route('admin.subjects.destroy', $subject->subject_id) }}" method="POST" 
                                onsubmit="return confirm('តើអ្នកពិតជាចង់លុបមុខវិជ្ជានេះមែនទេ?')">
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
                        <i class="bi bi-folder-x me-1"></i> មិនមានទិន្នន័យមុខវិជ្ជាដែលត្រូវនឹងការស្វែងរករបស់អ្នកឡើយ។
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <!-- 📄 Section: Pagination Links -->
            <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mt-3">
              <p class="text-muted small mb-0">Showing {{ $subjects->firstItem() ?? 0 }} to {{ $subjects->lastItem() ?? 0 }} of {{ $subjects->total() }} subjects</p>
              <nav aria-label="Subjects pagination">
                <ul class="pagination pagination-sm mb-0">
                  <li class="page-item {{ $subjects->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $subjects->previousPageUrl() ?: '#' }}" aria-label="Previous">Previous</a>
                  </li>

                  @foreach(range(1, $subjects->lastPage()) as $page)
                    <li class="page-item {{ $subjects->currentPage() == $page ? 'active' : '' }}">
                      <a class="page-link" href="{{ $subjects->url($page) }}">{{ $page }}</a>
                    </li>
                  @endforeach

                  <li class="page-item {{ $subjects->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $subjects->nextPageUrl() ?: '#' }}" aria-label="Next">Next</a>
                  </li>
                </ul>
              </nav>
            </div>
          </section>
        </div>
      </main>

@include('admin.include.footer')
