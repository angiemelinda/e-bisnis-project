<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    protected $fillable = [
        'order_id',
        'old_status',
        'new_status',
        'payment_method',
        'notes'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
