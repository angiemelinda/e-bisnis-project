<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Product::where('user_id', auth()->id())
            ->with('category')
            ->latest()
            ->get();
        $categories = Category::where('active', true)->orderBy('name')->get();
        return view('supplier.produk.index', compact('produks', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('active', true)->orderBy('name')->get();
        return view('supplier.produk.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'nullable|in:active,inactive',
        ]);

        // Generate SKU
        $sku = 'PRD-' . strtoupper(Str::random(8));

        $product = Product::create([
            'sku' => $sku,
            'name' => $validated['name'],
            'category_id' => $validated['category_id'] ?? null,
            'user_id' => auth()->id(),
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'status' => $validated['status'] ?? 'active',
        ]);

        // Check if request is AJAX (multiple methods to be safe)
        if ($request->expectsJson() || $request->header('Accept') === 'application/json' || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan.',
                'product' => $product
            ], 201);
        }

        return redirect()->route('supplier.produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $produk = Product::where('user_id', auth()->id())->findOrFail($id);
        $categories = Category::where('active', true)->orderBy('name')->get();
        return view('supplier.produk.edit', compact('produk', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $produk = Product::where('user_id', auth()->id())->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'nullable|in:active,inactive',
        ]);

        $produk->update([
            'name' => $validated['name'],
            'category_id' => $validated['category_id'] ?? null,
            'price' => $validated['price'],
            'stock' => $validated['stock'],
            'status' => $validated['status'] ?? 'active',
        ]);

        return redirect()->route('supplier.produk.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $produk = Product::where('user_id', auth()->id())->findOrFail($id);
        $produk->delete();

        return redirect()->route('supplier.produk.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
