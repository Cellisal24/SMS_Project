@include('admin.include.header')

      <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
          <div class="page-heading d-flex flex-column flex-lg-row align-items-start align-items-lg-center justify-content-between gap-3 mb-4">
            <div>
              <p class="eyebrow mb-2 text-uppercase text-primary fw-semibold">Grade Level Management</p>
              <h1 class="h2 fw-bold mb-2">បន្ថែមកម្រិតថ្នាក់ថ្មី</h1>
              <p class="text-muted mb-0">Add a new grade level or academic stage to the system. This page now uses the full admin content width for a better form experience.</p>
            </div>
            <a href="{{ route('grade-levels.index') }}" class="btn btn-primary  btn-sm px-4 py-2">
              ⬅️ Back to Grade Levels
            </a>
          </div>

          <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
              <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="bg-primary bg-opacity-10 p-4">
                  <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
                    <div>
                      <h2 class="h4 fw-semibold mb-1">Grade Level Details</h2>
                      <p class="text-muted mb-0">Enter the grade name, stage, and sort order for dropdown display and academic grouping.</p>
                    </div>
                    <div class="text-end">
                      <span class="badge bg-primary text-white">Full Width Form</span>
                    </div>
                  </div>
                </div>

                <div class="card-body p-4 p-md-5 bg-white">
                  @if ($errors->any())
                    <div class="alert alert-danger rounded-3 mb-4">
                      <h5 class="alert-heading mb-2">សូមពិនិត្យមើលឡើងវិញ៖</h5>
                      <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    </div>
                  @endif

                  <form action="{{ route('grade-levels.store') }}" method="POST" class="row g-4">
                    @csrf

                    <div class="col-12">
                      <label for="level_name" class="form-label fw-semibold">ឈ្មោះកម្រិតថ្នាក់ (Grade Level Name) <span class="text-danger">*</span></label>
                      <input type="text" id="level_name" name="level_name" value="{{ old('level_name') }}" placeholder="ឧទាហរណ៍៖ Grade 10, Year 1, ថ្នាក់ទី១២" required class="form-control form-control-lg shadow-sm border-1 border-gray-200">
                    </div>
                    <div class="col-md-6">
                      <label for="stage" class="form-label fw-semibold">ដំណាក់កាលសិក្សា (Stage) <span class="text-danger">*</span></label>
                      <select id="stage" name="stage" required class="form-select form-select-lg shadow-sm border-1 border-gray-200">
                        <option value="" disabled selected>--- ជ្រើសរើសដំណាក់កាល ---</option>
                        <option value="Primary School" {{ old('stage') == 'Primary School' ? 'selected' : '' }}>Primary School (បឋមសិក្សា)</option>
                        <option value="Secondary School" {{ old('stage') == 'Secondary School' ? 'selected' : '' }}>Secondary School (អនុវិទ្យាល័យសិក្សា)</option>
                        <option value="High School" {{ old('stage') == 'High School' ? 'selected' : '' }}>High School (វិទ្យាល័យសិក្សា)</option>
                        <option value="Foundation Year" {{ old('stage') == 'Foundation Year' ? 'selected' : '' }}>Foundation Year (ឆ្នាំសិក្សាមូលដ្ឋាន)</option>
                        <option value="Bachelor" {{ old('stage') == 'Bachelor' ? 'selected' : '' }}>Bachelor Degree (បរិញ្ញាបត្រ)</option>
                      </select>
                    </div>

                    <div class="col-md-6">
                      <label for="sort_order" class="form-label fw-semibold">លេខរៀបលំដាប់ (Sort Order) <span class="text-danger">*</span></label>
                      <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 1) }}" min="1" required placeholder="ឧទាហរណ៍៖ លេខ ១ សម្រាប់ថ្នាក់ទាបជាងគេ" class="form-control form-control-lg shadow-sm border-1 border-gray-200">
                      <div class="form-text text-muted">ប្រើសម្រាប់តម្រៀបលំដាប់ថ្នាក់ពីទាបទៅខ្ពស់នៅលើ Dropdown ផ្សេងៗក្នុងប្រព័ន្ធ។</div>
                    </div>

                    <div class="col-12 d-flex flex-column flex-sm-row justify-content-end gap-3 mt-1 pt-3 border-top border-gray-200">
                      <button type="reset" class="btn btn-outline-secondary btn-lg">សម្អាត (Clear)</button>
                      <button type="submit" class="btn btn-primary btn-lg"> រក្សាទុកទិន្នន័យ</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>

@include('admin.include.footer')
