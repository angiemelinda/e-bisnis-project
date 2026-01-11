<?php

namespace App\Http\Controllers\Dropshipper;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = config('midtrans.is_sanitized', true);
        Config::$is3ds = config('midtrans.is_3ds', true);
    
        // Only disable SSL verification in local/development environment
        if (app()->environment('local')) {
            Config::$curlOptions[CURLOPT_SSL_VERIFYPEER] = false;
            Config::$curlOptions[CURLOPT_SSL_VERIFYHOST] = false;
        } else {
            // In production, use proper CA bundle
            Config::$curlOptions[CURLOPT_CAINFO] = storage_path('cacert.pem');
        }
        
        Config::$curlOptions[CURLOPT_RETURNTRANSFER] = true;
        Config::$curlOptions[CURLOPT_TIMEOUT] = 60;
        Config::$curlOptions[CURLOPT_CONNECTTIMEOUT] = 30;
    }

    // 1️⃣ Daftar pembayaran (BELUM LUNAS)
    public function index()
    {
        $orders = Order::with(['payment', 'items.product'])
            ->where('user_id', auth()->id())
            ->where('payment_status', 'menunggu_pembayaran')
            ->where('status', 'belum_dibayar') // Status order: belum_dibayar, dikemas, dikirim, selesai
            ->latest()
            ->get();

        return view('dropshipper.payments', compact('orders'));
    }

    // 2️⃣ Halaman bayar (Snap)
    public function pay(Order $order)
    {
        try {
            Log::info('Starting payment process', ['order_id' => $order->id, 'order_code' => $order->order_code]);
            
            // Authorization check
            if ($order->user_id !== auth()->id()) {
                Log::warning('Unauthorized payment attempt', [
                    'user_id' => auth()->id(),
                    'order_user_id' => $order->user_id,
                    'order_id' => $order->id
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized access to this order.'
                ], 403);
            }

            if ($order->payment_status !== 'menunggu_pembayaran') {
                Log::warning('Invalid payment status', [
                    'order_id' => $order->id,
                    'current_status' => $order->payment_status,
                    'expected_status' => 'menunggu_pembayaran'
                ]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order sudah diproses atau tidak valid.'
                ], 400);
            }

            // Initialize Midtrans configuration
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production', false);
            Config::$isSanitized = config('midtrans.is_sanitized', true);
            Config::$is3ds = config('midtrans.is_3ds', true);
            
            // Set cURL options
            Config::$curlOptions = [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 60,
                CURLOPT_CONNECTTIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 5
            ];

            // Create or get payment record
            $payment = Payment::firstOrCreate(
                ['order_id' => $order->id],
                [
                    'midtrans_order_id' => $order->order_code,
                    'status' => 'menunggu_pembayaran',
                    'amount' => $order->total,
                ]
            );

            // If snap_token already exists and order not paid, return it
            if ($order->snap_token && $order->payment_status === 'menunggu_pembayaran') {
                Log::info('Using existing snap token', ['order_id' => $order->id]);
                return response()->json([
                    'status' => 'success',
                    'snap_token' => $order->snap_token,
                    'client_key' => config('midtrans.client_key')
                ]);
            }

            // Validate order items
            if ($order->items->isEmpty()) {
                throw new \Exception('Order tidak memiliki item');
            }

            // Prepare item details for Midtrans with validation
            $itemDetails = [];
            $totalAmount = 0;
            $itemCount = 0;

            foreach ($order->items as $item) {
                if (!$item->product) {
                    throw new \Exception('Produk tidak ditemukan');
                }

                $price = (int) round($item->price);
                $quantity = (int) $item->quantity;
                $itemTotal = $price * $quantity;
                
                if ($price <= 0 || $quantity <= 0) {
                    throw new \Exception('Harga atau kuantitas produk tidak valid');
                }

                $itemDetails[] = [
                    'id' => (string) $item->product_id,
                    'price' => $price,
                    'quantity' => $quantity,
                    'name' => substr($item->product->name, 0, 50), // Limit name length
                ];

                $totalAmount += $itemTotal;
                $itemCount++;
                
                Log::debug('Added item to order', [
                    'item_id' => $item->id,
                    'product_id' => $item->product_id,
                    'price' => $price,
                    'quantity' => $quantity,
                    'item_total' => $itemTotal,
                    'running_total' => $totalAmount
                ]);
            }

            // Add shipping cost if exists
            if ($order->shipping_cost > 0) {
                $shippingCost = (int) round($order->shipping_cost);
                $itemDetails[] = [
                    'id' => 'shipping',
                    'price' => $shippingCost,
                    'quantity' => 1,
                    'name' => 'Biaya Pengiriman',
                ];
                $totalAmount += $shippingCost;
                Log::debug('Added shipping cost', ['shipping_cost' => $shippingCost, 'new_total' => $totalAmount]);
            }

            // Validate total amount
            $orderTotal = (int) round($order->total);
            if ($totalAmount !== $orderTotal) {
                $errorData = [
                    'order_id' => $order->id,
                    'order_code' => $order->order_code,
                    'order_total' => $orderTotal,
                    'calculated_total' => $totalAmount,
                    'difference' => abs($orderTotal - $totalAmount),
                    'item_count' => $itemCount,
                    'has_shipping' => $order->shipping_cost > 0,
                    'shipping_cost' => $order->shipping_cost ?? 0
                ];
                
                Log::error('Order total mismatch', $errorData);
                
                // Try to fix small rounding differences (less than 100 rupiah)
                if (abs($orderTotal - $totalAmount) <= 100) {
                    Log::warning('Small amount difference detected, adjusting total', [
                        'original_total' => $orderTotal,
                        'adjusted_total' => $totalAmount,
                        'difference' => $orderTotal - $totalAmount
                    ]);
                    $orderTotal = $totalAmount;
                } else {
                    throw new \Exception(sprintf(
                        'Total pembayaran tidak valid. Diharapkan: %s, Dihitung: %s (Selisih: %s)',
                        number_format($orderTotal, 0, ',', '.'),
                        number_format($totalAmount, 0, ',', '.'),
                        number_format(abs($orderTotal - $totalAmount), 0, ',', '.')
                    ));
                }
            }

            // Prepare transaction parameters for Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $order->order_code,
                    'gross_amount' => $orderTotal,
                ],
                'item_details' => $itemDetails,
                'customer_details' => [
                    'first_name' => substr(auth()->user()->name, 0, 20), // Limit name length
                    'email' => auth()->user()->email,
                    'phone' => substr(auth()->user()->phone ?? '08123456789', 0, 15), // Ensure phone is not empty
                ],
                'callbacks' => [
                    'finish' => route('dropshipper.payments.finish'),
                    'unfinish' => route('dropshipper.payments.unfinish'),
                    'error' => route('dropshipper.payments.error'),
                ],
            ];

            Log::debug('Midtrans request params', [
                'order_id' => $order->order_code,
                'gross_amount' => $orderTotal,
                'item_count' => count($itemDetails),
                'customer_email' => auth()->user()->email
            ]);

            // Validate server key is set
            if (empty(config('midtrans.server_key'))) {
                throw new \Exception('MIDTRANS_SERVER_KEY tidak di-set. Pastikan sudah di-set di file .env');
            }
            
            // Ensure Config is properly set before calling Snap API
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production', false);
            Config::$isSanitized = config('midtrans.is_sanitized', true);
            Config::$is3ds = config('midtrans.is_3ds', true);
            
            // Log the final request
            Log::info('Sending request to Midtrans API', [
                'order_id' => $order->id,
                'order_code' => $order->order_code,
                'gross_amount' => $orderTotal,
                'item_count' => count($itemDetails),
                'midtrans_env' => Config::$isProduction ? 'production' : 'sandbox',
                'server_key_exists' => !empty(Config::$serverKey),
                'server_key_prefix' => substr(Config::$serverKey, 0, 10) . '...'
            ]);
            
            try {
                // Call getSnapToken
                $snapToken = Snap::getSnapToken($params);
                
                if (empty($snapToken)) {
                    throw new \Exception('Gagal mendapatkan token pembayaran dari Midtrans: Response kosong');
                }
                
                // Save snap_token to order
                $order->snap_token = $snapToken;
                $order->save();

                Log::info('Successfully generated snap token', [
                    'order_id' => $order->id,
                    'token_length' => strlen($snapToken)
                ]);

                return response()->json([
                    'status' => 'success',
                    'snap_token' => $snapToken,
                    'client_key' => config('midtrans.client_key')
                ]);
            } catch (\Exception $e) {
                $errorCode = $e->getCode();
                $errorMessage = $e->getMessage();
                
                Log::error('Midtrans API Error', [
                    'order_id' => $order->id,
                    'error_code' => $errorCode,
                    'error_message' => $errorMessage,
                    'params' => $params,
                    'trace' => $e->getTraceAsString()
                ]);
                
                // Provide more specific error messages for common issues
                if (str_contains($errorMessage, '401')) {
                    throw new \Exception('Kesalahan otentikasi Midtrans. Pastikan server key dan client key sudah benar.');
                } elseif (str_contains($errorMessage, '400') || str_contains($errorMessage, 'validation')) {
                    throw new \Exception('Data transaksi tidak valid: ' . $errorMessage);
                } else {
                    throw new \Exception('Gagal memproses pembayaran: ' . $errorMessage);
                }
            }
            
        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error', [
                'error' => $e->getMessage(),
                'order_id' => $order->id ?? null,
                'order_code' => $order->order_code ?? null,
                'trace' => $e->getTraceAsString(),
            ]);
            
            $errorMessage = 'Gagal membuat token pembayaran. ';
            
            // Provide user-friendly error messages
            if (str_contains($e->getMessage(), 'ServerKey') || 
                str_contains($e->getMessage(), 'server_key') ||
                str_contains($e->getMessage(), '401')) {
                $errorMessage .= 'Kesalahan konfigurasi server. Silakan hubungi admin.';
            } elseif (str_contains($e->getMessage(), 'SSL') || 
                     str_contains($e->getMessage(), 'certificate')) {
                $errorMessage .= 'Masalah koneksi ke server pembayaran. Silakan coba lagi.';
            } else {
                $errorMessage = $e->getMessage();
            }
            
            return response()->json([
                'error' => $errorMessage,
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function finish(Request $request)
    {
        $orderId = $request->query('order_id');
        
        if ($orderId) {
            $order = Order::where('order_code', $orderId)->first();
            if ($order) {
                // Update order status to processing
                $order->update([
                    'payment_status' => 'diproses',
                    'status' => 'diproses'
                ]);
                
                // Log the successful payment
                Log::info('Payment marked as completed', [
                    'order_id' => $order->id,
                    'order_code' => $order->order_code,
                    'status' => 'completed'
                ]);
            }
        }
        
        return redirect()->route('dropshipper.orders')
            ->with('success', 'Pembayaran berhasil diproses. Terima kasih!');
    }

    public function unfinish(Request $request)
    {
        $orderId = $request->query('order_id');
        
        if ($orderId) {
            $order = Order::where('order_code', $orderId)->first();
            if ($order) {
                Log::warning('Payment marked as pending', [
                    'order_id' => $order->id,
                    'order_code' => $order->order_code,
                    'status' => 'pending'
                ]);
            }
        }
        
        return redirect()->route('dropshipper.payments.index')
            ->with('warning', 'Pembayaran belum selesai. Silakan selesaikan pembayaran atau hubungi kami jika ada kendala.');
    }

    public function error(Request $request)
    {
        $orderId = $request->query('order_id');
        $error = $request->query('error');
        
        if ($orderId) {
            $order = Order::where('order_code', $orderId)->first();
            if ($order) {
                Log::error('Payment error occurred', [
                    'order_id' => $order->id,
                    'order_code' => $order->order_code,
                    'error' => $error,
                    'status' => 'error'
                ]);
            }
        }
        
        $errorMessage = 'Terjadi kesalahan saat memproses pembayaran. ';
        
        if ($error) {
            if (str_contains($error, 'deny') || str_contains($error, 'denied')) {
                $errorMessage = 'Pembayaran ditolak. ';
            } elseif (str_contains($error, 'expire') || str_contains($error, 'expired')) {
                $errorMessage = 'Waktu pembayaran telah habis. ';
            } elseif (str_contains($error, 'cancel') || str_contains($error, 'cancelled')) {
                $errorMessage = 'Pembayaran dibatalkan. ';
            }
        }
        
        $errorMessage .= 'Silakan coba lagi atau hubungi kami untuk bantuan lebih lanjut.';
        
        return redirect()->route('dropshipper.payments.index')
            ->with('error', $errorMessage);
    }


}
