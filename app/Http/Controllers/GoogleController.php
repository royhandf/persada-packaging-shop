<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                if (!$user->hasVerifiedEmail()) {
                    $user->markEmailAsVerified();
                }
                Auth::login($user, true);
            } else {
                $newUser = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(Str::random(16)),
                    'role' => 'customer',
                    'email_verified_at' => now(),
                ]);
                Auth::login($newUser, true);
            }

            return view('auth.google_callback');
        } catch (Exception $e) {
            return "<script>window.close(); alert('Login Gagal, silakan coba lagi.');</script>";
        }
    }
}
