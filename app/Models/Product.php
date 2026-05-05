<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'store_id', 'category_id', 'name', 'slug', 'description',
        'price', 'stock', 'main_image', 'gallery', 'is_active',
    ];

    protected $casts = [
        'gallery'   => 'array',
        'is_active' => 'boolean',
        'price'     => 'decimal:2',
    ];

    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $base = Str::slug($product->name);
                $slug = $base;
                $i = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = $base . '-' . $i++;
                }
                $product->slug = $slug;
            }
        });
    }

    public function store(): BelongsTo     { return $this->belongsTo(Store::class); }
    public function category(): BelongsTo  { return $this->belongsTo(Category::class); }
    public function cartItems(): HasMany   { return $this->hasMany(Cart::class); }
    public function orderItems(): HasMany  { return $this->hasMany(OrderItem::class); }

    public function getMainImageUrlAttribute(): string
    {
        return $this->main_image
            ? asset('storage/' . $this->main_image)
            : asset('images/default-product.jpg');
    }

    public function getGalleryUrlsAttribute(): array
    {
        return collect($this->gallery ?? [])
            ->map(fn($img) => asset('storage/' . $img))
            ->toArray();
    }

    public function isInStock(): bool
    {
        return $this->stock > 0;
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }
}
