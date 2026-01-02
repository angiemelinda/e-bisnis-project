<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Payment;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_code',
        'total',
        'margin',
        'status',
        'payment_status',
        'courier',
        'resi',
        'snap_token',
    ];


    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Transactions history for this order
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

}
