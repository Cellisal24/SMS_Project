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

    .parent-form-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 2rem;
    }

    .parent-form-header {
        margin-bottom: 2.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid var(--neutral-200);
    }

    .parent-form-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--neutral-700);
        margin: 0;
        line-height: 1.2;
    }

    .parent-form-header .subtitle {
        font-size: 0.95rem;
        color: var(--neutral-500);
        margin-top: 0.5rem;
        font-weight: 500;
    }

    .parent-info-badge {
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

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        border: 1.5px solid var(--neutral-300);
        border-radius: 0.5rem;
        background-color: #fff;
        transition: all 0.2s ease;
        font-family: inherit;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        background-color: #fff;
    }

    .form-control::placeholder {
        color: var(--neutral-400);
    }

    .form-control.is-invalid {
        border-color: var(--danger-color);
        background-color: rgba(220, 38, 38, 0.02);
    }

    .form-control.is-invalid:focus {
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

    @media (max-width: 640px) {
        .parent-form-container {
            padding: 1.5rem;
        }

        .parent-form-header h1 {
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

<div class="parent-form-container">
    <div class="parent-form-header">
        <h1>ធ្វើបច្ចុប្បន្នភាពឪពុកម្តាយ</h1>
        <p class="subtitle">Edit parent / guardian information</p>
        <span class="parent-info-badge">ID: {{ $parent->parent_id }}</span>
    </div>

    <form action="{{ route('admin.parents.update', $parent->parent_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">
                នាមខ្លួន
                <span class="lang-note">(First name)</span>
            </label>
            <input
                type="text"
                name="first_name"
                class="form-control @error('first_name') is-invalid @enderror"
                value="{{ old('first_name', $parent->first_name) }}"
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
                value="{{ old('last_name', $parent->last_name) }}"
                required
                maxlength="50"
            >
            @error('last_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">
                លេខទូរស័ព្ទ
                <span class="lang-note">(Phone)</span>
            </label>
            <input
                type="text"
                name="phone"
                class="form-control @error('phone') is-invalid @enderror"
                value="{{ old('phone', $parent->phone) }}"
                maxlength="20"
            >
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">
                អ៊ីមែល
                <span class="lang-note">(Email)</span>
            </label>
            <input
                type="email"
                name="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $parent->email) }}"
                maxlength="100"
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">
                អត្តសញ្ញាណប័ណ្ណ
                <span class="lang-note">(National ID)</span>
            </label>
            <input
                type="text"
                name="national_id"
                class="form-control @error('national_id') is-invalid @enderror"
                value="{{ old('national_id', $parent->national_id) }}"
                maxlength="30"
            >
            @error('national_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        @if ($parent->students->count())
            <div class="form-group">
                <label class="form-label">កូនៗដែលបានភ្ជាប់ <span class="lang-note">(Linked children)</span></label>
                <p class="form-hint">
                    @foreach ($parent->students as $child)
                        {{ $child->fullName() }}{{ $loop->last ? '' : ', ' }}
                    @endforeach
                </p>
            </div>
        @endif

        <div class="btn-group-submit">
            <button type="submit" class="btn btn-success">ធ្វើបច្ចុប្បន្នភាព</button>
            <a href="{{ route('admin.parents.index') }}" class="btn btn-secondary">ត្រឡប់ក្រោយ</a>
        </div>
    </form>
</div>

@include('Admin.include.footer')