<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'access_token',
        'customer_name',
        'whatsapp',
        'fulfillment_method',
        'payment_provider',
        'payment_account_number',
        'payment_account_name',
        'address',
        'payment_method',
        'status',
        'payment_status',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'total' => 'decimal:2',
        ];
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}