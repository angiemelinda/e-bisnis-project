<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;

// ============================================
// PUBLIC ROUTES
// ============================================

// Landing Page - redirect ke dashboard jika sudah login
Route::get('/', [LandingController::class, 'index'])->name('home');

Route::get('/produk', function () {
    return view('product');
})->name('product');

Route::get('/supplier', function () {
    return view('supplier');
})->name('supplier');

Route::get('/cara_kerja', function () {
    return view('cara_kerja');
})->name('cara_kerja');

Route::get('/kontak', function () {
    return view('kontak'); 
})->name('kontak');

// ============================================
// AUTHENTICATION ROUTES
// ============================================

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Forgot Password
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('auth.forgot-password');

// ============================================
// SUPERADMIN ROUTES
// ============================================

Route::middleware(['auth', 'role:super_admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'index'])->name('dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [SuperAdminController::class, 'create'])->name('users.create');
    Route::post('/users', [SuperAdminController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [SuperAdminController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [SuperAdminController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [SuperAdminController::class, 'destroy'])->name('users.destroy');

    
    Route::get('/suppliers', function () {
        return view('superadmin.suppliers');
    })->name('suppliers');
    
    Route::get('/dropshippers', function () {
        return view('superadmin.dropshippers');
    })->name('dropshippers');
    
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    
    Route::get('/transactions', function () {
        return view('superadmin.transactions');
    })->name('transactions');
    
    Route::get('/reports', function () {
        return view('superadmin.reports');
    })->name('reports');
});

// ============================================
// ADMIN PRODUK ROUTES
// ============================================

Route::middleware(['auth', 'role:admin_produk'])->prefix('adminproduk')->name('adminproduk.')->group(function () {
    Route::get('/dashboard', function () {
        return view('adminproduk.dashboard');
    })->name('dashboard');
    
    Route::get('/products', [ProductController::class, 'index'])->name('products');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    
    Route::get('/stock', function () {
        return view('adminproduk.stock');
    })->name('stock');
});

// ============================================
// ADMIN PENGGUNA ROUTES
// ============================================

Route::middleware(['auth', 'role:admin_pengguna'])->prefix('adminpengguna')->name('adminpengguna.')->group(function () {
    Route::get('/dashboard', function () {
        return view('adminpengguna.dashboard');
    })->name('dashboard');
    
    Route::get('/suppliers', function () {
        return view('adminpengguna.suppliers');
    })->name('suppliers');
    
    Route::get('/dropshippers', function () {
        return view('adminpengguna.dropshippers');
    })->name('dropshippers');
});

// ============================================
// ADMIN TRANSAKSI ROUTES
// ============================================

Route::middleware(['auth', 'role:admin_transaksi'])->prefix('admintransaksi')->name('admintransaksi.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admintransaksi.dashboard');
    })->name('dashboard');
    
    Route::get('/all-transactions', function () {
        return view('admintransaksi.all-transactions');
    })->name('all-transactions');
    
    Route::get('/confirmation', function () {
        return view('admintransaksi.confirmation');
    })->name('confirmation');
});

// ============================================
// ADMIN LAPORAN ROUTES
// ============================================

Route::middleware(['auth', 'role:admin_laporan'])->prefix('adminlaporan')->name('adminlaporan.')->group(function () {
    Route::get('/dashboard', function () {
        return view('adminlaporan.dashboard');
    })->name('dashboard');
    
    Route::get('/sales-report', function () {
        return view('adminlaporan.sales-report');
    })->name('sales-report');
    
    Route::get('/supplier-report', function () {
        return view('adminlaporan.supplier-report');
    })->name('supplier-report');
});

// ============================================
// SUPPLIER ROUTES
// ============================================

Route::middleware(['auth', 'role:supplier'])->prefix('supplier')->name('supplier.')->group(function () {
    Route::get('/dashboard', function () {
        return view('supplier.dashboard');
    })->name('dashboard');
    
    Route::get('/my-products', function () {
        return view('supplier.my-products');
    })->name('my-products');
    
    Route::post('/products', function () {
        // Handle product creation
        return redirect()->route('supplier.my-products')->with('success', 'Produk berhasil ditambahkan');
    })->name('products.store');
    
    Route::get('/orders', function () {
        return view('supplier.orders');
    })->name('orders');
    
    Route::get('/earnings', function () {
        return view('supplier.earnings');
    })->name('earnings');
});

// ============================================
// DROPSHIPPER ROUTES
// ============================================

Route::middleware(['auth', 'role:dropshipper'])->prefix('dropshipper')->name('dropshipper.')->group(function () {
    Route::get('/dashboard', function () {
        return view('dropshipper.dashboard');
    })->name('dashboard');
    
    Route::get('/catalog', function () {
        return view('dropshipper.catalog');
    })->name('catalog');
    
    Route::get('/order-items', function () {
        return view('dropshipper.order-items');
    })->name('order-items');
    
    Route::get('/order-history', function () {
        return view('dropshipper.order-history');
    })->name('order-history');
});

// ============================================
// LEGACY ROUTES (for backward compatibility)
// ============================================

// Old admin routes - redirect to new structure
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/super-admin', function () {
        return redirect()->route('superadmin.dashboard');
    })->name('admin.dashboard');
    
    Route::get('/super-admin/produk', function () {
        return redirect()->route('superadmin.products');
    })->name('admin.products');
    
    Route::get('/super-admin/kategori', function () {
        return redirect()->route('superadmin.categories');
    })->name('admin.categories');
    
    Route::get('/super-admin/pengguna', function () {
        return redirect()->route('superadmin.users');
    })->name('admin.users');
    
    Route::get('/super-admin/transaksi', function () {
        return redirect()->route('superadmin.transactions');
    })->name('admin.transactions');
    
    Route::get('/super-admin/supplier', function () {
        return redirect()->route('superadmin.suppliers');
    })->name('admin.suppliers');
    
    Route::get('/super-admin/dropshipper', function () {
        return redirect()->route('superadmin.dropshippers');
    })->name('admin.dropshippers');
});
