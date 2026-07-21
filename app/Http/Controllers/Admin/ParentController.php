<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParentModel;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    public function index(Request $request)
    {
        $query = ParentModel::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $parents = $query->withCount('students')->orderBy('last_name')->paginate(15)->withQueryString();

        return view('admin.parents.index', compact('parents'));
    }

    public function create()
    {
        return view('admin.parents.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateParent($request);

        $parent = ParentModel::create($validated);

        return redirect()
            ->route('admin.parents.index', $parent)
            ->with('success', "Parent {$parent->fullName()} created successfully.");
    }

   

    public function edit(ParentModel $parent)
    {
        return view('admin.parents.edit', compact('parent'));
    }

    public function update(Request $request, ParentModel $parent)
    {
        $validated = $this->validateParent($request);

        $parent->update($validated);

        return redirect()
            ->route('admin.parents.index', $parent)
            ->with('success', "Parent {$parent->fullName()} updated successfully.");
    }

    public function destroy(ParentModel $parent)
    {
        $name = $parent->fullName();
        $parent->delete();

        return redirect()
            ->route('admin.parents.index')
            ->with('success', "Parent {$name} deleted successfully.");
    }

    private function validateParent(Request $request): array
    {
        return $request->validate([
            'first_name'  => ['required', 'string', 'max:50'],
            'last_name'   => ['required', 'string', 'max:50'],
            'phone'       => ['nullable', 'string', 'max:20'],
            'email'       => ['nullable', 'email', 'max:100'],
            'national_id' => ['nullable', 'string', 'max:30'],
        ]);
    }
}