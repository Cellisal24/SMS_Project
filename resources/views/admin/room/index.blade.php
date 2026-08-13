@include('admin.include.header')

      <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
          <div class="page-heading">
            <div class="page-heading-copy">
              <span class="page-icon"><i class="bi bi-door-open" aria-hidden="true"></i></span>
              <div>
                <p class="eyebrow mb-1">Management</p>
                <h1 class="h3 mb-1">Rooms</h1>
                <p class="text-muted mb-0">Review and manage rooms.</p>
              </div>
            </div>
            <div class="heading-actions">
              <a class="btn btn-outline-secondary btn-sm" href="#"><i class="bi bi-download" aria-hidden="true"></i> Export</a>
              <a class="btn btn-primary btn-sm" href="{{ route('rooms.create') }}"><i class="bi bi-plus-lg" aria-hidden="true"></i> Add Rooms</a>
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
          <section class="row g-3 mt-1" aria-label="Rooms summary">
            <div class="col-12 col-sm-6 col-xl-3">
              <article class="metric-card metric-primary">
                <div class="metric-top">
                  <span class="metric-label">Total Rooms</span>
                  <span class="metric-icon"><i class="bi bi-door-open" aria-hidden="true"></i></span>
                </div>
                <!-- បង្ហាញចំនួនសរុបពិតប្រាកដចេញពី Pagination Object -->
                <div class="metric-value">{{ $rooms->total() }}</div>
                <div class="metric-meta">
                  <span class="text-success"><i class="bi bi-arrow-up-right"></i> Active</span>
                  <span>in system</span>
                </div>
              </article>
            </div>
          </section>

          {{-- 📊 Section: Table Control & Data Table --}}
          <section class="panel mt-3">
            <div class="panel-header flex-column flex-md-row gap-3">
              <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-table" aria-hidden="true"></i><span>Rooms List</span></h2>
                <p class="text-muted mb-0">Search, review, and manage rooms.</p>
              </div>
              
              <!-- 🔍 Laravel Form Filter & Search -->
              <div class="d-flex flex-grow-1 justify-content-end w-100">
                <form class="d-flex flex-wrap gap-2 w-100 justify-content-md-end" method="GET" action="{{ route('rooms.index') }}">
                  <div style="min-width: 200px;">
                    <input
                      name="search"
                      class="form-control form-control-sm"
                      type="search"
                      value="{{ request('search') }}"
                      placeholder="ស្វែងរកកូដ ឬឈ្មោះបន្ទប់..."
                      aria-label="Search rooms"
                    >
                  </div>
                  <div style="min-width: 160px;">
                    <select name="type" class="form-select form-select-sm">
                      <option value="">Filter by Type</option>
                      <option value="Theory Class" {{ request('type') === 'Theory Class' ? 'selected' : '' }}>Theory Class</option>
                      <option value="Laboratory" {{ request('type') === 'Laboratory' ? 'selected' : '' }}>Laboratory</option>
                      <option value="Meeting Room" {{ request('type') === 'Meeting Room' ? 'selected' : '' }}>Meeting Room</option>
                    </select>
                  </div>
                  <button type="submit" class="btn btn-secondary btn-sm px-3">Apply</button>
                  
                  @if(request()->filled('search') || request()->filled('type'))
                    <a class="btn btn-link btn-sm text-decoration-none" href="{{ route('rooms.index') }}">Reset</a>
                  @endif
                </form>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table align-middle mb-0" id="roomsTable">
                <thead>
                  <tr>
                    <th scope="col" class="ps-3" style="width: 150px;">កូដបន្ទប់ (Room ID)</th>
                    <th scope="col">ឈ្មោះបន្ទប់ (Room Name)</th>
                    <th scope="col">ប្រភេទបន្ទប់ (Type)</th>
                    <th scope="col">ចំណុះសិស្ស (Capacity)</th>
                    <th scope="col" class="text-end pe-3">សកម្មភាព (Action)</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($rooms as $room)
                    <tr>
                      <!-- 1. កូដបន្ទប់ -->
                      <td class="ps-3 fw-bold text-secondary">
                        {{ $room->room_id }}
                      </td>

                      <!-- 2. ឈ្មោះបន្ទប់ -->
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          <div class="bg-primary-subtle text-primary rounded px-2 py-1 small">
                            <i class="fa-solid fa-school"></i>
                          </div>
                          <span class="fw-semibold text-dark">{{ $room->room_name }}</span>
                        </div>
                      </td>

                      <!-- 3. ប្រភេទបន្ទប់ -->
                      <td>
                        @if($room->type == 'Laboratory')
                          <span class="badge text-bg-warning bg-opacity-10 text-warning border border-warning-subtle" style="color: #ffc107; background-color: #fff3cd;">
                            {{ $room->type }}
                          </span>
                        @elseif($room->type == 'Meeting Room')
                          <span class="badge text-bg-purple bg-opacity-10 text-purple border border-purple-subtle" style="color: #6f42c1; background-color: #f1e7fe;">
                            {{ $room->type }}
                          </span>
                        @else
                          <span class="badge text-bg-info bg-opacity-10 text-info border border-info-subtle">
                            {{ $room->type }}
                          </span>
                        @endif
                      </td>

                      <!-- 4. ចំណុះសិស្ស -->
                      <td>
                        <i class="bi bi-people text-muted me-1"></i> {{ $room->capacity }} នាក់
                      </td>

                      <!-- 5. ប៊ូតុងសកម្មភាព (Edit & Delete) -->
                      <td class="text-end pe-3">
                        <div class="d-flex justify-content-end gap-1">
                          <a class="btn btn-light btn-sm text-primary border" href="{{ route('rooms.edit', $room->room_id) }}">
                            <i class="bi bi-pencil-square"></i> កែប្រែ
                          </a>

                          <form action="{{ route('rooms.destroy', $room->room_id) }}" method="POST" 
                                onsubmit="return confirm('តើអ្នកពិតជាចង់លុບບន្ទប់នេះមែនទេ?')">
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
                        <i class="bi bi-folder-x me-1"></i> មិនមានទិន្នន័យបន្ទប់រៀនដែលត្រូវនឹងការស្វែងរករបស់អ្នកឡើយ។
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <!-- 📄 Section: Pagination Links -->
            <div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mt-3">
              <p class="text-muted small mb-0">Showing {{ $rooms->firstItem() ?? 0 }} to {{ $rooms->lastItem() ?? 0 }} of {{ $rooms->total() }} rooms</p>
              <nav aria-label="Rooms pagination">
                <ul class="pagination pagination-sm mb-0">
                  <li class="page-item {{ $rooms->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $rooms->previousPageUrl() ?: '#' }}" aria-label="Previous">Previous</a>
                  </li>

                  @foreach(range(1, $rooms->lastPage()) as $page)
                    <li class="page-item {{ $rooms->currentPage() == $page ? 'active' : '' }}">
                      <a class="page-link" href="{{ $rooms->url($page) }}">{{ $page }}</a>
                    </li>
                  @endforeach

                  <li class="page-item {{ $rooms->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link" href="{{ $rooms->nextPageUrl() ?: '#' }}" aria-label="Next">Next</a>
                  </li>
                </ul>
              </nav>
            </div>
          </section>
        </div>
      </main>

@include('admin.include.footer')
