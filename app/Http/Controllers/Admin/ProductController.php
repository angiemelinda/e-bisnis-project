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

    public function create()
    {
        $categories = Category::where('active', true)->orderBy('name')->get();
        
        // Determine view based on route
        if (request()->routeIs('superadmin.products.create')) {
            $view = 'superadmin.products.create';
        } elseif (request()->routeIs('adminproduk.products.create')) {
            $view = 'adminproduk.products.create';
        } else {
            $view = 'admin.products.create'; // fallback
        }

        return view($view, compact('categories'));
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

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('active', true)->orderBy('name')->get();
        
        // Determine view based on route
        if (request()->routeIs('superadmin.products.edit')) {
            $view = 'superadmin.products.edit';
        } elseif (request()->routeIs('adminproduk.products.edit')) {
            $view = 'adminproduk.products.edit';
        } else {
            $view = 'admin.products.edit'; // fallback
        }

        return view($view, compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'sku' => 'required|string|max:50|unique:products,sku,' . $id,
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'nullable|in:active,inactive',
        ]);

        $data['status'] = $data['status'] ?? 'active';

        $product->update($data);

        // Determine redirect route based on current route
        if (request()->routeIs('superadmin.products.update')) {
            return redirect()->route('superadmin.products')->with('success', 'Produk berhasil diperbarui.');
        } elseif (request()->routeIs('adminproduk.products.update')) {
            return redirect()->route('adminproduk.products')->with('success', 'Produk berhasil diperbarui.');
        } else {
            return redirect()->route('admin.products')->with('success', 'Produk berhasil diperbarui.');
        }
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        // Determine redirect route based on current route
        if (request()->routeIs('superadmin.products.destroy')) {
            return redirect()->route('superadmin.products')->with('success', 'Produk berhasil dihapus.');
        } elseif (request()->routeIs('adminproduk.products.destroy')) {
            return redirect()->route('adminproduk.products')->with('success', 'Produk berhasil dihapus.');
        } else {
            return redirect()->route('admin.products')->with('success', 'Produk berhasil dihapus.');
        }
    }
}