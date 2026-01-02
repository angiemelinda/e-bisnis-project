<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'amount',
        'status',
        'payment_method',
        'payment_reference',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Transaction history (one payment can generate multiple transactions)
     */
    public function transactions()
    {
        return $this->hasMany(\App\Models\Transaction::class);
    }
}
