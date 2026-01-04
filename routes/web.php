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
use App\Models\User;
use App\Http\Controllers\Supplier\ProdukController;

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
    Route::get('/dashboard', function () {
        return view('superadmin.dashboard');
    })->name('dashboard');

    Route::get('/users', function () {
        $users = User::orderByDesc('id')->paginate(10);
        return view('superadmin.users', compact('users'));
    })->name('users');

    
    Route::get('/suppliers', function () {
        return view('superadmin.suppliers');
    })->name('suppliers');
    
    Route::get('/dropshippers', function () {
        return view('superadmin.dropshippers');
    })->name('dropshippers');

    Route::get('/products', [AdminProductController::class, 'index'])->name('products');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');

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

    Route::get('/dashboard', function () {

        $totalProduk   = 12;
        $totalOrders   = 25;
        $totalStok     = 80;
        $outOfStock    = 3;

        $pesananTerbaru = [
            (object)['id'=>101, 'status'=>'belum diproses'],
            (object)['id'=>102, 'status'=>'sedang dikirim'],
            (object)['id'=>103, 'status'=>'selesai'],
        ];

        $produkTeratas = [
            (object)['nama'=>'Kaos Polos', 'stok'=>3],
            (object)['nama'=>'Totebag Custom', 'stok'=>7],
        ];

        $notifikasi = [
            (object)['message'=>'Pesanan baru masuk #104'],
            (object)['message'=>'Produk Kaos Polos hampir habis'],
            (object)['message'=>'Promo baru tersedia'],
        ];

        return view('supplier.dashboard2', compact(
            'totalProduk',
            'totalOrders',
            'totalStok',
            'outOfStock',
            'pesananTerbaru',
            'produkTeratas',
            'notifikasi'
        ));
    })->name('dashboard');


    // PRODUK
    Route::prefix('produk')->name('produk.')->group(function () {
        Route::get('/', fn () => view('supplier.produk.index'))->name('index');
        Route::get('/create', fn () => view('supplier.produk.create'))->name('create');
        Route::get('/edit/{id}', fn ($id) => view('supplier.produk.edit', compact('id')))->name('edit');
    });

    // PESANAN
    Route::prefix('pesanan')->name('pesanan.')->group(function () {
        Route::get('/', fn () => view('supplier.pesanan.index'))->name('index');
        Route::get('/{id}', fn ($id) => view('supplier.pesanan.show', compact('id')))->name('show');
    });

    // PROFIL
    Route::get('/profile', fn () => view('supplier.profile'))->name('profile');

    //PENGATURAN
    Route::get('/pengaturan', fn () => view('supplier.pengaturan'))->name('pengaturan');
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
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments');
    Route::post('/pay/{order}', [PaymentController::class, 'pay']) ->name('payments.pay');
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

/*
|--------------------------------------------------------------------------
| SHIPPING ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // ADMIN & SUPPLIER
    Route::middleware('role:admin,supplier')->group(function () {
        Route::post('/orders/{order}/shipping', 
            [ShippingController::class, 'update']
        )->name('shipping.update');
    });

    // DROPSHIPPER
    Route::middleware('role:dropshipper')->group(function () {
        Route::get('/shipping/track/{resi}', 
            [ShippingController::class, 'track']
        )->name('shipping.track');
    });

});