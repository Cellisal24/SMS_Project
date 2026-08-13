@include('admin.include.header')

<div class="container my-4" style="max-width: 600px;">
    <h3>Add New Teacher</h3>

    <form action="{{ route('teachers.store') }}" method="POST" class="mt-3" enctype="multipart/form-data">
        @csrf       

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">First Name</label>
                <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" required>
                @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" required>
                @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Gender</label>
            <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                <option value="">Select Gender</option>
                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Contact Number</label>
            <input type="text" name="contact_number" class="form-control @error('contact_number') is-invalid @enderror" value="{{ old('contact_number') }}">
            @error('contact_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
        <label class="form-label" for="photo">រូបថត / Photo</label>
        <input type="file" name="photo" id="photo" class="form-control" accept="image/*">
        @if (isset($teacher) && $teacher->photo)
        <img src="{{ asset('storage/' . $teacher->photo) }}" alt="Current photo" class="mt-2 rounded" style="width:80px;height:80px;object-fit:cover;">
        <p class="text-muted small mt-1">Uploading  a photo</p>
        @endif
    </div>


        <button type="submit" class="btn btn-success">Save Teacher</button>
        <a href="{{ route('teachers.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@include('admin.include.footer')
