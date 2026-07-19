@include('Admin.include.header')

<style>
    :root {
        --primary-color: #2563eb;
        --primary-light: #3b82f6;
        --primary-dark: #1e40af;
        --success-color: #16a34a;
        --danger-color: #dc2626;
        --warning-color: #f59e0b;
        --neutral-50: #f9fafb;
        --neutral-100: #f3f4f6;
        --neutral-200: #e5e7eb;
        --neutral-300: #d1d5db;
        --neutral-400: #9ca3af;
        --neutral-500: #6b7280;
        --neutral-600: #4b5563;
        --neutral-700: #374151;
    }

    .subject-form-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 2rem;
    }

    .subject-form-header {
        margin-bottom: 2.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid var(--neutral-200);
    }

    .subject-form-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--neutral-700);
        margin: 0;
        line-height: 1.2;
    }

    .subject-form-header .subtitle {
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
        background-color: #374151;
        transition: all 0.2s ease;
        font-family: inherit;
    }

    .form-control:focus,
    .form-select:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        background-color: #374151;
    }

    .form-control::placeholder {
        color: var(--neutral-400);
    }

    .form-select {
        padding: 0.75rem 1rem;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%234b5563' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        padding-right: 2.5rem;
    }

    /* Form validation styling */
    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: var(--danger-color);
        background-color: rgba(220, 38, 38, 0.02);
    }

    .form-control.is-invalid:focus,
    .form-select.is-invalid:focus {
        border-color: var(--danger-color);
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
    }

    .invalid-feedback {
        display: block;
        font-size: 0.875rem;
        color: var(--danger-color);
        margin-top: 0.375rem;
        font-weight: 500;
    }

    /* Button styling */
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

    .btn-primary:active {
        transform: translateY(0);
        box-shadow: 0 1px 2px rgba(37, 99, 235, 0.2);
    }

    .btn-secondary {
        background-color: var(--neutral-200);
        color: var(--neutral-700);
    }

    .btn-secondary:hover {
        background-color: var(--neutral-300);
    }

    /* Input number styling */
    input[type="number"] {
        padding-right: 0.5rem;
    }

    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }

    /* Hint text */
    .form-hint {
        font-size: 0.85rem;
        color: var(--neutral-500);
        margin-top: 0.375rem;
        display: block;
    }

    /* Responsive */
    @media (max-width: 640px) {
        .subject-form-container {
            padding: 1.5rem;
        }

        .subject-form-header h1 {
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

<div class="subject-form-container">
    <div class="subject-form-header">
        <h1>បង្កើតមុខវិជ្ជាថ្មី</h1>
        <p class="subtitle">Create a new academic subject</p>
    </div>

    <form action="{{ route('admin.subjects.store') }}" method="POST">
        @csrf

        <!-- Subject ID -->
        <div class="form-group">
            <label class="form-label">
                កូដមុខវិជ្ជា
                <span class="lang-note">(Subject ID)</span>
            </label>
            <input 
                type="text" 
                name="subject_id" 
                class="form-control @error('subject_id') is-invalid @enderror" 
                value="{{ old('subject_id') }}" 
                placeholder="ឧទាហរណ៍៖ SUB101"
                required
            >
            <span class="form-hint">ប្រើលេខឬអក្សរ (alphanumeric)</span>
            @error('subject_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Subject Name -->
        <div class="form-group">
            <label class="form-label">
                ឈ្មោះមុខវិជ្ជា
                <span class="lang-note">(Subject Name)</span>
            </label>
            <input 
                type="text" 
                name="subject_name" 
                class="form-control @error('subject_name') is-invalid @enderror" 
                value="{{ old('subject_name') }}"
                placeholder="ឧទាហរណ៍៖ Programming"
                required
            >
            @error('subject_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Department -->
        <div class="form-group">
            <label class="form-label">
                ដេប៉ាតឺម៉ង់
                <span class="lang-note">(Department)</span>
            </label>
            <select 
                name="department" 
                class="form-select @error('department') is-invalid @enderror"
                required
            >
                <option value="">-- ជ្រើសរើសដេប៉ាតឺម៉ង់ --</option>
                <option value="Information Technology" {{ old('department') == 'Information Technology' ? 'selected' : '' }}>
                    Information Technology
                </option>
                <option value="Computer Science" {{ old('department') == 'Computer Science' ? 'selected' : '' }}>
                    Computer Science
                </option>
                <option value="Software Engineering" {{ old('department') == 'Software Engineering' ? 'selected' : '' }}>
                    Software Engineering
                </option>
                <option value="Data Science" {{ old('department') == 'Data Science' ? 'selected' : '' }}>
                    Data Science
                </option>
            </select>
            @error('department')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Credit Hours -->
        <div class="form-group">
            <label class="form-label">
                ចំនួនក្រេឌីត
                <span class="lang-note">(Credit Hours)</span>
            </label>
            <input 
                type="number" 
                name="credit_hours" 
                min="1" 
                max="6" 
                class="form-control @error('credit_hours') is-invalid @enderror" 
                value="{{ old('credit_hours', 3) }}"
                required
            >
            <span class="form-hint">ចាប់ពី ១ ដល់ ៦ ក្រេឌីត (1 to 6 credits)</span>
            @error('credit_hours')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Action Buttons -->
        <div class="btn-group-submit">
            <button type="submit" class="btn btn-primary">រក្សាទុក</button>
            <a href="{{ route('admin.subjects.index') }}" class="btn btn-secondary">បកក្រោយ</a>
        </div>
    </form>
</div>

@include('Admin.include.footer')