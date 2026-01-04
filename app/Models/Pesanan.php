<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';

    protected $fillable = [
        'supplier_id',
        'kode_pesanan',
        'total_harga',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(PesananItem::class);
    }
}
