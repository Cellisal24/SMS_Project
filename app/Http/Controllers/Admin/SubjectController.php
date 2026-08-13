<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    // 1. បង្ហាញបញ្ជីមុខវិជ្ជា (មានកន្លែង Search & Filter តាមដេប៉ាតឺម៉ង់)
    public function index(Request $request)
    {
        $query = Subject::query();

        // ស្វែងរកតាម ID ឬ ឈ្មោះមុខវិជ្ជា
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('subject_name', 'like', '%' . $request->search . '%')
                  ->orWhere('subject_id', 'like', '%' . $request->search . '%');
            });
        }

        // Filter តាមដេប៉ាតឺម៉ង់
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        $subjects = $query->orderBy('subject_id', 'asc')->paginate(10)->withQueryString();
        
        return view('admin.subject.index', compact('subjects'));
    }

    // 2. បង្ហាញ Form សម្រាប់បង្កើតមុខវិជ្ជាថ្មី
    public function create()
    {
        return view('admin.subject.create');
    }

    // 3. ទទួលទិន្នន័យពី Form រួចរក្សាទុកចូល Database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_id'   => 'required|string|max:10|unique:subjects,subject_id',
            'subject_name' => 'required|string|max:100|unique:subjects,subject_name',
            'department'   => 'nullable|string|max:50',
            'credit_hours' => 'nullable|integer|min:1|max:6',
        ]);

        Subject::create($validated);

        return redirect()->route('admin.subjects.index')->with('success', 'បានបង្កើតមុខវិជ្ជាថ្មីដោយជោគជ័យ!');
    }

    // 4. បង្ហាញ Form កែប្រែទិន្នន័យ (ទាញទិន្នន័យចាស់មកបង្ហាញ)
    public function edit($id)
    {
        $subject = Subject::findOrFail($id); 
        return view('admin.subject.edit', compact('subject'));
    }

    // 5. ធ្វើបច្ចុប្បន្នភាព (Update) ទិន្នន័យដែលបានកែប្រែ
    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'subject_id'   => 'nullable|string|max:10|unique:subjects,subject_id,' . $subject->subject_id . ',subject_id',
            'subject_name' => 'required|string|max:100|unique:subjects,subject_name,' . $subject->subject_id . ',subject_id',
            'department'   => 'nullable|string|max:50',
            'credit_hours' => 'nullable|integer|min:1|max:6',
        ]);

        $validated['subject_id'] = $subject->subject_id;

        $subject->update($validated);

        return redirect()->route('admin.subjects.index')->with('success', 'បានធ្វើបច្ចុប្បន្នភាពមុខវិជ្ជាដោយជោគជ័យ!');
    }

    // 6. លុបមុខវិជ្ជាចេញពី Database
    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('admin.subjects.index')->with('success', 'បានលុបមុខវិជ្ជាចេញដោយជោគជ័យ!');
    }
}


