<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'amount',
        'amount_paid',
        'payment_method',
        'payment_date',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'payment_date' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // French-friendly aliases
    public function getMontantAttribute(): float
    {
        return (float) $this->amount;
    }

    public function getCommandeAttribute()
    {
        return $this->order;
    }
}