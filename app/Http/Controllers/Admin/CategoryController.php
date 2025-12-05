<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->paginate(10);
        $summary = [
            'total' => Category::count(),
            'active' => Category::where('active', true)->count(),
        ];

        // Determine view based on route
        if (request()->routeIs('superadmin.categories')) {
            $view = 'superadmin.categories';
        } elseif (request()->routeIs('adminproduk.categories')) {
            $view = 'adminproduk.categories';
        } else {
            $view = 'admin.categories'; // fallback
        }

        return view($view, compact('categories', 'summary'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120|unique:categories,name',
            'active' => 'nullable|boolean',
        ]);

        $slug = Str::slug($data['name']);
        // Pastikan slug unik
        $suffix = 1;
        $baseSlug = $slug;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $baseSlug.'-'.$suffix++;
        }

        Category::create([
            'name' => $data['name'],
            'slug' => $slug,
            'active' => $data['active'] ?? true,
        ]);

        // Determine redirect route based on current route
        if (request()->routeIs('superadmin.categories.store')) {
            return redirect()->route('superadmin.categories')->with('success', 'Kategori berhasil ditambahkan.');
        } elseif (request()->routeIs('adminproduk.categories.store')) {
            return redirect()->route('adminproduk.categories')->with('success', 'Kategori berhasil ditambahkan.');
        } else {
            return redirect()->route('admin.categories')->with('success', 'Kategori berhasil ditambahkan.');
        }
    }
}