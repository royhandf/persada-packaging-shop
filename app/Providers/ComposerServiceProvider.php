<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('layouts.admin', function ($view) {
            if (auth()->check()) {
                $user = auth()->user();

                $notifications = $user->notifications()->latest()->take(10)->get();

                [$unreadNotifications, $readNotifications] = $notifications->partition(function ($notification) {
                    return $notification->unread();
                });

                $view->with([
                    'unreadNotifications' => $unreadNotifications,
                    'readNotifications' => $readNotifications,
                ]);
            } else {
                $view->with(['unreadNotifications' => collect(), 'readNotifications' => collect()]);
            }
        });
    }
}
