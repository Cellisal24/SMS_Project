@include('Admin.include.header')
<main class="dashboard-content">
    <div class="container py-4" style="max-width: 700px;">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white pt-4 px-4 border-0">
                <h3 class="fw-bold mb-0 text-dark">Add New School Class</h3>
            </div>
            <div class="card-body p-4">
                
                {{-- 🔔 Section: Display Validation Errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger border-0">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error) 
                                <li>{{ $error }}</li> 
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('school-classes.store') }}" method="POST">
                    @csrf
                    
                    {{-- Class ID --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Class ID <span class="text-danger">*</span></label>
                        <input type="text" name="class_id" value="{{ old('class_id') }}" class="form-control" placeholder="e.g., 1A" required>
                    </div>

                    {{-- Class Name --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Class Name <span class="text-danger">*</span></label>
                        <input type="text" name="class_name" value="{{ old('class_name') }}" class="form-control" placeholder="e.g., Grade 1A" required>
                    </div>

                    {{-- Grade Level --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Grade Level <span class="text-danger">*</span></label>
                        <select name="level_id" class="form-select" required>
                            <option value="" disabled selected>--- Select Grade ---</option>
                            @foreach($gradeLevels as $level)
                                <option value="{{ $level->level_id }}" {{ old('level_id') == $level->level_id ? 'selected' : '' }}>
                                    {{ $level->level_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Assign Room --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Assign Room</label>
                        <select name="room_id" class="form-select">
                            <option value="" selected>--- Select Room (Optional) ---</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->room_id }}" {{ old('room_id') == $room->room_id ? 'selected' : '' }}>
                                    {{ $room->room_name }} ({{ $room->type }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 💡 Academic Year (ជំនួស Shift ដែលបានលុបចេញ) --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Academic Year <span class="text-danger">*</span></label>
                        <input type="number" name="academic_year" value="{{ old('academic_year', date('Y')) }}" class="form-control" placeholder="e.g., 2026" min="2000" max="2099" required>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('school-classes.index') }}" class="btn btn-outline-secondary">Back</a>
                        <button type="submit" class="btn btn-primary">Save Class</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@include('Admin.include.footer')