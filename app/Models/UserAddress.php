<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'label',
        'receiver_name',
        'phone',
        'street_address',
        'area_id',
        'area_name',
        'latitude',
        'longitude',
        'is_primary'
    ];

    protected function casts(): array
    {
        return ['is_primary' => 'boolean'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
