<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentConfirmedNotification extends Notification
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
            'message' => "Pembayaran untuk #{$this->order->order_number} telah dikonfirmasi.",
            'icon' => 'heroicon-o-check-circle',
            'url' => route('dashboard.orders.show', $this->order->order_number),
        ];
    }
}
