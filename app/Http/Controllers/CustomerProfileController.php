<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use App\Services\BiteshipService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class CustomerProfileController extends Controller
{
    public function index()
    {
        return view('pages.home.profile');
    }

    public function address()
    {
        $addresses = Auth::user()->addresses()->latest()->get();

        return view('pages.home.address', compact('addresses'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($validated);
        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        Auth::user()->update(['password' => Hash::make($validated['password'])]);
        return back()->with('success', 'Password berhasil diperbarui.');
    }

    public function storeAddress(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'receiver_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'street_address' => 'required|string',
            'area_id' => 'required|string',
            'area_name' => 'required|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'is_primary' => 'nullable|boolean',
        ]);


        if ($request->boolean('is_primary')) {
            $user->addresses()->update(['is_primary' => false]);
            $validated['is_primary'] = true;
        }

        $user->addresses()->create($validated);
        return back()->with('success', 'Alamat baru berhasil ditambahkan.');
    }

    public function destroyAddress(UserAddress $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }
        $address->delete();
        return back()->with('success', 'Alamat berhasil dihapus.');
    }

    public function setPrimaryAddress(UserAddress $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $user = Auth::user();
        $user->addresses()->update(['is_primary' => false]);
        $address->update(['is_primary' => true]);
        return back()->with('success', 'Alamat utama berhasil diubah.');
    }

    public function searchLocation(Request $request)
    {
        $request->validate(['q' => 'required|string|min:2']);
        $results = app(BiteshipService::class)->searchAreas($request->q);

        return response()->json($results['areas'] ?? []);
    }
}
