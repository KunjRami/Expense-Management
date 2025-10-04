<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {
        $company = auth()->user()->company;
        $users = User::where('company_id', $company->id)->with('manager')->paginate(10);
        
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $company = auth()->user()->company;
        $managers = User::where('company_id', $company->id)
            ->whereIn('role', ['Admin', 'Manager'])
            ->get();
        
        return view('admin.users.create', compact('managers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:Admin,Manager,Employee'],
            'manager_id' => ['nullable', 'exists:users,id'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'manager_id' => $request->manager_id,
            'company_id' => auth()->user()->company_id,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $company = auth()->user()->company;
        
        if ($user->company_id !== $company->id) {
            abort(403);
        }
        
        $managers = User::where('company_id', $company->id)
            ->whereIn('role', ['Admin', 'Manager'])
            ->where('id', '!=', $user->id)
            ->get();
        
        return view('admin.users.edit', compact('user', 'managers'));
    }

    public function update(Request $request, User $user)
    {
        $company = auth()->user()->company;
        
        if ($user->company_id !== $company->id) {
            abort(403);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:Admin,Manager,Employee'],
            'manager_id' => ['nullable', 'exists:users,id'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'manager_id' => $request->manager_id,
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $company = auth()->user()->company;
        
        if ($user->company_id !== $company->id || $user->id === auth()->id()) {
            abort(403);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
