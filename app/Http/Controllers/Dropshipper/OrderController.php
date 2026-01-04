<?php

namespace App\Http\Controllers\Dropshipper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    // =====================
    // LIST ORDER
    // =====================
    public function index()
    {
        $orders = Order::with(['items.product'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('dropshipper.orders', compact('orders'));
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
    // ADD TO CART (SESSION)
    // =====================
    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['qty'] += 1;
            $cart[$product->id]['subtotal'] =
                $cart[$product->id]['qty'] * $cart[$product->id]['price'];
        } else {
            $cart[$product->id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'qty' => 1,
                'subtotal' => $product->price,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Produk ditambahkan ke cart');
    }

    // =====================
    // CART
    // =====================
    public function cart()
    {
        $user = auth()->user();

        $cart = Order::where('user_id', $user->id)
            ->where('status', 'belum_dibayar')
            ->with(['items.product'])
            ->first();

        return view('dropshipper.cart', compact('cart'));
    }

    // =====================
    // CHECKOUT → DATABASE
    // =====================
    public function checkout()
    {
        $cart = Cart::with('items.product')
            ->where('user_id', auth()->id())
            ->firstOrFail();

        DB::transaction(function () use ($cart) {

            $order = Order::create([
                'user_id' => auth()->id(),
                'order_code' => 'GH-' . now()->format('YmdHis'),
                'total' => $cart->items->sum(fn($i) => $i->price * $i->qty),
                'margin' => 0,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->qty,
                    'price' => $item->price,
                    'subtotal' => $item->price * $item->qty,
                ]);
            }

            // kosongkan cart
            $cart->items()->delete();
        });

        return redirect()->route('dropshipper.payments');
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
    public function orderHistory()
    {
        $orders = Order::where('user_id', auth()->id())
            ->where('status', 'Selesai')
            ->latest()
            ->paginate(10);

        return view('dropshipper.order-history', compact('orders'));
    }
}
