<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GradeLevel;
use Illuminate\Http\Request;

class GradeLevelController extends Controller
{
    public function index(Request $request)
    {
        $gradeLevelsQuery = GradeLevel::orderBy('sort_order');

        if ($request->filled('search')) {
            $search = $request->search;
            $gradeLevelsQuery->where(function ($query) use ($search) {
                $query->where('level_name', 'like', "%{$search}%")
                      ->orWhere('stage', 'like', "%{$search}%");

            });
        }

        if ($request->filled('stage')) {
            $gradeLevelsQuery->where('stage', $request->stage);
            
        }

        $gradeLevels = $gradeLevelsQuery->paginate(10)->withQueryString();
        $stageOptions = GradeLevel::select('stage')->distinct()->orderBy('stage')->pluck('stage');

        return view('admin.grade-levels.index', compact('gradeLevels', 'stageOptions'));
    }

    public function create()
    {
        return view('admin.grade-levels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
           'level_name' => 'required|string|max:30|unique:grade_levels,level_name',
           'stage'      => 'required|string|max:20',
           'sort_order' => 'required|integer',
        ]);

        GradeLevel::create($request->all());

        return redirect()->route('grade-levels.index')->with('success', 'បង្កើតថ្មីជោគជ័យ!');
    }

    public function edit(GradeLevel $gradeLevel)
    {
        return view('admin.grade-levels.edit', compact('gradeLevel'));
    }

    public function update(Request $request, GradeLevel $gradeLevel)
    {
        $request->validate([
           'level_name' => 'required|string|max:30|unique:grade_levels,level_name,'.$gradeLevel->level_id.',level_id',
           'stage'      => 'required|string|max:20',
           'sort_order' => 'required|integer',
        ]);

        $gradeLevel->update($request->all());

        return redirect()->route('grade-levels.index')->with('success', 'កែប្រែទិន្នន័យជោគជ័យ!');
    }

    public function destroy(GradeLevel $gradeLevel)
    {
        $gradeLevel->delete();

        return redirect()->route('grade-levels.index')->with('success', 'លុបទិន្នន័យជោគជ័យ!');
    }
}