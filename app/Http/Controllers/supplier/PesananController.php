<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;

class PesananController extends Controller
{
    public function index()
    {
        $supplierId = Auth::id();

        // Ambil pesanan milik supplier
        $pesanan = Pesanan::where('supplier_id', $supplierId)
            ->with(['items.produk']) // kalau item punya produk
            ->latest()
            ->get();

        return view('supplier.pesanan.index', compact(
            'pesanan'
        ))->with([
            'countBaru'     => $pesanan->where('status', 'baru')->count(),
            'countDiproses' => $pesanan->where('status', 'diproses')->count(),
            'countDikirim'  => $pesanan->where('status', 'dikirim')->count(),
            'countSelesai'  => $pesanan->where('status', 'selesai')->count(),
            'countBatal'    => $pesanan->where('status', 'dibatalkan')->count(),
        ]);
    }

    public function show($id)
    {
        $pesanan = Pesanan::where('supplier_id', Auth::id())
            ->with(['items.produk'])
            ->findOrFail($id);

        return view('supplier.pesanan.show', compact('pesanan'));
    }
}
