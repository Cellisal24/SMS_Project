@include('Admin.include.header')

      <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
          <div class="page-heading">
            <div class="page-heading-copy">
              <span class="page-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
              <div>
                <p class="eyebrow mb-1">Management</p>
                <h1 class="h3 mb-1">Grade Levels</h1>
                <p class="text-muted mb-0">Review and manage grade levels.</p>
              </div>
            </div>
            <div class="heading-actions"><a class="btn btn-outline-secondary btn-sm" href="tables.html"><i class="bi bi-download" aria-hidden="true"></i> Export</a><a class="btn btn-primary btn-sm" href="{{ route('grade-levels.create') }}"><i class="bi bi-person-plus" aria-hidden="true"></i> Add Grade Level</a></div>
          </div>

          @if (session('success') || session('error') || session('warning'))
            <div class="container-fluid px-3 px-lg-4 mt-3">
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

          <section class="row g-3 mt-1" aria-label="Grade level summary">
            <div class="col-12 col-sm-6 col-xl-3">
              <article class="metric-card metric-primary">
                <div class="metric-top">
                  <span class="metric-label">Total Grade Levels</span>
                  <span class="metric-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">8,742</div>
                <div class="metric-meta">
                  <span class="text-success">+5.1%</span>
                  <span>this month</span>
                </div>
              </article>
            </div>

            {{-- <div class="col-12 col-sm-6 col-xl-3">
              <article class="metric-card metric-success">
                <div class="metric-top">
                  <span class="metric-label">Active</span>
                  <span class="metric-icon"><i class="bi bi-check2-circle" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">7,980</div>
                <div class="metric-meta">
                  <span class="text-success">91%</span>
                  <span>healthy accounts</span>
                </div>
              </article>
            </div> --}}

            {{-- <div class="col-12 col-sm-6 col-xl-3">
              <article class="metric-card metric-warning">
                <div class="metric-top">
                  <span class="metric-label">Pending</span>
                  <span class="metric-icon"><i class="bi bi-hourglass-split" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">184</div>
                <div class="metric-meta">
                  <span class="text-warning">12</span>
                  <span>need approval</span>
                </div>
              </article>
            </div> --}}

            {{-- <div class="col-12 col-sm-6 col-xl-3">
              <article class="metric-card metric-danger">
                <div class="metric-top">
                  <span class="metric-label">Suspended</span>
                  <span class="metric-icon"><i class="bi bi-slash-circle" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">38</div>
                <div class="metric-meta">
                  <span class="text-danger">4</span>
                  <span>flagged today</span>
                </div>
              </article>
            </div> --}}
          </section>

          <section class="panel mt-3">
            <div class="panel-header">
              <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i><span>Grade Levels</span></h2>
                <p class="text-muted mb-0">Search, review, and manage grade levels.</p>
              </div>
              <div class="d-flex flex-column flex-sm-row gap-2 align-items-center w-100">
                <form class="d-flex flex-wrap gap-2 w-100" method="GET" action="{{ route('grade-levels.index') }}">
                  <input
                    name="search"
                    class="form-control form-control-sm"
                    type="search"
                    value="{{ request('search') }}"
                    placeholder="Search grade levels"
                    aria-label="Search grade levels"
                  >
                  <select name="stage" class="form-select form-select-sm">
                    <option value="">Filter by stage</option>
                    @foreach($stageOptions as $stage)
                      <option value="{{ $stage }}" {{ request('stage') === $stage ? 'selected' : '' }}>{{ $stage }}</option>
                    @endforeach
                  </select>
                  <button type="submit" class="btn btn-secondary btn-sm">Apply</button>
                  @if(request()->filled('search') || request()->filled('stage'))
                    <a class="btn btn-link btn-sm text-decoration-none" href="{{ route('grade-levels.index') }}">Reset</a>
                  @endif
                </form>
                <a class="btn btn-primary btn-sm" href="{{ route('grade-levels.create') }}"><i class="bi bi-person-plus" aria-hidden="true"></i> Add Grade Level</a>
              </div>
            </div>
            <div class="table-responsive">
              {{-- <table class="table align-middle mb-0" id="usersTable" data-searchable-table>
                <thead><tr><th scope="col">User</th><th scope="col">Role</th><th scope="col">Team</th><th scope="col">Status</th><th scope="col">Joined</th><th scope="col" class="text-end">Action</th></tr></thead>
                <tbody>
                  <tr>
                    <td>
                      <div class="d-flex align-items-center gap-2">
                        <img class="avatar-img avatar-sm" src="../assets/images/avatar/avatar-1.jpg" alt="Sarah Ahmed">
                        <div>
                          <p class="fw-semibold mb-0">Sarah Ahmed</p>
                          <p class="text-muted small mb-0">sarah@example.com</p>
                        </div>
                      </div>
                    </td>
                    <td>Admin</td>
                    <td>Operations</td>
                    <td><span class="badge text-bg-success">Active</span></td>
                    <td>Jan 12, 2026</td>
                    <td class="text-end"><a class="btn btn-light btn-sm" href="user-details.html">View</a></td>
                  </tr>
       
                 
                </tbody>
              </table> --}}

              <table class="table align-middle mb-0" id="gradeLevelsTable" data-searchable-table>
    <thead>
        <tr>
            <th scope="col" class="text-center" style="width: 100px;">លំដាប់ (Sort)</th>
            <th scope="col">ឈ្មោះកម្រិតថ្នាក់ (Grade Level)</th>
            <th scope="col">ដំណាក់កាលសិក្សា (Stage)</th>
            <th scope="col" class="text-end">សកម្មភាព (Action)</th>
        </tr>
    </thead>
    <tbody>
        @forelse($gradeLevels as $level)
            <tr>
                <!-- 1. លេខរៀបលំដាប់ (Sort Order) -->
                <td class="text-center">
                    <span class="badge bg-light text-dark border fw-bold px-2.5 py-1.5">
                        {{ $level->sort_order }}
                    </span>
                </td>

                <!-- 2. ឈ្មោះកម្រិតថ្នាក់ -->
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <!-- Icon តំណាងឱ្យកម្រិតថ្នាក់ -->
                        <div class="bg-primary-subtle text-primary rounded px-2 py-1 small">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                        <div>
                            <p class="fw-semibold mb-0 text-dark">{{ $level->level_name }}</p>
                            <p class="text-muted small mb-0">ID: {{ $level->level_id }}</p>
                        </div>
                    </div>
                </td>

                <!-- 3. ដំណាក់កាលសិក្សា (Stage) -->
                <td>
                    @if($level->stage == 'High School')
                        <span class="badge text-bg-purple bg-opacity-10 text-purple border border-purple-subtle" style="color: #6f42c1; background-color: #f1e7fe;">
                            {{ $level->stage }}
                        </span>
                    @else
                        <span class="badge text-bg-info bg-opacity-10 text-info border border-info-subtle">
                            {{ $level->stage }}
                        </span>
                    @endif
                </td>

                <!-- 4. ប៊ូតុងសកម្មភាព (Edit & Delete) -->
                <td class="text-end">
                    <div class="d-flex justify-content-end gap-1">
                        <!-- ប៊ូតុង Edit -->
                        <a class="btn btn-light btn-sm text-primary border" href="{{ route('grade-levels.edit', $level->level_id) }}">
                            <i class="fa-solid fa-pen-to-square"></i> កែប្រែ
                        </a>

                        <!-- ហ្វមសម្រាប់ចុចលុប (Delete) -->
                        <form action="{{ route('grade-levels.destroy', $level->level_id) }}" method="POST" 
                              onsubmit="return confirm('តើអ្នកពិតជាចង់លុបកម្រិតថ្នាក់នេះមែនទេ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-light btn-sm text-danger border">
                                <i class="fa-solid fa-trash">លុប</i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <!-- បង្ហាញនៅពេលគ្មានទិន្នន័យសោះក្នុង Database -->
            <tr>
                <td colspan="4" class="text-center py-4 text-muted italic">
                    <i class="fa-regular fa-folder-open me-1"></i> មិនទាន់មានទិន្នន័យកម្រិតថ្នាក់នៅក្នុងប្រព័ន្ធនៅឡើយទេ។
                </td>
            </tr>
          @endforelse
        </tbody>
        </table>
            </div>
            <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mt-3">
              <p class="text-muted small mb-0">Showing {{ $gradeLevels->firstItem() ?? 0 }} to {{ $gradeLevels->lastItem() ?? 0 }} of {{ $gradeLevels->total() }} grade levels</p>
              <nav aria-label="Grade levels pagination">
                <ul class="pagination pagination-sm mb-0">
                  <li class="page-item {{ $gradeLevels->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $gradeLevels->previousPageUrl() ?: '#' }}" aria-label="Previous">Previous</a>
                  </li>

                  @foreach(range(1, $gradeLevels->lastPage()) as $page)
                    <li class="page-item {{ $gradeLevels->currentPage() == $page ? 'active' : '' }}">
                      <a class="page-link" href="{{ $gradeLevels->url($page) }}">{{ $page }}</a>
                    </li>
                  @endforeach

                  <li class="page-item {{ $gradeLevels->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $gradeLevels->nextPageUrl() ?: '#' }}" aria-label="Next">Next</a>
                  </li>
                </ul>
              </nav>
            </div>
          </section>
        </div>
      </main>
@include('Admin.include.footer')