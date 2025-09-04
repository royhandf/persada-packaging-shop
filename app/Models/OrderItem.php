<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'order_id',
        'product_variant_id',
        'product_name',
        'variant_name',
        'sku',
        'price_at_purchase',
        'quantity',
        'weight_in_grams'
    ];

    protected function casts(): array
    {
        return ['price_at_purchase' => 'decimal:2'];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
