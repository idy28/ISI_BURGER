<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'burger_id',
        'burger_name',
        'quantity',
        'unit_price',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function burger()
    {
        return $this->belongsTo(Burger::class);
    }

    public function getSubtotalAttribute(): float
    {
        return $this->quantity * $this->unit_price;
    }

    // French-friendly aliases used by views
    public function getBurgerNomAttribute(): string
    {
        return $this->burger_name;
    }

    public function getPrixUnitaireAttribute(): float
    {
        return (float) $this->unit_price;
    }

    public function getQuantiteAttribute(): int
    {
        return (int) $this->quantity;
    }
}