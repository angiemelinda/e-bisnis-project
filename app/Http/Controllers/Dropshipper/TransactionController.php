<?php

namespace App\Http\Controllers\Dropshipper;

use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    /**
     * Menampilkan halaman riwayat transaksi
     * Sprint 1: data masih dummy (belum DB)
     */
    public function index()
    {
        return view('dropshipper.transactions');
    }
}
