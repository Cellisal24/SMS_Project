@include('admin.include.header')
<main class="bg-light p-5">
    <div class="container" style="max-width: 600px;">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white pt-4 px-4 border-0">
                <h3 class="fw-bold mb-0 text-dark">បន្ថែមបន្ទប់រៀនថ្មី</h3>
            </div>
            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger border-0">
                        <ul class="mb-0">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
                    </div>
                @endif

                <form action="{{ route('rooms.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">កូដបន្ទប់ (Room ID) <span class="text-danger">*</span></label>
                        <input type="text" name="room_id" value="{{ old('room_id') }}" class="form-control" placeholder="ឧទាហរណ៍៖ RM-101" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">ឈ្មោះបន្ទប់ (Room Name) <span class="text-danger">*</span></label>
                        <input type="text" name="room_name" value="{{ old('room_name') }}" class="form-control" placeholder="ឧទាហរណ៍៖ បន្ទប់រៀនទី១" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">ប្រភេទបន្ទប់ <span class="text-danger">*</span></label>
                        <select name="type" class="form-select" required>
                            <option value="" disabled selected>--- ជ្រើសរើស ---</option>
                            <option value="Theory Class">Theory Class</option>
                            <option value="Laboratory">Laboratory</option>
                            <option value="Meeting Room">Meeting Room</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">ចំណុះសិស្ស (Capacity) <span class="text-danger">*</span></label>
                        <input type="number" name="capacity" value="{{ old('capacity', 30) }}" min="1" class="form-control" required>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary">ត្រឡប់ក្រោយ</a>
                        <button type="submit" class="btn btn-primary">រក្សាទុក</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@include('admin.include.footer')
