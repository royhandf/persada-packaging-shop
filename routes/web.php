<?php

use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AppController::class, 'index'])->name('home');
Route::get('about', [AppController::class, 'about'])->name('about');

Route::get('login', [AuthController::class, 'loginIndex'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'registerIndex'])->name('register');
Route::post('register', [AuthController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('role:customer')->group(function () {
        Route::get('products', [AppController::class, 'products'])->name('products.index');
        Route::get('products/{product}', [AppController::class, 'productDetail'])->name('products.detail');

        Route::get('cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('cart', [CartController::class, 'store'])->name('cart.store');
        Route::post('cart/{cartItem}/update', [CartController::class, 'update'])->name('cart.update');
        Route::delete('cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
        Route::post('cart/update-selection', [CartController::class, 'updateSelection'])->name('cart.update-selection');

        Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');
        Route::post('checkout/calculate-shipping', [CheckoutController::class, 'calculateShipping'])->name('checkout.calculate-shipping');

        Route::get('orders/{order:order_number}', [OrderController::class, 'orderDetail'])->name('order.detail');

        Route::prefix('profile')->name('customer.profile.')->group(function () {
            Route::get('/', [CustomerProfileController::class, 'index'])->name('index');
            Route::patch('update', [CustomerProfileController::class, 'updateProfile'])->name('update');
            Route::put('password', [CustomerProfileController::class, 'updatePassword'])->name('password.update');

            Route::get('addresses', [CustomerProfileController::class, 'address'])->name('address.index');
            Route::post('addresses', [CustomerProfileController::class, 'storeAddress'])->name('address.store');
            Route::delete('addresses/{address}', [CustomerProfileController::class, 'destroyAddress'])->name('address.destroy');
            Route::patch('addresses/{address}/set-primary', [CustomerProfileController::class, 'setPrimaryAddress'])->name('address.setPrimary');
            Route::get('search-location', [CustomerProfileController::class, 'searchLocation'])->name('search-location');
        });
    });

    Route::prefix('dashboard')->group(function () {

        // --- RUTE UNTUK ADMIN & SUPERADMIN ---
        Route::middleware('role:admin,superadmin')->group(function () {
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
            Route::get('profile', [ProfileController::class, 'index'])->name('profile');
            Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

            // [DIKEMBALIKAN] Grup Manajemen Toko
            Route::prefix('penjualan')->name('penjualan.')->group(function () {
                Route::get('/pesanan', function () {
                    return 'Halaman Daftar Pesanan';
                })->name('pesanan.index');
                Route::get('/pembayaran', function () {
                    return 'Halaman Log Pembayaran';
                })->name('pembayaran.index');
            });

            // Grup Data Master
            Route::prefix('master')->name('master.')->group(function () {
                Route::resource('categories', CategoryController::class)->except(['create', 'edit', 'show']);
                Route::resource('products', ProductController::class)->except(['create', 'edit', 'show']);

                Route::prefix('products/{product}')->name('products.')->group(function () {
                    Route::get('detail', [ProductController::class, 'detail'])->name('detail');
                    Route::post('variants', [ProductVariantController::class, 'store'])->name('variants.store');
                    Route::put('variants/{variant}', [ProductVariantController::class, 'update'])->name('variants.update');
                    Route::delete('variants/{variant}', [ProductVariantController::class, 'destroy'])->name('variants.destroy');

                    Route::post('images', [ProductImageController::class, 'store'])->name('images.store');
                    Route::delete('images/{image}', [ProductImageController::class, 'destroy'])->name('images.destroy');
                });
            });
        });

        // --- RUTE HANYA UNTUK SUPERADMIN ---
        Route::middleware('role:superadmin')->group(function () {
            // [DIKEMBALIKAN] Grup Laporan
            Route::prefix('laporan')->name('laporan.')->group(function () {
                Route::get('/penjualan', function () {
                    return 'Halaman Laporan Penjualan';
                })->name('penjualan.index');
                Route::get('/pelanggan', function () {
                    return 'Halaman Laporan Pelanggan';
                })->name('pelanggan.index');
            });

            Route::resource('teams', AdminManagementController::class)->except(['create', 'edit', 'show']);
            Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
            Route::post('settings', [SettingController::class, 'update'])->name('settings.update');
            Route::get('settings/search-location', [SettingController::class, 'searchSenderLocation'])->name('settings.search-location');
        });
    });
});
