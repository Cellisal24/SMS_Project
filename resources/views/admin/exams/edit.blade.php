@include('admin.include.header')

<style>
    .form-container { max-width: 700px; margin: 0 auto; padding: 2rem; }
    .form-header { margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 2px solid #e5e7eb; }
    .form-row { display: flex; gap: 1rem; flex-wrap: wrap; }
    .form-row .form-group { flex: 1; min-width: 200px; }
    .form-group { margin-bottom: 1.25rem; }
    .form-label { display: block; font-weight: 600; font-size: 0.95rem; margin-bottom: 0.4rem; }
    .form-control, .form-select { width: 100%; padding: 0.75rem 1rem; border: 1.5px solid #d1d5db; border-radius: 0.5rem; box-sizing: border-box; }
    .btn-group { display: flex; gap: 1rem; margin-top: 2rem; }
    .btn { flex: 1; padding: 0.75rem; font-weight: 600; border-radius: 0.5rem; border: none; cursor: pointer; text-align: center; text-decoration: none; }
    .btn-primary { background-color: #2563eb; color: white; }
    .btn-secondary { background-color: #e5e7eb; color: #374151; }
</style>

<div class="form-container">
    <div class="form-header">
        <h1>កែប្រែការប្រឡង #{{ $exam->exam_id }}</h1>
    </div>

    <form action="{{ route('admin.exams.update', $exam->exam_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">មុខវិជ្ជា *</label>
                <select name="subject_id" class="form-select" required>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->subject_id }}" {{ $exam->subject_id == $subject->subject_id ? 'selected' : '' }}>{{ $subject->subject_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">ថ្នាក់រៀន</label>
                <select name="class_id" class="form-select">
                    @foreach($classes as $class)
                        <option value="{{ $class->class_id }}" {{ $exam->class_id == $class->class_id ? 'selected' : '' }}>{{ $class->class_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">បន្ទប់ប្រឡង</label>
                <select name="room_id" class="form-select">
                    @foreach($rooms as $room)
                        <option value="{{ $room->room_id }}" {{ $exam->room_id == $room->room_id ? 'selected' : '' }}>{{ $room->room_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">ឆមាស</label>
                <input type="text" name="semester" class="form-control" value="{{ $exam->semester }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">ថ្ងៃប្រឡង *</label>
                <input type="date" name="exam_date" class="form-control" value="{{ $exam->exam_date }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">ឆ្នាំសិក្សា</label>
                <input type="number" name="academic_year" class="form-control" value="{{ $exam->academic_year }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">ម៉ោងចាប់ផ្តើម</label>
                <input type="time" name="start_time" class="form-control" value="{{ $exam->start_time }}">
            </div>
            <div class="form-group">
                <label class="form-label">ម៉ោងបញ្ចប់</label>
                <input type="time" name="end_time" class="form-control" value="{{ $exam->end_time }}">
            </div>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-primary">ធ្វើបច្ចុប្បន្នភាព</button>
            <a href="{{ route('admin.exams.index') }}" class="btn btn-secondary">ត្រឡប់ក្រោយ</a>
        </div>
    </form>
</div>

@include('admin.include.footer')
