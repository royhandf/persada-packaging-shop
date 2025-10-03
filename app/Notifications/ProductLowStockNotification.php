<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\ProductVariant;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductLowStockNotification extends Notification
{
    use Queueable;

    protected $variant;

    public function __construct(ProductVariant $variant)
    {
        $this->variant = $variant;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $productName = $this->variant->product ? $this->variant->product->name : 'N/A';

        return [
            'message' => "Stok untuk '{$productName} - {$this->variant->name}' hampir habis (sisa {$this->variant->stock}).",
            'icon' => 'heroicon-o-archive-box-x-mark',
            'url' => route('master.products.detail', $this->variant->product_id),
        ];
    }
}
