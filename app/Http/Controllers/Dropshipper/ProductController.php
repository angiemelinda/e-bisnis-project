<?php

namespace App\Http\Controllers\Dropshipper;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan halaman katalog produk
     * Sprint 1: hanya list & filter sederhana
     */
    public function index(Request $request)
    {
        $query = Product::query()
        ->with('category')
        ->where('status', 'active');

        if ($search = $request->string('search')->toString()) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($categoryId = $request->integer('category')) {
            $query->where('category_id', $categoryId);
        }

        if ($min = $request->input('price_min')) {
            $query->where('price', '>=', (float) $min);
        }
        if ($max = $request->input('price_max')) {
            $query->where('price', '<=', (float) $max);
        }
        if ($request->boolean('in_stock')) {
            $query->where('stock', '>', 0);
        }
        switch ($request->input('sort')) {
            case 'termurah':
                $query->orderBy('price', 'asc');
                break;
            case 'terbaru':
                $query->orderBy('created_at', 'desc');
                break;
            case 'terlaris':
                $query->orderBy('stock', 'desc');
                break;
            default:
                $query->orderBy('name', 'asc');
        }

        $products = $query->paginate(12)->withQueryString();
        $topProducts = Product::query()
            ->where('status', 'active')
            ->orderByDesc('stock')
            ->limit(6)
            ->get();
        $categories = Category::orderBy('name')->get();

        return view('dropshipper.catalog', compact('products', 'categories', 'topProducts'));
    }

    /**
     * Menampilkan detail satu produk
     */
    public function show($id)
    {
        /**
         * Cari produk berdasarkan ID
         * firstOrFail → jika tidak ada, otomatis 404
         */
        $product = Product::with('category')
            ->where('status', 'active')
            ->findOrFail($id);

        /**
         * Tampilkan halaman detail produk
         */
        return view('dropshipper.product-show', compact('product'));
    }
}
