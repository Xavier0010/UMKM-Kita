<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'store_id', 'order_number', 'status',
        'payment_method', 'payment_proof', 'total_amount',
        'shipping_name', 'shipping_phone', 'shipping_address', 'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    const STATUS_LABELS = [
        'pending'    => 'Menunggu Konfirmasi',
        'confirmed'  => 'Dikonfirmasi',
        'processing' => 'Sedang Diproses',
        'shipped'    => 'Sedang Dikirim',
        'completed'  => 'Selesai',
        'cancelled'  => 'Dibatalkan',
    ];

    const STATUS_COLORS = [
        'pending'    => 'amber',
        'confirmed'  => 'blue',
        'processing' => 'violet',
        'shipped'    => 'indigo',
        'completed'  => 'emerald',
        'cancelled'  => 'red',
    ];

    public function user(): BelongsTo    { return $this->belongsTo(User::class); }
    public function store(): BelongsTo   { return $this->belongsTo(Store::class); }
    public function items(): HasMany     { return $this->hasMany(OrderItem::class); }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        return self::STATUS_COLORS[$this->status] ?? 'gray';
    }

    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total_amount, 0, ',', '.');
    }
}
