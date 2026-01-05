<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ShippingController;
// DROPSHIPPER
use App\Http\Controllers\Dropshipper\DashboardController;
use App\Http\Controllers\Dropshipper\ProductController as DropshipperProductController;
use App\Http\Controllers\Dropshipper\OrderController;
use App\Http\Controllers\Dropshipper\PaymentController;
use App\Http\Controllers\Dropshipper\TransactionController;
use App\Http\Controllers\MidtransCallbackController;

// ADMIN
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\SuperAdmin\UserController;
use App\Models\User;
use App\Http\Controllers\Supplier\ProdukController;
use App\Http\Controllers\Supplier\SupplierController;
use App\Http\Controllers\Supplier\PesananController;
use App\Http\Controllers\Supplier\ProfilController;

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
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');

    // User Management Routes
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    
    Route::get('/suppliers', [SuperAdminController::class, 'suppliers'])->name('suppliers');
    
    Route::get('/dropshippers', [SuperAdminController::class, 'dropshippers'])->name('dropshippers');

    Route::get('/products', [AdminProductController::class, 'index'])->name('products');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('products.destroy');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    
    Route::get('/transactions', [SuperAdminController::class, 'transactions'])->name('transactions');
    
    Route::get('/reports', [SuperAdminController::class, 'reports'])->name('reports');

    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
});

// ============================================
// ADMIN PRODUK ROUTES
// ============================================

Route::middleware(['auth', 'role:admin_produk'])->prefix('adminproduk')->name('adminproduk.')->group(function () {
    Route::get('/dashboard', function () {
        return view('adminproduk.dashboard');
    })->name('dashboard');
    
    Route::get('/products', [AdminProductController::class, 'index'])->name('products');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    
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

    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Supplier\DashboardController::class, 'index'])->name('dashboard');

    // Pengaturan
    Route::get('/pengaturan', fn () => view('supplier.pengaturan.index'))
        ->name('pengaturan');

    // Resource Produk
    Route::resource('produk', ProdukController::class);
    
    // Route aliases for sidebar navigation
    Route::get('/my-products', [ProdukController::class, 'index'])->name('my-products');
    Route::get('/orders', [PesananController::class, 'index'])->name('orders');

    // Pesanan
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');
    
    // Earnings/Pendapatan
    Route::get('/earnings', [\App\Http\Controllers\Supplier\EarningsController::class, 'index'])->name('earnings');

    // Profil (edit & update)
    Route::get('/profil', [\App\Http\Controllers\Supplier\ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [\App\Http\Controllers\Supplier\ProfilController::class, 'update'])->name('profil.update');

    // Ganti password
    Route::get('/password', [\App\Http\Controllers\Supplier\ProfilController::class, 'editPassword'])->name('password.change');
    Route::put('/password', [\App\Http\Controllers\Supplier\ProfilController::class, 'updatePassword'])->name('password.update');

});

// ============================================
// DROPSHIPPER ROUTES
// ============================================

Route::middleware(['auth', 'role:dropshipper'])->prefix('dropshipper')->name('dropshipper.')->group(function () {
    // ===== DASHBOARD =====
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::get('/tracking', [DashboardController::class, 'tracking'])->name('tracking');
    Route::get('/reports', [DashboardController::class, 'reports'])->name('reports');
    // ===== PRODUCT / CATALOG =====
    Route::get('/catalog', [DropshipperProductController::class, 'index'])->name('catalog');
    Route::get('/product/{id}', [DropshipperProductController::class, 'show'])->name('product.show');
    
     // ===== ORDER =====
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/order/{id}', [OrderController::class, 'orderShow'])->name('order.show');
    Route::get('/order-items', [OrderController::class, 'orderItems'])->name('order-items');
    Route::post('/order-items', [OrderController::class, 'orderItemsStore'])->name('order-items.store');
    Route::get('/order-history', [OrderController::class, 'orderHistory'])->name('order-history');
    Route::get('/cart', [OrderController::class, 'cart'])->name('cart');
    Route::get('/history', [OrderController::class, 'orderHistory'])->name('history');
    Route::post('/cart/add', [OrderController::class, 'addToCart'])->name('cart.add');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');

    // ===== PAYMENT (SPRINT 1 DUMMY) =====
    Route::post('/payments/{order}/pay', [PaymentController::class, 'pay'])->name('payments.pay');

    // ===== TRANSACTIONS (SPRINT 1 DUMMY) =====
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');
    
    // API: transactions (DB-backed)
    Route::get('/api/transactions', [TransactionController::class, 'indexApi'])->name('api.transactions');
    Route::get('/api/transactions/{id}', [TransactionController::class, 'showApi'])->name('api.transactions.show');
    Route::get('/midtrans-test', function () {
        return config('midtrans.server_key');
    });

    // ===== SHIPPING & REPORTS API (backend JSON endpoints) =====
    // Track by resi (returns JSON, can proxy to external provider if configured)
    Route::get('/api/tracking/{resi}', [\App\Http\Controllers\Dropshipper\ShippingController::class, 'track'])
        ->name('api.tracking');

    // Reports: summary and list (paginated) with estimated margin
    Route::get('/api/reports/summary', [\App\Http\Controllers\Dropshipper\ReportController::class, 'summary'])
        ->name('api.reports.summary');
    Route::get('/api/reports/orders', [\App\Http\Controllers\Dropshipper\ReportController::class, 'orders'])
        ->name('api.reports.orders');

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

Route::post('/midtrans/callback', 
    [MidtransCallbackController::class, 'handle']
);

