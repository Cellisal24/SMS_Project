@include('Admin.include.header')

<style>
    :root {
        --primary-color: #2563eb;
        --primary-light: #3b82f6;
        --success-color: #16a34a;
        --danger-color: #dc2626;
        --neutral-200: #e5e7eb;
        --neutral-300: #d1d5db;
        --neutral-400: #9ca3af;
        --neutral-500: #6b7280;
        --neutral-700: #374151;
    }

    .link-form-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 2rem;
    }

    .link-form-header {
        margin-bottom: 2.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid var(--neutral-200);
    }

    .link-form-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--neutral-700);
        margin: 0;
        line-height: 1.2;
    }

    .link-form-header .subtitle {
        font-size: 0.95rem;
        color: var(--neutral-500);
        margin-top: 0.5rem;
        font-weight: 500;
    }

    .link-info-badge {
        display: inline-block;
        background-color: var(--primary-light);
        color: white;
        padding: 0.375rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 600;
        margin-top: 0.75rem;
    }

    .form-group {
        margin-bottom: 1.75rem;
    }

    .form-group:last-of-type {
        margin-bottom: 2rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        font-size: 0.95rem;
        color: var(--neutral-700);
        margin-bottom: 0.5rem;
        letter-spacing: 0.3px;
    }

    .form-label .lang-note {
        font-size: 0.85rem;
        font-weight: 500;
        color: var(--neutral-500);
        margin-left: 0.5rem;
    }

    .form-control,
    .form-select {
        width: 100%;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        border: 1.5px solid var(--neutral-300);
        border-radius: 0.5rem;
        background-color: #fff;
        transition: all 0.2s ease;
        font-family: inherit;
    }

    .form-control:focus,
    .form-select:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        background-color: #fff;
    }

    .form-select {
        padding: 0.75rem 1rem;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%234b5563' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        padding-right: 2.5rem;
    }

    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: var(--danger-color);
        background-color: rgba(220, 38, 38, 0.02);
    }

    .invalid-feedback {
        display: block;
        font-size: 0.875rem;
        color: var(--danger-color);
        margin-top: 0.375rem;
        font-weight: 500;
    }

    .form-hint {
        font-size: 0.85rem;
        color: var(--neutral-500);
        margin-top: 0.375rem;
        display: block;
    }

    .form-check {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-check input {
        width: 1.1rem;
        height: 1.1rem;
    }

    .btn-group-submit {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn {
        flex: 1;
        padding: 0.875rem 1.5rem;
        font-size: 1rem;
        font-weight: 600;
        border: none;
        border-radius: 0.5rem;
        cursor: pointer;
        transition: all 0.2s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-success {
        background-color: var(--success-color);
        color: white;
        box-shadow: 0 2px 4px rgba(22, 163, 74, 0.2);
    }

    .btn-success:hover {
        background-color: #15803d;
        box-shadow: 0 4px 8px rgba(22, 163, 74, 0.3);
        transform: translateY(-1px);
    }

    .btn-secondary {
        background-color: var(--neutral-200);
        color: var(--neutral-700);
    }

    .btn-secondary:hover {
        background-color: var(--neutral-300);
    }

<<<<<<< HEAD
    .parent-link-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 0.5rem;
    }

    .parent-link-table th {
        text-align: left;
        font-size: 0.85rem;
        color: var(--neutral-500);
        font-weight: 600;
        padding: 0.5rem;
        border-bottom: 1.5px solid var(--neutral-200);
    }

    .parent-link-table td {
        padding: 0.6rem 0.5rem;
        border-bottom: 1px solid var(--neutral-200);
        vertical-align: middle;
    }

    .parent-link-table input[type="text"] {
        padding: 0.4rem 0.6rem;
        font-size: 0.9rem;
        border: 1.5px solid var(--neutral-300);
        border-radius: 0.375rem;
        width: 100%;
    }

=======
>>>>>>> miracle-branch
    @media (max-width: 640px) {
        .link-form-container {
            padding: 1.5rem;
        }

        .link-form-header h1 {
            font-size: 1.5rem;
        }

        .btn-group-submit {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>

<<<<<<< HEAD
@php
    $linkedParentIds = $student->parents->pluck('parent_id')->toArray();
    $primaryParentId = optional($student->parents->firstWhere('pivot.is_primary', true))->parent_id;
    
    // បំលែង Date of birth ឱ្យមានសុវត្ថិភាព
    $dobFormatted = $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('Y-m-d') : '';
@endphp

<div class="student-form-container">
    <div class="student-form-header">
        <h1>ធ្វើបច្ចុប្បន្នភាពសិស្ស</h1>
        <p class="subtitle">Edit student information</p>
        <span class="student-info-badge">ID: {{ $student->student_id }}</span>
=======
<div class="link-form-container">
    <div class="link-form-header">
        <h1>ធ្វើបច្ចុប្បន្នភាពការភ្ជាប់</h1>
        <p class="subtitle">Edit student-parent link</p>
        <span class="link-info-badge">ID: {{ $studentParent->id }}</span>
>>>>>>> miracle-branch
    </div>

    <form action="{{ route('admin.student_parents.update', $studentParent->id) }}" method="POST">
        @csrf
        @method('PUT')

<<<<<<< HEAD
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">
                    នាមខ្លួន
                    <span class="lang-note">(First name)</span>
                </label>
                <input
                    type="text"
                    name="first_name"
                    class="form-control @error('first_name') is-invalid @enderror"
                    value="{{ old('first_name', $student->first_name) }}"
                    required
                    maxlength="50"
                >
                @error('first_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    នាមត្រកូល
                    <span class="lang-note">(Last name)</span>
                </label>
                <input
                    type="text"
                    name="last_name"
                    class="form-control @error('last_name') is-invalid @enderror"
                    value="{{ old('last_name', $student->last_name) }}"
                    required
                    maxlength="50"
                >
                @error('last_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">
                    ភេទ
                    <span class="lang-note">(Gender)</span>
                </label>
                <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                    <option value="">-- ជ្រើសរើសភេទ --</option>
                    <option value="M" {{ old('gender', $student->gender) == 'M' ? 'selected' : '' }}>ប្រុស (Male)</option>
                    <option value="F" {{ old('gender', $student->gender) == 'F' ? 'selected' : '' }}>ស្រី (Female)</option>
                </select>
                @error('gender')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    ថ្ងៃខែឆ្នាំកំណើត
                    <span class="lang-note">(Date of birth)</span>
                </label>
                <input
                    type="date"
                    name="date_of_birth"
                    class="form-control @error('date_of_birth') is-invalid @enderror"
                    value="{{ old('date_of_birth', $dobFormatted) }}"
                    required
                >
                @error('date_of_birth')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">
                    ថ្នាក់រៀន
                    <span class="lang-note">(Class)</span>
                </label>
                <select name="class_id" class="form-select @error('class_id') is-invalid @enderror" required>
                    <option value="">-- ជ្រើសរើសថ្នាក់រៀន --</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->class_id }}" {{ old('class_id', $student->class_id) == $class->class_id ? 'selected' : '' }}>
                            {{ $class->class_name }}
                        </option>
                    @endforeach
                </select>
                @error('class_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    ស្ថានភាព
                    <span class="lang-note">(Status)</span>
                </label>
                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option value="active" {{ old('status', $student->status) == 'active' ? 'selected' : '' }}>សកម្ម (Active)</option>
                    <option value="inactive" {{ old('status', $student->status) == 'inactive' ? 'selected' : '' }}>អសកម្ម (Inactive)</option>
                    <option value="graduated" {{ old('status', $student->status) == 'graduated' ? 'selected' : '' }}>បញ្ចប់ការសិក្សា (Graduated)</option>
                    <option value="transferred" {{ old('status', $student->status) == 'transferred' ? 'selected' : '' }}>ផ្ទេរសាលា (Transferred)</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

=======
>>>>>>> miracle-branch
        <div class="form-group">
            <label class="form-label">
                សិស្ស
                <span class="lang-note">(Student)</span>
            </label>
            <select name="student_id" class="form-select @error('student_id') is-invalid @enderror" required>
                <option value="">-- ជ្រើសរើសសិស្ស --</option>
                @foreach ($students as $student)
                    <option value="{{ $student->student_id }}" {{ old('student_id', $studentParent->student_id) == $student->student_id ? 'selected' : '' }}>
                        {{ $student->fullName() }} ({{ $student->student_id }})
                    </option>
                @endforeach
            </select>
            @error('student_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">
                ឪពុកម្តាយ
                <span class="lang-note">(Parent)</span>
            </label>
            <select name="parent_id" class="form-select @error('parent_id') is-invalid @enderror" required>
                <option value="">-- ជ្រើសរើសឪពុកម្តាយ --</option>
                @foreach ($parents as $parent)
                    <option value="{{ $parent->parent_id }}" {{ old('parent_id', $studentParent->parent_id) == $parent->parent_id ? 'selected' : '' }}>
                        {{ $parent->fullName() }} ({{ $parent->parent_id }})
                    </option>
                @endforeach
            </select>
            @error('parent_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">
                ទំនាក់ទំនង
                <span class="lang-note">(Relationship)</span>
            </label>
            <input
                type="text"
                name="relationship"
                class="form-control @error('relationship') is-invalid @enderror"
                value="{{ old('relationship', $studentParent->relationship) }}"
                placeholder="ឧទាហរណ៍៖ ម្តាយ, ឪពុក, អាណាព្យាបាល (Mother, Father, Guardian)"
                maxlength="30"
            >
            @error('relationship')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <div class="form-check">
                <input type="checkbox" name="is_primary" id="is_primary" value="1" {{ old('is_primary', $studentParent->is_primary) ? 'checked' : '' }}>
                <label class="form-label mb-0" for="is_primary" style="margin-bottom:0;">
                    ជាទំនាក់ទំនងចម្បង
                    <span class="lang-note">(Primary contact)</span>
                </label>
            </div>
            <span class="form-hint">ប្រសិនបើគូសធីកនេះ វានឹងលុបចោលទំនាក់ទំនងចម្បងចាស់ដោយស្វ័យប្រវត្តិ (Checking this automatically unmarks any other primary contact for this student)</span>
        </div>

        <div class="btn-group-submit">
            <button type="submit" class="btn btn-success">ធ្វើបច្ចុប្បន្នភាព</button>
            <a href="{{ route('admin.student_parents.index') }}" class="btn btn-secondary">ត្រឡប់ក្រោយ</a>
        </div>
    </form>
</div>

@include('Admin.include.footer')