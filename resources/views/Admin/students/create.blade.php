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

    .student-form-container {
        max-width: 700px;
        margin: 0 auto;
        padding: 2rem;
    }

    .student-form-header {
        margin-bottom: 2.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid var(--neutral-200);
    }

    .student-form-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--neutral-700);
        margin: 0;
        line-height: 1.2;
    }

    .student-form-header .subtitle {
        font-size: 0.95rem;
        color: var(--neutral-500);
        margin-top: 0.5rem;
        font-weight: 500;
    }

    .form-section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--neutral-700);
        margin: 2rem 0 1rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--neutral-200);
    }

    .form-row {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .form-row .form-group {
        flex: 1;
        min-width: 200px;
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
        background-color: #e4e7ec;
        transition: all 0.2s ease;
        font-family: inherit;
    }

    .form-control:focus,
    .form-select:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        background-color: #f0f2f5;
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

    .form-hint {
        font-size: 0.85rem;
        color: var(--neutral-500);
        margin-top: 0.375rem;
        display: block;
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

    /* Linked parents table */
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

    @media (max-width: 640px) {
        .student-form-container {
            padding: 1.5rem;
        }

        .student-form-header h1 {
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

<div class="student-form-container">
    <div class="student-form-header">
        <h1>បង្កើតសិស្សថ្មី</h1>
        <p class="subtitle">Create a new student</p>
    </div>

    <form action="{{ route('admin.students.store') }}" method="POST">
        @csrf

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
                    value="{{ old('first_name') }}"
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
                    value="{{ old('last_name') }}"
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
                <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                    <option value="">-- ជ្រើសរើសភេទ --</option>
                    <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>ប្រុស (Male)</option>
                    <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>ស្រី (Female)</option>
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
                    value="{{ old('date_of_birth') }}"
                >
                @error('date_of_birth')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
    <label class="form-label">Class</label>
    <select name="class_id" class="form-select @error('class_id') is-invalid @enderror">
        <option value="">-- Select Class --</option>
        @foreach ($rooms as $room)
    <option value="{{ $room->room_id }}" {{ old('class_id') == $room->room_id ? 'selected' : '' }}>
        {{ $room->room_id }}
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
                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>សកម្ម (Active)</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>អសកម្ម (Inactive)</option>
                    <option value="graduated" {{ old('status') == 'graduated' ? 'selected' : '' }}>បញ្ចប់ការសិក្សា (Graduated)</option>
                    <option value="transferred" {{ old('status') == 'transferred' ? 'selected' : '' }}>ផ្ទេរសាលា (Transferred)</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">
                លេខទូរស័ព្ទឪពុកម្តាយ
                <span class="lang-note">(Parent contact phone)</span>
            </label>
            <input
                type="text"
                name="parent_phone"
                class="form-control @error('parent_phone') is-invalid @enderror"
                value="{{ old('parent_phone') }}"
                maxlength="20"
            >
            @error('parent_phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-section-title">ភ្ជាប់ជាមួយឪពុកម្តាយ (Linked Parents)</div>
        <p class="form-hint" style="margin-bottom: 1rem;">ជ្រើសរើសឪពុកម្តាយដែលភ្ជាប់ជាមួយសិស្សនេះ (Select which parents belong to this student)</p>

        <table class="parent-link-table">
            <thead>
                <tr>
                    <th style="width: 36px;"></th>
                    <th>ឈ្មោះ (Name)</th>
                    <th>ទំនាក់ទំនង (Relationship)</th>
                    <th style="width: 90px;">ចម្បង (Primary)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($parents as $parent)
                    <tr>
                        <td>
                            <input type="checkbox" name="parent_ids[]" value="{{ $parent->parent_id }}" {{ in_array($parent->parent_id, old('parent_ids', [])) ? 'checked' : '' }}>
                        </td>
                        <td>{{ $parent->fullName() }} <span class="form-hint" style="display:inline;">({{ $parent->phone }})</span></td>
                        <td>
                            <input type="text" name="relationships[{{ $parent->parent_id }}]" value="{{ old('relationships.' . $parent->parent_id) }}" placeholder="ឧ.ម្តាយ (Mother)">
                        </td>
                        <td style="text-align:center;">
                            <input type="radio" name="primary_parent_id" value="{{ $parent->parent_id }}" {{ old('primary_parent_id') == $parent->parent_id ? 'checked' : '' }}>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center; color: var(--neutral-500); padding: 1rem;">
                            មិនទាន់មានឪពុកម្តាយក្នុងប្រព័ន្ធនៅឡើយទេ។ <a href="{{ route('admin.parents.create') }}">បន្ថែមម្នាក់សិន</a>.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="btn-group-submit">
            <button type="submit" class="btn btn-primary">រក្សាទុក</button>
            <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">បកក្រោយ</a>
        </div>
    </form>
</div>

@include('Admin.include.footer')