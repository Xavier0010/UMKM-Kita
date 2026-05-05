<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Store extends Model
{
    protected $fillable = [
        'user_id', 'name', 'slug', 'description', 'logo', 'banner',
        'phone', 'whatsapp', 'address', 'city', 'qris_image',
        'status', 'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Store $store) {
            if (empty($store->slug)) {
                $store->slug = Str::slug($store->name);
            }
        });
    }

    public function user(): BelongsTo    { return $this->belongsTo(User::class); }
    public function products(): HasMany  { return $this->hasMany(Product::class); }
    public function orders(): HasMany    { return $this->hasMany(Order::class); }

    public function isApproved(): bool   { return $this->status === 'approved'; }
    public function isPending(): bool    { return $this->status === 'pending'; }
    public function isRejected(): bool   { return $this->status === 'rejected'; }

    public function getLogoUrlAttribute(): string
    {
        return $this->logo
            ? asset('storage/' . $this->logo)
            : asset('images/default-store.png');
    }

    public function getBannerUrlAttribute(): string
    {
        return $this->banner
            ? asset('storage/' . $this->banner)
            : asset('images/default-banner.jpg');
    }

    public function getWhatsappUrlAttribute(): string
    {
        $number = preg_replace('/[^0-9]/', '', $this->whatsapp);
        if (str_starts_with($number, '0')) {
            $number = '62' . substr($number, 1);
        }
        return 'https://wa.me/' . $number;
    }
}
