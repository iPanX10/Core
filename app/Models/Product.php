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
        $price = max(0, (float) $this->price);
        $discount = (float) $this->discount_percentage;

        if (! $this->discount_active || $discount <= 0) {
            return round($price, 2);
        }

        // Batasi diskon agar tidak melebihi 100%.
        $discount = min($discount, 100);

        return round(
            $price * (1 - $discount / 100),
            2
        );
    }
}