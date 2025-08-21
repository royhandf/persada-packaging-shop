<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginIndex()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Logic for handling login
    }

    public function registerIndex()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Logic for handling registration
    }
}