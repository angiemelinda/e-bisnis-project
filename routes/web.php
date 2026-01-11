<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\PaymentRedirectController;

// DROPSHIPPER
use App\Http\Controllers\Dropshipper\DashboardController;
use App\Http\Controllers\Dropshipper\ProductController as DropshipperProductController;
use App\Http\Controllers\Dropshipper\OrderController;
use App\Http\Controllers\Dropshipper\PaymentController;
use App\Http\Controllers\Dropshipper\TransactionController;
use App\Http\Controllers\Dropshipper\ReportController;

// ADMIN
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\SuperAdmin\UserController;

// SUPPLIER
use App\Http\Controllers\Supplier\DashboardController as SupplierDashboardController;
use App\Http\Controllers\Supplier\ProdukController;
use App\Http\Controllers\Supplier\PesananController;
use App\Http\Controllers\Supplier\ProfilController;
use App\Http\Controllers\Supplier\EarningsController;

// ============================================
// AUTHENTICATION ROUTES
// ============================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

// ============================================
// PASSWORD RESET ROUTES
// ============================================
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [AuthController::class, 'resetPassword'])
    ->middleware('guest')
    ->name('password.update');

// ============================================
// PUBLIC ROUTES
// ============================================
Route::get('/', [LandingController::class, 'index'])->name('home');
Route::view('/produk', 'product')->name('product');
Route::view('/supplier', 'supplier')->name('supplier');
Route::view('/cara_kerja', 'cara_kerja')->name('cara_kerja');
Route::view('/kontak', 'kontak')->name('kontak');

// ============================================
// SUPERADMIN ROUTES
// ============================================
Route::middleware(['auth', 'role:super_admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('dashboard');

    // User Management
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{id}/status', [UserManagementController::class, 'updateStatus'])->name('users.updateStatus');
    
    // Suppliers Management
    Route::get('/suppliers', [UserController::class, 'suppliers'])->name('suppliers');
    
    // Dropshippers Management
    Route::get('/dropshippers', [UserController::class, 'dropshippers'])->name('dropshippers');
    
    // Products & Categories
    Route::get('/products', [AdminProductController::class, 'index'])->name('products');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
    
    // Categories
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    
    // Transactions
    Route::get('/transactions', [SuperAdminController::class, 'transactions'])->name('transactions');
    
    // Reports
    Route::get('/reports', [SuperAdminController::class, 'reports'])->name('reports');
});

// ============================================
// ADMIN PRODUK ROUTES
// ============================================
Route::middleware(['auth', 'role:admin_produk'])->prefix('adminproduk')->name('adminproduk.')->group(function () {
    Route::get('/dashboard', function () {
        return view('adminproduk.dashboard');
    })->name('dashboard');
    
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    
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
    
    Route::get('/suppliers', [UserManagementController::class, 'suppliers'])->name('suppliers');
    Route::get('/dropshippers', [UserManagementController::class, 'dropshippers'])->name('dropshippers');
    Route::post('/users/{id}/status', [UserManagementController::class, 'updateStatus'])->name('users.updateStatus');
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
    Route::get('/dashboard', [SupplierDashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::resource('produk', ProdukController::class);
    Route::get('/my-products', [ProdukController::class, 'index'])->name('my-products');

    // Orders
    Route::get('/orders', [PesananController::class, 'index'])->name('orders');
    Route::get('/orders/{id}', [PesananController::class, 'show'])->name('orders.show');
    
    // Earnings
    Route::get('/earnings', [EarningsController::class, 'index'])->name('earnings');

    // Profile
    Route::get('/profile', [ProfilController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfilController::class, 'update'])->name('profile.update');
    Route::get('/password', [ProfilController::class, 'editPassword'])->name('password.change');
    Route::put('/password', [ProfilController::class, 'updatePassword'])->name('password.update');
});

// ============================================
// DROPSHIPPER ROUTES
// ============================================
Route::middleware(['auth', 'role:dropshipper'])->prefix('dropshipper')->name('dropshipper.')->group(function () {
    // Dashboard & Profile
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::get('/tracking', [DashboardController::class, 'tracking'])->name('tracking');
    Route::get('/reports', [DashboardController::class, 'reports'])->name('reports');
    
    // Catalog & Products
    Route::get('/catalog', [DropshipperProductController::class, 'index'])->name('catalog');
    Route::get('/product/{id}', [DropshipperProductController::class, 'show'])->name('product.show');
    
    // Orders & Cart
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{id}', [OrderController::class, 'orderShow'])->name('show');
        Route::get('/history', [OrderController::class, 'orderHistory'])->name('history');
        
        // Cart
        Route::get('/cart', [OrderController::class, 'cart'])->name('cart');
        Route::post('/cart/add', [OrderController::class, 'addToCart'])->name('cart.add');
        Route::post('/cart/apply-discount', [OrderController::class, 'applyDiscount'])->name('cart.apply-discount');
        Route::put('/cart/items/{itemId}', [OrderController::class, 'updateCartItem'])->name('cart.update');
        Route::delete('/cart/items/{itemId}', [OrderController::class, 'removeCartItem'])->name('cart.remove');
        
        // Checkout
        Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    });
    
    // Payments
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');
        Route::post('/{order}/pay', [PaymentController::class, 'pay'])->name('pay');
    });
    
    // API Endpoints
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/transactions', [TransactionController::class, 'indexApi'])->name('transactions');
        Route::get('/transactions/{id}', [TransactionController::class, 'showApi'])->name('transactions.show');
        Route::get('/reports/summary', [ReportController::class, 'summary'])->name('reports.summary');
        Route::get('/reports/orders', [ReportController::class, 'orders'])->name('reports.orders');
    });
});

