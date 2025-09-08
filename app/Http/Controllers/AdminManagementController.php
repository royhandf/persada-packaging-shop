<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AdminManagementController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')->latest()->paginate(10);
        return view('pages.dashboard.admin', compact('admins'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
        ]);

        return redirect()->route('admin.index')->with('success', 'Admin baru berhasil ditambahkan.');
    }

    public function update(Request $request, User $admin)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($admin->id)],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $admin->update($updateData);

        return redirect()->route('admin.index')->with('success', 'Admin berhasil diperbarui.');
    }

    public function destroy(User $admin)
    {
        $admin->delete();
        return redirect()->route('admin.index')->with('success', 'Admin berhasil dihapus.');
    }
}
