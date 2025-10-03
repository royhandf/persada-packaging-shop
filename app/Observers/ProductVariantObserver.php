<?php

namespace App\Observers;

use App\Models\ProductVariant;
use App\Models\User;
use App\Notifications\ProductLowStockNotification;
use Illuminate\Support\Facades\Notification;

class ProductVariantObserver
{
    public function updated(ProductVariant $productVariant): void
    {
        $lowStockThreshold = 10;

        if ($productVariant->isDirty('stock')) {
            $originalStock = $productVariant->getOriginal('stock');

            if ($originalStock > $lowStockThreshold && $productVariant->stock <= $lowStockThreshold) {
                $admins = User::whereIn('role', ['admin', 'superadmin'])->get();
                if ($admins->isNotEmpty()) {
                    Notification::send($admins, new ProductLowStockNotification($productVariant));
                }
            }
        }
    }
}
