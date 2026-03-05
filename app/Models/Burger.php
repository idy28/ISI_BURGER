<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Burger extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'image',
        'stock',
        'available',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'available' => 'boolean',
    ];

    // ── Scopes ──────────────────────────────────────────────

    public function scopeAvailable($query)
    {
        return $query->where('available', true)->where('stock', '>', 0);
    }

    public function scopeFilter($query, $search = null, $minPrice = null, $maxPrice = null)
    {
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }
        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }
        return $query;
    }

    // ── Relationships ───────────────────────────────────────

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // ── Helpers ─────────────────────────────────────────────

    public function isOutOfStock(): bool
    {
        return $this->stock <= 0 || !$this->available;
    }

    public function decreaseStock(int $quantity): void
    {
        $this->decrement('stock', $quantity);

        if ($this->stock <= 0) {
            $this->update(['available' => false]);
        }
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }

        return asset('images/burger-default.png');
    }

    // French-friendly aliases used by client blades
    public function getNomAttribute(): string
    {
        return $this->name;
    }

    public function getPrixAttribute(): float
    {
        return (float) $this->price;
    }

    public function getDisponibleAttribute(): bool
    {
        return (bool) $this->available;
    }
}