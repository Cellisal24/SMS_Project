@include('admin.include.header')

<main class="dashboard-content">
    <div class="container py-4" style="max-width: 700px;">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white pt-4 px-4 border-0">
                <h3 class="fw-bold mb-0 text-dark">Edit School Class</h3>
            </div>
            <div class="card-body p-4">

                {{-- 🔔 Section: Alert Validation Error --}}
                @if ($errors->any())
                    <div class="alert alert-danger border-0">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error) 
                                <li>{{ $error }}</li> 
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('school-classes.update', $schoolClass->class_id) }}" method="POST">
                    @csrf 
                    @method('PUT')
                    
                    {{-- Class ID (ReadOnly) --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Class ID (Cannot change)</label>
                        <input type="text" class="form-control bg-light" value="{{ $schoolClass->class_id }}" disabled>
                    </div>

                    {{-- Class Name --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Class Name <span class="text-danger">*</span></label>
                        <input type="text" name="class_name" value="{{ old('class_name', $schoolClass->class_name) }}" class="form-control" required>
                    </div>

                    {{-- Grade Level --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Grade Level <span class="text-danger">*</span></label>
                        <select name="level_id" class="form-select" required>
                            @foreach($gradeLevels as $level)
                                <option value="{{ $level->level_id }}" {{ old('level_id', $schoolClass->level_id) == $level->level_id ? 'selected' : '' }}>
                                    {{ $level->level_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Assign Room (Optional) --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Assign Room</label>
                        <select name="room_id" class="form-select">
                            <option value="">--- Select Room (Optional) ---</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->room_id }}" {{ old('room_id', $schoolClass->room_id) == $room->room_id ? 'selected' : '' }}>
                                    {{ $room->room_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 💡 Academic Year (ជំនួស Shift ដែលបានលុប) --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Academic Year <span class="text-danger">*</span></label>
                        <input type="number" name="academic_year" value="{{ old('academic_year', $schoolClass->academic_year) }}" class="form-control" min="2000" max="2099" required>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('school-classes.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Class</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

@include('admin.include.footer')
