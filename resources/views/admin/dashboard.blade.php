
@include('admin.include.header')
      <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
          <div class="page-heading">
            <div class="page-heading-copy">
              <span class="page-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
              <div>
                <p class="eyebrow mb-1">Overview</p>
                <h1 class="h3 mb-1">Dashboard</h1>
                <p class="text-muted mb-0">Students, teachers, payments, and recent activity at a glance.</p>
              </div>
            </div>
          </div>

          <section class="row g-3 mt-1" aria-label="Dashboard metrics">
            <div class="col-12 col-sm-6 col-xl-3">
              <article class="metric-card metric-primary">
                <div class="metric-top">
                  <span class="metric-label">Students</span>
                  <span class="metric-icon"><i class="bi bi-mortarboard" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">{{ number_format($studentCount) }}</div>
                <div class="metric-meta">
                  @if ($studentGrowth !== null)
                    <span class="{{ $studentGrowth >= 0 ? 'text-success' : 'text-danger' }}">{{ $studentGrowth >= 0 ? '+' : '' }}{{ $studentGrowth }}%</span>
                    <span>vs last month</span>
                  @else
                    <span>{{ $activeStudentCount }} active</span>
                  @endif
                </div>
              </article>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
              <article class="metric-card metric-success">
                <div class="metric-top">
                  <span class="metric-label">Teachers</span>
                  <span class="metric-icon"><i class="bi bi-person-workspace" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">{{ number_format($teacherCount) }}</div>
                <div class="metric-meta">
                  <span>on staff</span>
                </div>
              </article>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
              <article class="metric-card metric-warning">
                <div class="metric-top">
                  <span class="metric-label">Classes</span>
                  <span class="metric-icon"><i class="bi bi-easel" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">{{ number_format($classCount) }}</div>
                <div class="metric-meta">
                  <span>active classes</span>
                </div>
              </article>
            </div>

            <div class="col-12 col-sm-6 col-xl-3">
              <article class="metric-card metric-danger">
                <div class="metric-top">
                  <span class="metric-label">Outstanding Fees</span>
                  <span class="metric-icon"><i class="bi bi-cash-coin" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">${{ number_format($outstandingTotal, 2) }}</div>
                <div class="metric-meta">
                  <span>{{ $outstandingTotal > 0 ? 'unpaid across all students' : 'all fees settled' }}</span>
                </div>
              </article>
            </div>
          </section>
          <section class="row g-3 mt-1">
            <div class="col-12 col-xl-8">
              <div class="panel">
                <div class="panel-header">
                  <div>
                    <h2 class="h5 mb-1 section-title"><i class="bi bi-graph-up-arrow" aria-hidden="true"></i><span>Payments Collected</span></h2>
                    <p class="text-muted mb-0">Total amount collected per month, last 6 months.</p>
                  </div>
                  <a class="btn btn-light btn-sm" href="{{ route('admin.payments.index') }}">View Details</a>
                </div>

                <div class="chart-bars" aria-label="Payments collected chart">
                  @foreach ($monthlyCollected as $month)
                    <div class="chart-column">
                      <span style="height: {{ max(4, round(($month['total'] / $maxCollected) * 100)) }}%"></span>
                      <small>{{ $month['label'] }}</small>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>

            <div class="col-12 col-xl-4">
              <div class="panel h-100">
                <div class="panel-header">
                  <div>
                    <h2 class="h5 mb-1 section-title"><i class="bi bi-activity" aria-hidden="true"></i><span>Recent Activity</span></h2>
                    <p class="text-muted mb-0">Latest changes across the system.</p>
                  </div>
                  <a class="btn btn-light btn-sm" href="{{ route('admin.activity-logs.index') }}">View All</a>
                </div>

                <div class="activity-list">
                  @forelse ($recentActivity as $log)
                    @php
                      $dot = match(strtolower($log->action)) {
                        'create', 'created', 'insert', 'login' => 'bg-success',
                        'update', 'updated' => 'bg-warning',
                        'delete', 'deleted', 'logout' => 'bg-danger',
                        default => 'bg-secondary',
                      };
                    @endphp
                    <div class="activity-item">
                      <span class="activity-dot {{ $dot }}"></span>
                      <div>
                        <p class="mb-1 fw-semibold text-capitalize">{{ $log->action }} — {{ $log->table_name }}</p>
                        <p class="text-muted small mb-0">
                          {{ $log->user->username ?? 'System' }} · {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}
                        </p>
                      </div>
                    </div>
                  @empty
                    <p class="text-muted small mb-0">No activity recorded yet.</p>
                  @endforelse
                </div>
              </div>
            </div>
          </section>

          <section class="panel mt-3">
            <div class="panel-header">
              <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-people" aria-hidden="true"></i><span>Recent Users</span></h2>
                <p class="text-muted mb-0">Latest accounts created in the system.</p>
              </div>
            </div>
            <div class="table-responsive">
              <table class="table align-middle mb-0">
                <thead><tr><th scope="col">User</th><th scope="col">Role</th><th scope="col">Joined</th></tr></thead>
                <tbody>
                  @forelse ($recentUsers as $user)
                    <tr>
                      <td>
                        <div class="d-flex align-items-center gap-2">
                          @php
                            $photo = match($user->role) {
                              'student' => $user->student->photo ?? null,
                              'teacher' => $user->teacher->photo ?? null,
                              'parent' => $user->parentProfile->photo ?? null,
                              default => null,
                            };
                          @endphp
                          @if ($photo)
                            <img class="avatar-img avatar-sm" src="{{ asset('storage/' . $photo) }}" alt="{{ $user->username }}">
                          @else
                            <span class="avatar-img avatar-sm bg-light d-inline-flex align-items-center justify-content-center">
                              <i class="bi bi-person text-muted" aria-hidden="true"></i>
                            </span>
                          @endif
                          <p class="fw-semibold mb-0">{{ $user->username }}</p>
                        </div>
                      </td>
                      <td class="text-capitalize">{{ $user->role }}</td>
                      <td>{{ $user->created_at->format('M j, Y') }}</td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="3" class="text-center text-muted py-3">No users found.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </section>
        </div>
      </main>
@include('admin.include.footer')
