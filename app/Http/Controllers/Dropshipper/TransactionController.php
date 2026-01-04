<?php

namespace App\Http\Controllers\Dropshipper;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    use ApiResponse;

    /**
     * Menampilkan halaman riwayat transaksi (frontend view)
     * Tidak diubah agar frontend tetap berfungsi
     */
    public function index()
    {
        return view('dropshipper.transactions');
    }

    /**
     * API: Daftar transaksi milik user (paginated)
     */
    public function indexApi(Request $request)
    {
        $perPage = $request->integer('per_page', 15);

        $query = Transaction::with(['order', 'payment'])
            ->whereHas('order', function ($q) {
                $q->where('user_id', auth()->id());
            });

        // Filters (safe, optional)
        if ($status = $request->string('status')->toString()) {
            $query->where('status', $status);
        }

        if ($paymentType = $request->string('payment_type')->toString()) {
            $query->where('payment_type', $paymentType);
        }

        if ($from = $request->query('from')) {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to = $request->query('to')) {
            $query->whereDate('created_at', '<=', $to);
        }

        if ($min = $request->input('amount_min')) {
            $query->where('amount', '>=', (float) $min);
        }
        if ($max = $request->input('amount_max')) {
            $query->where('amount', '<=', (float) $max);
        }

        if ($orderCode = $request->string('order_code')->toString()) {
            $query->where('midtrans_order_id', $orderCode)->orWhereHas('order', function ($q) use ($orderCode) {
                $q->where('order_code', $orderCode);
            });
        }

        $query->latest();

        $paginator = $query->paginate($perPage)->withQueryString();

        $data = $paginator->through(function ($trx) {
            return [
                'id' => $trx->id,
                'order_code' => $trx->midtrans_order_id ?? optional($trx->order)->order_code,
                'transaction_id' => $trx->transaction_id,
                'amount' => $trx->amount,
                'status' => $trx->status,
                'payment_type' => $trx->payment_type,
                'created_at' => $trx->created_at->toDateTimeString(),
            ];
        });

        return $this->paginated($data, null, 'Transactions list');
    }

    /**
     * API: Detail transaksi
     */
    public function showApi($id)
    {
        $trx = Transaction::with(['order.items.product', 'payment'])
            ->where('id', $id)
            ->whereHas('order', function ($q) {
                $q->where('user_id', auth()->id());
            })
            ->firstOrFail();

        $payload = [
            'id' => $trx->id,
            'transaction_id' => $trx->transaction_id,
            'order' => [
                'id' => $trx->order->id,
                'order_code' => $trx->order->order_code,
                'total' => $trx->order->total,
            ],
            'payment' => $trx->payment ? [
                'id' => $trx->payment->id,
                'status' => $trx->payment->status,
                'payment_method' => $trx->payment->payment_method ?? null,
            ] : null,
            'amount' => $trx->amount,
            'status' => $trx->status,
            'raw_response' => $trx->raw_response,
            'created_at' => $trx->created_at->toDateTimeString(),
        ];

        return $this->success($payload);
    }
}
