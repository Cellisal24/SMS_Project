@include('admin.include.header')

<div class="container my-4" style="max-width: 600px;">
    <h3>Add New Subject</h3>

    <form action="{{ route('admin.subjects.store') }}" method="POST" class="mt-3">
        @csrf

        <div class="mb-3">
            <label class="form-label">Subject ID</label>
            <input type="text" name="subject_id" class="form-control @error('subject_id') is-invalid @enderror" value="{{ old('subject_id') }}" placeholder="e.g., SUB101" required>
            @error('subject_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Subject Name</label>
            <input type="text" name="subject_name" class="form-control @error('subject_name') is-invalid @enderror" value="{{ old('subject_name') }}" required>
            @error('subject_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Department</label>
            <select name="department" class="form-select @error('department') is-invalid @enderror" required>
                <option value="">Select Department</option>
                <option value="Information Technology" {{ old('department') == 'Information Technology' ? 'selected' : '' }}>Information Technology</option>
                <option value="Computer Science" {{ old('department') == 'Computer Science' ? 'selected' : '' }}>Computer Science</option>
                <option value="Software Engineering" {{ old('department') == 'Software Engineering' ? 'selected' : '' }}>Software Engineering</option>
                <option value="Data Science" {{ old('department') == 'Data Science' ? 'selected' : '' }}>Data Science</option>
            </select>
            @error('department') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Credit Hours</label>
            <input type="number" name="credit_hours" min="1" max="6" class="form-control @error('credit_hours') is-invalid @enderror" value="{{ old('credit_hours', 3) }}" required>
            @error('credit_hours') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-success">Save Subject</button>
        <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@include('admin.include.footer')
