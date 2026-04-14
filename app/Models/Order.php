<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'En attente';
    const STATUS_PREPARING = 'En preparation';
    const STATUS_READY = 'Prete';
    const STATUS_PAID = 'Payee';

    protected $fillable = [
        'customer_name',
        'customer_phone',
        'status',
        'total_amount',
        'amount_paid',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
    ];

    // Mapping between UI slugs and stored status labels
    public static array $statusMap = [
        'en_attente' => 'En attente',
        'en_preparation' => 'En preparation',
        'prete' => 'Prete',
        'payee' => 'Payee',
    ];

    // ── Relationships ───────────────────────────────────────

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // ── Helpers ─────────────────────────────────────────────

    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }

    public function isReady(): bool
    {
        return $this->status === self::STATUS_READY || $this->status === self::STATUS_PAID;
    }

    public function canBePaid(): bool
    {
        return $this->status === self::STATUS_READY && !$this->payment;
    }

    public function calculateTotal(): float
    {
        return $this->items->sum(fn($item) => $item->unit_price * $item->quantity);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'En attente',
            self::STATUS_PREPARING => 'En preparation',
            self::STATUS_READY => 'Prete',
            self::STATUS_PAID => 'Payee',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'warning',
            self::STATUS_PREPARING => 'info',
            self::STATUS_READY => 'success',
            self::STATUS_PAID => 'purple',
            default => 'secondary',
        };
    }

    public function getStatusIconAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_PENDING => '⏳',
            self::STATUS_PREPARING => '👨‍🍳',
            self::STATUS_READY => '✅',
            self::STATUS_PAID => '💵',
            default => '❓',
        };
    }

    public static function nextStatuses(): array
    {
        return [
            self::STATUS_PENDING => self::STATUS_PREPARING,
            self::STATUS_PREPARING => self::STATUS_READY,
            self::STATUS_READY => self::STATUS_PAID,
        ];
    }

    // --- French-friendly attribute aliases used by the blades ---
    public function getNomClientAttribute(): string
    {
        return $this->customer_name;
    }

    public function getTelephoneClientAttribute(): string
    {
        return $this->customer_phone;
    }

    public function getTotalAttribute(): float
    {
        return (float) $this->total_amount;
    }

    public function getPaiementAttribute()
    {
        return $this->payment;
    }

    // Return slug used in UI (ex: 'en_attente')
    public function getStatutAttribute(): string
    {
        return self::labelToSlug($this->attributes['status'] ?? $this->status);
    }

    public static function slugToLabel(string $slug): string
    {
        return self::$statusMap[$slug] ?? $slug;
    }

    public static function labelToSlug(?string $label): string
    {
        if (is_null($label)) {
            return ''; // ou 'inconnu', ou un slug par défaut
        }

        $flip = array_flip(self::$statusMap);
        return $flip[$label] ?? $label;
    }
}