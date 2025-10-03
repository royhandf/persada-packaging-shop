<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class OrderCancelledNotification extends Notification
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
            'message' => "Pesanan #{$this->order->order_number} dibatalkan. Stok telah dikembalikan.",
            'icon' => 'heroicon-o-x-circle',
            'url' => route('dashboard.orders.show', $this->order->order_number),
        ];
    }
}
