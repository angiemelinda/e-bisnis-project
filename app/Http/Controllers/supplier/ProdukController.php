<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        return view('supplier.produk.index');
    }

    public function create()
    {
        return view('supplier.produk.create');
    }

    public function edit($id)
    {
        return view('supplier.produk.edit', compact('id'));
    }
}
