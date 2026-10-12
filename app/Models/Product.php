<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'image_url',
        'stock',
        'discount_percentage',
        'discount_active',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'discount_percentage' => 'decimal:2',
            'discount_active' => 'boolean',
            'stock' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function getDiscountedPriceAttribute(): float
    {
        if (! $this->discount_active || $this->discount_percentage <= 0) {
            return (float) $this->price;
        }

        return (float) $this->price
            * (1 - (float) $this->discount_percentage / 100);
    }
}
