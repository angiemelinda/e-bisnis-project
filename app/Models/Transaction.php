<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'order_id',
        'payment_id',
        'midtrans_order_id',
        'transaction_id',
        'amount',
        'payment_type',
        'status',
        'raw_response',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'raw_response' => 'array',
        'amount' => 'float',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
