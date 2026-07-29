<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParentModel;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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

    if ($request->hasFile('photo')) {
        $validated['photo'] = $request->file('photo')->store('photos/parents', 'public');
    }

    $parent = ParentModel::create($validated);

    $account = $this->createLoginAccount($parent);

    $response = redirect()
        ->route('admin.parents.index', $parent)
        ->with('success', "Parent {$parent->fullName()} created successfully.");

    if ($account['created']) {
        $response->with('reset_credentials', [
            'name' => $parent->fullName(),
            'username' => $account['user']->username,
            'password' => $account['plainPassword'],
        ]);
    }

    return $response;
}
private function validateParent(Request $request): array
{
     return $request->validate([
        'first_name'  => ['required', 'string', 'max:50'],
        'last_name'   => ['required', 'string', 'max:50'],
        'phone'       => ['nullable', 'string', 'max:20'],
        'email'       => ['nullable', 'email', 'max:100'],
        'national_id' => ['nullable', 'string', 'max:30'],
        'photo'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
    ]);
}
   

    public function edit(ParentModel $parent)
    {
        return view('admin.parents.edit', compact('parent'));
    }

   public function update(Request $request, ParentModel $parent)
{
    $validated = $this->validateParent($request);

    if ($request->hasFile('photo')) {
        if ($parent->photo) {
            Storage::disk('public')->delete($parent->photo);
        }
        $validated['photo'] = $request->file('photo')->store('photos/parents', 'public');
    }

    $parent->update($validated);

    return redirect()->route('admin.parents.index', $parent)->with('success', "Parent {$parent->fullName()} updated successfully.");
}

    public function destroy(ParentModel $parent)
    {
        $name = $parent->fullName();
        $parent->delete();

        return redirect()
            ->route('admin.parents.index')
            ->with('success', "Parent {$name} deleted successfully.");
    }

   private function createLoginAccount(ParentModel $parent): array
{
    $existing = User::where('parent_id', $parent->parent_id)->first();

    if ($existing) {
        return ['user' => $existing, 'created' => false, 'plainPassword' => null];
    }

    $plainPassword = Str::password(10, symbols: false);

    $user = User::create([
        'username' => strtolower($parent->parent_id),
        'password_hash' => Hash::make($plainPassword),
        'parent_id' => $parent->parent_id,
        'role' => 'parent',
    ]);

    return ['user' => $user, 'created' => true, 'plainPassword' => $plainPassword];
}
public function resetPassword(ParentModel $parent)
{
    $user = User::where('parent_id', $parent->parent_id)->first();

    if (! $user) {
        return back()->with('error', "No login account exists yet for {$parent->fullName()}.");
    }

    $plainPassword = Str::password(10, symbols: false);
    $user->update(['password_hash' => Hash::make($plainPassword)]);

    return back()->with('reset_credentials', [
        'name' => $parent->fullName(),
        'username' => $user->username,
        'password' => $plainPassword,
    ]);
}
 }
