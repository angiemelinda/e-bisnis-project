<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Product::where('user_id', auth()->id())->get();
        return view('supplier.produk.index', compact('produks'));
    }

    public function create()
    {
        return view('supplier.produk.create');
    }

    public function edit($id)
    {
        $produk = Product::findOrFail($id);
        return view('supplier.produk.edit', compact('produk'));
    }

    // Bisa tambah store, update, destroy di sini
}
