<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role', 'customer')
            ->latest()
            ->paginate(10);

        return view('pages.dashboard.customer', compact('customers'));
    }

    public function getDetails(User $customer)
    {
        if ($customer->role !== 'customer') {
            return response()->json(['message' => 'Not Found.'], 404);
        }

        $customer->load(['addresses', 'orders' => function ($query) {
            $query->latest()->take(3);
        }]);

        return response()->json($customer);
    }
}
