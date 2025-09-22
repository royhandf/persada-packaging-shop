<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'product_id',
        'sku',
        'name',
        'price',
        'stock',
        'moq',
        'reserved_stock',
        'weight_in_grams',
        'length_in_cm',
        'width_in_cm',
        'height_in_cm'
    ];

    protected $appends = ['available_stock'];


    protected function casts(): array
    {
        return ['price' => 'decimal:2'];
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getAvailableStockAttribute()
    {
        return $this->stock - $this->reserved_stock;
    }
}