// ============================================
// MIDTRANS CALLBACK & REDIRECT
// ============================================
Route::post('/midtrans/callback', [MidtransCallbackController::class, 'handle'])->name('midtrans.callback');
Route::get('/payment/finish', [PaymentRedirectController::class, 'finish'])->name('payment.finish');
Route::get('/payment/unfinish', [PaymentRedirectController::class, 'unfinish'])->name('payment.unfinish');
Route::get('/payment/error', [PaymentRedirectController::class, 'error'])->name('payment.error');

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
    
    // Category Management
    Route::get('/categories', [SupplierCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [SupplierCategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [SupplierCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [SupplierCategoryController::class, 'destroy'])->name('categories.destroy');
    
    // Route aliases for sidebar navigation
    Route::get('/my-products', [ProdukController::class, 'index'])->name('my-products');
    Route::get('/orders', [PesananController::class, 'index'])->name('orders');

    // Pesanan
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');
    
    // Earnings/Pendapatan
    Route::get('/earnings', [\App\Http\Controllers\Supplier\EarningsController::class, 'index'])->name('earnings');

    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\Supplier\NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\Supplier\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [\App\Http\Controllers\Supplier\NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');

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
    Route::get('/tracking', [DashboardController::class, 'tracking'])->name('tracking');
    Route::get('/reports', [DashboardController::class, 'reports'])->name('reports');
    
    // ===== PROFILE =====
    Route::get('/profile', [\App\Http\Controllers\Dropshipper\ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [\App\Http\Controllers\Dropshipper\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\Dropshipper\ProfileController::class, 'updatePassword'])->name('profile.password.update');
    // ===== PRODUCT / CATALOG =====
    Route::get('/catalog', [DropshipperProductController::class, 'index'])->name('catalog');
    Route::get('/product/{id}', [DropshipperProductController::class, 'show'])->name('product.show');
    
     // ===== ORDER =====
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/order/{id}', [OrderController::class, 'orderShow'])->name('order.show');
    Route::get('/order-items', [OrderController::class, 'orderItems'])->name('order-items');
    Route::post('/order-items', [OrderController::class, 'orderItemsStore'])->name('order-items.store');
    Route::get('/order-history', [OrderController::class, 'orderHistory'])->name('order-history');
    Route::post('/order/{order}/buy-again', [OrderController::class, 'buyAgain'])->name('order.buy-again');
    Route::get('/cart', [OrderController::class, 'cart'])->name('cart');
    Route::get('/history', [OrderController::class, 'orderHistory'])->name('history');
    Route::post('/cart/add', [OrderController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove/{item}', [OrderController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/clear', [OrderController::class, 'clearCart'])->name('cart.clear');
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');

    // ===== NOTIFICATIONS =====
    Route::get('/notifications', [\App\Http\Controllers\Dropshipper\NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\Dropshipper\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [\App\Http\Controllers\Dropshipper\NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');

    // ===== PAYMENT =====
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::post('/payments/{order}/pay', [PaymentController::class, 'pay'])->name('payments.pay');
    Route::get('/payments/finish', [PaymentController::class, 'finish'])->name('payments.finish');
    Route::get('/payments/unfinish', [PaymentController::class, 'unfinish'])->name('payments.unfinish');
    Route::get('/payments/error', [PaymentController::class, 'error'])->name('payments.error');

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

