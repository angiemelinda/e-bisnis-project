<?php

namespace App\Http\Controllers\Dropshipper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    // =====================
    // LIST ORDER
    // =====================
    public function index(Request $request)
    {
        $query = Order::with(['items.product'])
            ->where('user_id', auth()->id())
            ->where('status', '!=', 'dibatalkan');

        

        // Filter by status if provided
        if ($request->has('status') && $request->status !== 'all') {
            if ($request->status === 'menunggu_pembayaran') {
                $query->where(function($q) {
                    $q->where('status', 'menunggu_pembayaran')
                      ->orWhere('payment_status', 'menunggu_pembayaran');
                });
            } else {
                $query->where('status', $request->status);
            }
        }

        $orders = $query->latest()->paginate(10);

        // Get counts for summary cards
        $counts = [
            'menunggu_pembayaran' => Order::where('user_id', auth()->id())
                ->where('payment_status', 'menunggu_pembayaran')
                ->count(),
            'dikemas' => Order::where('user_id', auth()->id())
                ->where('status', 'dikemas')
                ->count(),
            'dikirim' => Order::where('user_id', auth()->id())
                ->where('status', 'dikirim')
                ->count(),
            'selesai' => Order::where('user_id', auth()->id())
                ->where('status', 'selesai')
                ->count(),
            'dibatalkan' => Order::where('user_id', auth()->id())
                ->where('status', 'dibatalkan')
                ->count(),
        ];

        $counts['all'] = array_sum($counts);
        /**
         * Ambil cart count (jumlah item di cart yang belum dibayar)
         */
        $cart = Order::with('items')
            ->where('user_id', auth()->id())
            ->where('status', 'menunggu_pembayaran')
            ->first();
        
        $cartCount = $cart ? $cart->items->sum('quantity') : 0;

        /**
         * Ambil user data untuk display initials
         */
        $user = Auth::user();
        

        return view('dropshipper.orders', compact('orders', 'counts', 'cartCount', 'user'));
    }

    // =====================
    // FORM PILIH PRODUK
    // =====================
    public function orderItems()
    {
        $products = Product::orderBy('name')->get();
        return view('dropshipper.order-items', compact('products'));
    }

    // =====================
    // ADD TO CART 
    // =====================
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->input('quantity', 1);

        // ambil order cart atau buat baru
        $order = Order::firstOrCreate(
            [
                'user_id' => auth()->id(),
                'status' => 'menunggu_pembayaran',
            ],
            [
                'order_code' => 'GH-' . now()->format('YmdHis'),
                'total' => 0,
                'margin' => 0,
            ]
        );

        // cek item sudah ada atau belum
        $item = OrderItem::where('order_id', $order->id)
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            $item->quantity += $quantity;
            $item->subtotal = $item->quantity * $item->price;
            $item->save();
        } else {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
                'subtotal' => $product->price * $quantity,
            ]);
        }

        // Update total order dengan menghitung ulang diskon jika ada
        $order->refresh();
        $subtotal = $order->items()->sum('subtotal');
        $discountPercent = $order->discount ?? 0;
        $discountAmount = 0;
        $total = $subtotal;
        
        if ($discountPercent > 0 && $discountPercent <= 100) {
            $discountAmount = ($subtotal * $discountPercent) / 100;
            $total = $subtotal - $discountAmount;
        }
        
        $order->update([
            'discount_amount' => $discountAmount,
            'total' => $total,
        ]);
        // Return JSON response if AJAX request
        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Produk ditambahkan ke keranjang',
                'cart_items_count' => $order->items->count(),
            ]);
        }

        return back()->with('success', 'Produk ditambahkan ke keranjang');
    }


    // =====================
    // CART
    // =====================
    public function cart()
    {
        $cart = Order::with('items.product')
            ->where('user_id', auth()->id())
            ->where('status', 'menunggu_pembayaran')
            ->first();

        /**
         * Menggunakan cart yang sudah di-load di atas
         */
        $cartCount = $cart ? $cart->items->sum('quantity') : 0;

        /**
         * Ambil user data untuk display initials
         */
        $user = Auth::user();

        return view('dropshipper.cart', compact('cart', 'cartCount', 'user'));
        return view('dropshipper.cart', compact('cart'));
    }

    // =====================
    // APPLY DISKON
    // =====================
    public function applyDiscount(Request $request)
    {
        $request->validate([
            'discount' => 'nullable|numeric|min:0|max:100',
        ]);

        $cart = Order::with('items.product')
            ->where('user_id', auth()->id())
            ->where('status', 'menunggu_pembayaran')
            ->firstOrFail();

        $discountPercent = $request->input('discount', 0);
        $subtotal = $cart->items->sum('subtotal');
        
        // Hitung diskon
        $discountAmount = 0;
        $total = $subtotal;
        
        if ($discountPercent > 0 && $discountPercent <= 100) {
            $discountAmount = ($subtotal * $discountPercent) / 100;
            $total = $subtotal - $discountAmount;
        }

        // Update cart dengan diskon
        $cart->update([
            'discount' => $discountPercent,
            'discount_amount' => $discountAmount,
            'total' => $total,
        ]);

        // Reset snap_token karena total berubah
        $cart->update(['snap_token' => null]);

        return response()->json([
            'status' => 'success',
            'message' => 'Diskon berhasil diterapkan',
            'data' => [
                'discount' => $discountPercent,
                'discount_amount' => $discountAmount,
                'subtotal' => $subtotal,
                'total' => $total,
            ]
        ]);
    }


    // =====================
    // CHECKOUT → MIDTRANS SNAP
    // =====================
    public function checkout(Request $request)
{
    $request->validate([
        'item_ids' => 'required|array',
        'item_ids.*' => 'required|integer|exists:order_items,id',
    ]);

    $cart = Order::with('items.product')
        ->where('user_id', auth()->id())
        ->where('status', 'menunggu_pembayaran')
        ->firstOrFail();

    $selectedItemIds = $request->input('item_ids', []);
    $selectedItems = $cart->items()->whereIn('id', $selectedItemIds)->get();

    if ($selectedItems->isEmpty()) {
        return response()->json(['status' => 'error', 'message' => 'Pilih minimal satu produk'], 400);
    }

    try {
        DB::beginTransaction();

        $subtotal = $selectedItems->sum('subtotal');
        $discount = $request->input('discount', $cart->discount ?? 0);
        $discountAmount = ($discount > 0 && $discount <= 100) ? ($subtotal * $discount) / 100 : 0;
        $total = $subtotal - $discountAmount;

        if ($total <= 0) throw new \Exception('Total tidak valid');

        // Buat order baru
        $newOrder = Order::create([
            'user_id' => auth()->id(),
            'order_code' => 'GH-' . now()->format('YmdHis') . '-' . rand(1000,9999),
            'total' => $total,
            'discount' => $discount,
            'discount_amount' => $discountAmount,
            'status' => 'menunggu_pembayaran',
            'payment_status' => 'menunggu_pembayaran',
        ]);

        // Pindahkan item ke order baru
        OrderItem::whereIn('id', $selectedItemIds)
            ->update(['order_id' => $newOrder->id]);

        // Buat payment record dulu
        $attempt = Payment::where('order_id', $newOrder->id)->count() + 1;
        $midtransOrderId = $newOrder->order_code . '-ATTEMPT-' . $attempt . '-' . time();

        $payment = Payment::create([
            'order_id' => $newOrder->id,
            'midtrans_order_id' => $midtransOrderId,
            'status' => 'menunggu_pembayaran',
        ]);

        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $user = auth()->user();
        $name = explode(' ', $user->name, 2);

        $params = [
            'transaction_details' => [
                'order_id' => $midtransOrderId,
                'gross_amount' => (int) $total,
            ],
            'customer_details' => [
                'first_name' => $name[0],
                'last_name' => $name[1] ?? '',
                'email' => $user->email,
                'phone' => $user->phone ?? '',
            ],
        ];

        $attempt = Payment::where('order_id', $newOrder->id)->count() + 1;

        $midtransOrderId = $newOrder->order_code . '-ATTEMPT-' . $attempt . '-' . time();

        $payment = Payment::create([
            'order_id' => $newOrder->id,
            'midtrans_order_id' => $midtransOrderId,
            'status' => 'menunggu_pembayaran',
            'amount' => $total,
            'attempt' => $attempt,
        ]);

        $snap = \Midtrans\Snap::createTransaction($params);
        $snapToken = $snap->token;

        // SIMPAN TOKEN KE PAYMENT (INI INTINYA)
        $payment->update([
            'snap_token' => $snapToken,
        ]);

        // opsional: simpan token terakhir ke order
        $newOrder->update([
            'snap_token' => $snapToken,
            'payment_status' => 'menunggu_pembayaran',
        ]);



        DB::commit();

        return response()->json([
            'status' => 'success',
            'snap_token' => $snapToken,
            'order_code' => $newOrder->order_code,
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Checkout error: ' . $e->getMessage());
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}




    // =====================
    // DETAIL ORDER
    // =====================
    public function orderShow($id)
    {
        $order = Order::with(['items.product'])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('dropshipper.order-detail', compact('order'));
    }

    // =====================
    // HISTORY (SELESAI)
    // =====================
    public function orderHistory(Request $request)
    {
        $orders = Order::with(['items.product.primaryImage'])
            ->where('user_id', auth()->id())
            ->whereIn('status', ['selesai', 'dibatalkan'])
            ->orderByDesc('created_at')
            ->paginate(10);


        // Filter by date range if provided
        if ($request->has('period')) {
            $period = $request->period;
            $now = now();
            
            switch ($period) {
                case '7_days':
                    $query->where('created_at', '>=', $now->subDays(7));
                    break;
                case '30_days':
                    $query->where('created_at', '>=', $now->subDays(30));
                    break;
                case '3_months':
                    $query->where('created_at', '>=', $now->subMonths(3));
                    break;
                case '6_months':
                    $query->where('created_at', '>=', $now->subMonths(6));
                    break;
                case 'this_year':
                    $query->whereYear('created_at', $now->year);
                    break;
            }
        }

        $orders = $query->latest()->paginate(10);

        // Calculate statistics
        $completedOrders = Order::where('user_id', auth()->id())
            ->where('status', 'selesai')
            ->with('items')
            ->get();
            
        $stats = [
            'total_orders' => $completedOrders->count(),
            'total_spent' => $completedOrders->sum('total'),
            'total_items' => $completedOrders->sum(function($order) {
                return $order->items->sum('quantity');
            }),
            'this_month' => Order::where('user_id', auth()->id())
                ->where('status', 'selesai')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->count(),
        ];

        /**
         * Ambil cart count (jumlah item di cart yang belum dibayar)
         */
        $cart = Order::with('items')
            ->where('user_id', auth()->id())
            ->where('status', 'menunggu_pembayaran')
            ->first();
        
        $cartCount = $cart ? $cart->items->sum('quantity') : 0;

        /**
         * Ambil user data untuk display initials
         */
        $user = Auth::user();

        return view('dropshipper.order-history', compact('orders', 'stats', 'cartCount', 'user'));
    }

    // =====================
    // UPDATE CART ITEM
    // =====================
    public function updateCartItem(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $item = OrderItem::whereHas('order', function ($q) {
            $q->where('user_id', auth()->id())
              ->where('status', 'menunggu_pembayaran');
        })->findOrFail($itemId);

        $item->quantity = $request->quantity;
        $item->subtotal = $item->quantity * $item->price;
        $item->save();

        // Update order total dengan menghitung ulang diskon jika ada
        $order = $item->order;
        $order->refresh();
        $subtotal = $order->items()->sum('subtotal');
        $discountPercent = $order->discount ?? 0;
        $discountAmount = 0;
        $total = $subtotal;
        
        if ($discountPercent > 0 && $discountPercent <= 100) {
            $discountAmount = ($subtotal * $discountPercent) / 100;
            $total = $subtotal - $discountAmount;
        }
        
        if ($order->snap_token && $order->total != $total) {
            $order->snap_token = null;
        }

        $order->update([
            'discount_amount' => $discountAmount,
            'total' => $total,
        ]);


        return response()->json([
            'status' => 'success',
            'message' => 'Quantity berhasil diupdate',
            'data' => [
                'item' => [
                    'id' => $item->id,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal,
                ],
                'subtotal' => $subtotal,
                'discount' => $discountPercent,
                'discount_amount' => $discountAmount,
                'order_total' => $total,
            ]
        ]);
    }

    // =====================
    // REMOVE CART ITEM
    // =====================
    public function removeCartItem($itemId)
    {
        $item = OrderItem::whereHas('order', function ($q) {
            $q->where('user_id', auth()->id())
              ->where('status', 'menunggu_pembayaran');
        })->findOrFail($itemId);

        $order = $item->order;
        $item->delete();

        // Update order total dengan menghitung ulang diskon jika ada
        $order->refresh();
        $subtotal = $order->items()->sum('subtotal');
        $discountPercent = $order->discount ?? 0;
        $discountAmount = 0;
        $total = $subtotal;
        
        if ($discountPercent > 0 && $discountPercent <= 100) {
            $discountAmount = ($subtotal * $discountPercent) / 100;
            $total = $subtotal - $discountAmount;
        }
        
        $order->update([
            'discount_amount' => $discountAmount,
            'total' => $total,
            'snap_token' => null, // reset snap token karena total berubah
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Item berhasil dihapus dari keranjang',
            'data' => [
                'subtotal' => $subtotal,
                'discount' => $discountPercent,
                'discount_amount' => $discountAmount,
                'order_total' => $total,
            ]
        ]);
    }

    // =====================
    // CLEAR CART
    // =====================
    public function clearCart()
    {
        $cart = Order::where('user_id', auth()->id())
            ->where('status', 'menunggu_pembayaran')
            ->first();

        if (!$cart) {
            return response()->json([
                'status' => 'error',
                'message' => 'Keranjang kosong'
            ], 404);
        }

        // Delete all items in cart
        OrderItem::where('order_id', $cart->id)->delete();

        // Reset order data
        $cart->update([
            'discount' => 0,
            'discount_amount' => 0,
            'total' => 0,
            'snap_token' => null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Keranjang berhasil dikosongkan'
        ]);
    }
}