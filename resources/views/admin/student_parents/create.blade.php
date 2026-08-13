@include('Admin.include.header')

<style>
    :root {
        --primary-color: #2563eb;
        --primary-dark: #1e40af;
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
        background-color: #f7f9fc;
        transition: all 0.2s ease;
        font-family: inherit;
    }

    .form-control:focus,
    .form-select:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        background-color: #8fb5f1;
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

    .btn-primary {
        background-color: var(--primary-color);
        color: white;
        box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
        box-shadow: 0 4px 8px rgba(37, 99, 235, 0.3);
        transform: translateY(-1px);
    }

    .btn-secondary {
        background-color: var(--neutral-200);
        color: var(--neutral-700);
    }

    .btn-secondary:hover {
        background-color: var(--neutral-300);
    }

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

<div class="link-form-container">
    <div class="link-form-header">
        <h1>ភ្ជាប់សិស្ស និងឪពុកម្តាយ</h1>
        <p class="subtitle">Link a student to a parent / guardian</p>
    </div>

    <form action="{{ route('admin.student_parents.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label">
                សិស្ស
                <span class="lang-note">(Student)</span>
            </label>
            <select name="student_id" class="form-select @error('student_id') is-invalid @enderror" required>
                <option value="">-- ជ្រើសរើសសិស្ស --</option>
                @foreach ($students as $student)
                    <option value="{{ $student->student_id }}" {{ old('student_id') == $student->student_id ? 'selected' : '' }}>
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
                    <option value="{{ $parent->parent_id }}" {{ old('parent_id') == $parent->parent_id ? 'selected' : '' }}>
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
                value="{{ old('relationship') }}"
                placeholder="ឧទាហរណ៍៖ ម្តាយ, ឪពុក, អាណាព្យាបាល (Mother, Father, Guardian)"
                maxlength="30"
            >
            @error('relationship')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <div class="form-check">
                <input type="checkbox" name="is_primary" id="is_primary" value="1" {{ old('is_primary') ? 'checked' : '' }}>
                <label class="form-label mb-0" for="is_primary" style="margin-bottom:0;">
                    ជាទំនាក់ទំនងចម្បង
                    <span class="lang-note">(Primary contact)</span>
                </label>
            </div>
            <span class="form-hint">ប្រសិនបើសិស្សនេះមានឪពុកម្តាយច្រើននាក់ បើគូសធីកនេះ វានឹងលុបចោលទំនាក់ទំនងចម្បងចាស់ដោយស្វ័យប្រវត្តិ (Checking this automatically unmarks any other primary contact for this student)</span>
        </div>

        <div class="btn-group-submit">
            <button type="submit" class="btn btn-primary">រក្សាទុក</button>
            <a href="{{ route('admin.student_parents.index') }}" class="btn btn-secondary">បកក្រោយ</a>
        </div>
    </form>
</div>

@include('Admin.include.footer')