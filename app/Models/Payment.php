<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'midtrans_order_id',
        'status',
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
