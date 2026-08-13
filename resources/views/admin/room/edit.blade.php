@include('admin.include.header')
<main class="bg-light p-5">
    <div class="container" style="max-width: 600px;">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white pt-4 px-4 border-0">
                <h3 class="fw-bold mb-0 text-dark">កែប្រែព័ត៌មានបន្ទប់</h3>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('rooms.update', $room->room_id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">កូដបន្ទប់ (មិនអាចប្តូរបានទេ)</label>
                        <input type="text" class="form-control bg-light" value="{{ $room->room_id }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">ឈ្មោះបន្ទប់ <span class="text-danger">*</span></label>
                        <input type="text" name="room_name" value="{{ old('room_name', $room->room_name) }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">ប្រភេទបន្ទប់ <span class="text-danger">*</span></label>
                        <select name="type" class="form-select" required>
                            <option value="Theory Class" {{ $room->type == 'Theory Class' ? 'selected' : '' }}>Theory Class</option>
                            <option value="Laboratory" {{ $room->type == 'Laboratory' ? 'selected' : '' }}>Laboratory</option>
                            <option value="Meeting Room" {{ $room->type == 'Meeting Room' ? 'selected' : '' }}>Meeting Room</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">ចំណុះសិស្ស (Capacity) <span class="text-danger">*</span></label>
                        <input type="number" name="capacity" value="{{ old('capacity', $room->capacity) }}" min="1" class="form-control" required>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary">បោះបង់</a>
                        <button type="submit" class="btn btn-primary">ធ្វើបច្ចុប្បន្នភាព</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

@include('admin.include.footer')
