<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function dashboard()
    {
        // Data dashboard
        return view('supplier.dashboard');
    }

    public function profile()
    {
        return view('supplier.profile');
    }

    public function pengaturan()
    {
        return view('supplier.pengaturan');
    }
}
