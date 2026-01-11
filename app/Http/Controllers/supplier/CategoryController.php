<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:supplier');
    }

    public function index()
    {
        $categories = Category::orderBy('name')->paginate(10);
        $summary = [
            'total' => Category::count(),
            'active' => Category::where('active', true)->count(),
        ];

        return view('supplier.categories.index', compact('categories', 'summary'));
    }

    public function create()
    {
        return view('supplier.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120|unique:categories,name',
            'active' => 'nullable|boolean',
        ]);

        $slug = Str::slug($data['name']);
        $suffix = 1;
        $baseSlug = $slug;
        
        while (Category::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $suffix++;
        }

        Category::create([
            'name' => $data['name'],
            'slug' => $slug,
            'active' => $data['active'] ?? true,
        ]);

        return redirect()->route('supplier.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('supplier.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120|unique:categories,name,' . $category->id,
            'active' => 'nullable|boolean',
        ]);

        // Only update slug if name has changed
        if ($category->name !== $data['name']) {
            $slug = Str::slug($data['name']);
            $baseSlug = $slug;
            $suffix = 1;
            
            while (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                $slug = $baseSlug . '-' . $suffix++;
            }
            
            $data['slug'] = $slug;
        }

        $category->update($data);

        return redirect()->route('supplier.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        // Prevent deletion if category has products
        if ($category->products()->exists()) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus kategori yang memiliki produk terkait.');
        }

        $category->delete();

        return redirect()->route('supplier.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}