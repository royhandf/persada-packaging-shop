<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'order_number',
        'user_id',
        'shipping_address',
        'shipping_courier',
        'shipping_service',
        'shipping_tracking_number',
        'subtotal',
        'shipping_cost',
        'discount',
        'grand_total',
        'payment_method',
        'payment_gateway_id',
        'paid_at',
        'note'
    ];

    protected function casts(): array
    {
        return [
            'shipping_address' => 'json',
            'subtotal' => 'decimal:2',
            'shipping_cost' => 'decimal:2',
            'discount' => 'decimal:2',
            'grand_total' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
