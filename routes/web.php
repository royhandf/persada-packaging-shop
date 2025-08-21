<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [AuthController::class, 'loginIndex'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'registerIndex'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return '<h1>Selamat Datang, ' . auth()->user()->name . '</h1><form method="POST" action="/logout"><button type="submit">Logout</button></form>';
    })->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});