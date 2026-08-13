@include('admin.include.header')

      <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
          <div class="page-heading">
            <div class="page-heading-copy">
              <span class="page-icon"><i class="bi bi-mortarboard" aria-hidden="true"></i></span>
              <div>
                <p class="eyebrow mb-1">Management</p>
                <h1 class="h3 mb-1">School Classes</h1>
                <p class="text-muted mb-0">Review and manage school classes.</p>
              </div>
            </div>
            <div class="heading-actions">
              <a class="btn btn-outline-secondary btn-sm" href="#"><i class="bi bi-download" aria-hidden="true"></i> Export</a>
              <a class="btn btn-primary btn-sm" href="{{ route('school-classes.create') }}"><i class="bi bi-plus-lg" aria-hidden="true"></i> Add Class</a>
            </div>
          </div>

          {{-- 🔔 Section: Alert Messages --}}
          @if (session('success') || session('error'))
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
            </div>
          @endif

          {{-- 📊 Section: Table Control & Data Table --}}
          <section class="panel mt-3">
            <div class="panel-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
              <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i><span>Classes List</span></h2>
                <p class="text-muted mb-0 small">Search and filter class data dynamically.</p>
              </div>
              
              <!-- 🔍 Laravel Form Filter & Search -->
              <form class="d-flex flex-wrap gap-2" method="GET" action="{{ route('school-classes.index') }}">
                <div style="width: 200px;">
                  <input
                    name="search"
                    class="form-control form-control-sm"
                    type="search"
                    value="{{ request('search') }}"
                    placeholder="ស្វែងរកកូដ ឬឈ្មោះថ្នាក់..."
                  >
                </div>
                
                {{-- Filter by Grade Level --}}
                <div style="width: 150px;">
                  <select name="level_id" class="form-select form-select-sm">
                    <option value="">Filter by Grade</option>
                    @foreach($gradeLevels as $level)
                      <option value="{{ $level->level_id }}" {{ request('level_id') == $level->level_id ? 'selected' : '' }}>
                        {{ $level->level_name }}
                      </option>
                    @endforeach
                  </select>
                </div>

                {{-- 💡 Filter by Academic Year (ជំនួស Shift) --}}
                <div style="width: 160px;">
                  <select name="academic_year" class="form-select form-select-sm">
                    <option value="">Filter by Year</option>
                    @foreach($academicYears as $year)
                      <option value="{{ $year }}" {{ request('academic_year') == $year ? 'selected' : '' }}>
                        {{ $year }}
                      </option>
                    @endforeach
                  </select>
                </div>

                <button type="submit" class="btn btn-secondary btn-sm px-3">Apply</button>
                
                @if(request()->filled('search') || request()->filled('level_id') || request()->filled('academic_year'))
                  <a class="btn btn-outline-danger btn-sm px-2" href="{{ route('school-classes.index') }}">Reset</a>
                @endif
              </form>
            </div>

            <div class="table-responsive">
              <table class="table align-middle mb-0">
                <thead>
                  <tr>
                    <th scope="col" class="ps-3">កូដថ្នាក់ (Class ID)</th>
                    <th scope="col">ឈ្មោះថ្នាក់ (Class Name)</th>
                    <th scope="col">កម្រិតថ្នាក់ (Grade Level)</th>
                    <th scope="col">បន្ទប់រៀន (Room)</th>
                    <th scope="col">ឆ្នាំសិក្សា (Academic Year)</th>
                    <th scope="col" class="text-end pe-3">សកម្មភាព (Action)</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($classes as $class)
                    <tr>
                      <td class="ps-3 fw-bold text-secondary">{{ $class->class_id }}</td>
                      <td><span class="fw-semibold text-dark">{{ $class->class_name }}</span></td>
                      <td>{{ $class->gradeLevel->level_name ?? 'N/A' }}</td>
                      <td><i class="bi bi-door-open text-muted"></i> {{ $class->room->room_name ?? 'N/A' }}</td>
                      <td>
                        <span class="badge bg-light text-dark border px-2.5 py-1.5">
                          {{ $class->academic_year }}
                        </span>
                      </td>
                      <td class="text-end pe-3">
                        <div class="d-flex justify-content-end gap-1">
                          <a class="btn btn-light btn-sm text-primary border" href="{{ route('school-classes.edit', $class->class_id) }}">
                            <i class="bi bi-pencil-square"></i> កែប្រែ
                          </a>
                          <form action="{{ route('school-classes.destroy', $class->class_id) }}" method="POST" onsubmit="return confirm('តើអ្នកពិតជាចង់លុបថ្នាក់នេះមែនទេ?')">
                            @csrf 
                            @method('DELETE')
                            <button type="submit" class="btn btn-light btn-sm text-danger border"><i class="bi bi-trash"></i> លុប</button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="6" class="text-center py-4 text-muted">
                        <i class="bi bi-folder-x me-1"></i> មិនមានទិន្នន័យថ្នាក់រៀនឡើយ។
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            {{-- 📄 Section: Pagination --}}
           <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mt-3">
                <p class="text-muted small mb-0">
                    Showing {{ $classes->firstItem() ?? 0 }} to {{ $classes->lastItem() ?? 0 }} of {{ $classes->total() }} classes
                </p>
                
                <nav aria-label="Classes pagination">
                    <ul class="pagination pagination-sm mb-0">
                        {{-- ប៊ូតុង Previous --}}
                        <li class="page-item {{ $classes->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link" href="{{ $classes->appends(request()->query())->previousPageUrl() ?: '#' }}" aria-label="Previous">Previous</a>
                        </li>

                        {{-- លេខទំព័រ 1, 2, 3... --}}
                        @foreach(range(1, $classes->lastPage()) as $page)
                            <li class="page-item {{ $classes->currentPage() == $page ? 'active' : '' }}">
                                <a class="page-link" href="{{ $classes->appends(request()->query())->url($page) }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        {{-- ប៊ូតុង Next --}}
                        <li class="page-item {{ $classes->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link" href="{{ $classes->appends(request()->query())->nextPageUrl() ?: '#' }}" aria-label="Next">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
          </section>
        </div>
      </main>

@include('admin.include.footer')
