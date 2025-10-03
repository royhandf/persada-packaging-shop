<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => "Pesanan baru #{$this->order->order_number} telah diterima.",
            'icon' => 'heroicon-o-shopping-cart',
            'url' => route('dashboard.orders.show', $this->order->order_number),
        ];
    }
}
