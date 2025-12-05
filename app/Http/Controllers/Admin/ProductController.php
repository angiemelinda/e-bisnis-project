<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->orderByDesc('id')->paginate(10);
        $categories = Category::where('active', true)->orderBy('name')->get();

        $summary = [
            'total' => Product::count(),
            'low_stock' => Product::where('stock', '<', 10)->count(),
            'inactive' => Product::where('status', 'inactive')->count(),
        ];

        // Determine view based on route
        if (request()->routeIs('superadmin.products')) {
            $view = 'superadmin.products';
        } elseif (request()->routeIs('adminproduk.products')) {
            $view = 'adminproduk.products';
        } else {
            $view = 'admin.products'; // fallback
        }

        return view($view, compact('products', 'categories', 'summary'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sku' => 'required|string|max:50|unique:products,sku',
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'nullable|in:active,inactive',
        ]);

        $data['status'] = $data['status'] ?? 'active';

        Product::create($data);

        // Determine redirect route based on current route
        if (request()->routeIs('superadmin.products.store')) {
            return redirect()->route('superadmin.products')->with('success', 'Produk berhasil ditambahkan.');
        } elseif (request()->routeIs('adminproduk.products.store')) {
            return redirect()->route('adminproduk.products')->with('success', 'Produk berhasil ditambahkan.');
        } else {
            return redirect()->route('admin.products')->with('success', 'Produk berhasil ditambahkan.');
        }
    }
}