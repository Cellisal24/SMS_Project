@include('admin.include.header')
<div class="container my-4" style="max-width: 700px;">
    <h3>Teacher Details</h3>

    <div class="card mt-3">
        <div class="card-body">
            <p><strong>Teacher ID:</strong> {{ $teacher->teacher_id }}</p>
            <p><strong>Name:</strong> {{ $teacher->first_name }} {{ $teacher->last_name }}</p>
            <p><strong>Gender:</strong> {{ $teacher->gender }}</p>
            <p><strong>Email:</strong> {{ $teacher->email }}</p>
            <p><strong>Contact Number:</strong> {{ $teacher->contact_number ?? 'N/A' }}</p>
        </div>
    </div>

    <a href="{{ route('teachers.index') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@include('admin.include.footer')

