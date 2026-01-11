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
            ->with(['category', 'primaryImage'])
            ->where('status', 'active');

        // Search filter
        if ($search = $request->string('search')->toString()) {
            $query->where('name', 'like', "%{$search}%");
        }

        // Category filter - support multiple categories
        if ($categories = $request->input('categories')) {
            $categoryArray = is_array($categories) ? $categories : explode(',', $categories);
            $categoryArray = array_filter($categoryArray);
            if (!empty($categoryArray)) {
                $query->whereIn('category_id', $categoryArray);
            }
        }

        // Price filter
        if ($min = $request->input('price_min')) {
            $query->where('price', '>=', (float) $min);
        }
        if ($max = $request->input('price_max')) {
            $query->where('price', '<=', (float) $max);
        }

        // Stock filter
        if ($request->boolean('in_stock')) {
            $query->where('stock', '>', 0);
        }

        // Sort
        $sort = $request->input('sort', '');
        switch ($sort) {
            case 'termurah':
                $query->orderBy('price', 'asc');
                break;
            case 'termahal':
                $query->orderBy('price', 'desc');
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
        
        // Get categories with product count
        $categories = Category::withCount(['products' => function($q) {
            $q->where('status', 'active');
        }])->orderBy('name')->get();

        // Get top products
        $topProducts = Product::query()
            ->where('status', 'active')
            ->orderByDesc('stock')
            ->limit(6)
            ->get();

        // Get current filters for display
        $selectedCategories = [];
        if ($categories_input = $request->input('categories')) {
            $selectedCategories = is_array($categories_input) ? $categories_input : explode(',', $categories_input);
            $selectedCategories = array_filter($selectedCategories);
        }

        return view('dropshipper.catalog', compact('products', 'categories', 'topProducts', 'selectedCategories'));
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
        $product = Product::with(['category', 'primaryImage', 'images'])
            ->where('status', 'active')
            ->findOrFail($id);

        /**
         * Ambil produk terkait dari kategori yang sama
         * Kecualikan produk yang sedang dilihat
         * Batasi maksimal 4 produk
         */
        $relatedProducts = Product::with('primaryImage')
            ->where('status', 'active')
            ->where('id', '!=', $id)
            ->where('category_id', $product->category_id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        /**
         * Tampilkan halaman detail produk
         */
        return view('dropshipper.product-show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }
}
