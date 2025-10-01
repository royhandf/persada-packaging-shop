<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use App\Http\Controllers\Controller;

class AdminManagementController extends Controller
{
    public function index()
    {
        $teams = User::where('role', 'admin')->latest()->paginate(10);
        return view('pages.dashboard.team', compact('teams'));
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

        return redirect()->route('teams.index')->with('success', 'Admin baru berhasil ditambahkan.');
    }

    public function update(Request $request, User $team)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($team->id)],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $team->update($updateData);

        return redirect()->route('teams.index')->with('success', 'Admin berhasil diperbarui.');
    }

    public function destroy(User $team)
    {
        $team->delete();
        return redirect()->route('teams.index')->with('success', 'Admin berhasil dihapus.');
    }
}
