<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function read(DatabaseNotification $notification)
    {
        if ($notification->notifiable_id === auth()->id()) {
            $notification->markAsRead();
            return redirect($notification->data['url'] ?? route('dashboard'));
        }
        abort(403);
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    }
}
