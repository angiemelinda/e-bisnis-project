@extends('layouts.dropshipper')

@section('title', 'Pembayaran')
@section('header', 'Pembayaran')


@section('content')
<h2>Daftar Pembayaran</h2>

@foreach($orders as $order)
    <div class="border p-4 mb-3">
        <p>Order: {{ $order->order_code }}</p>
        <p>Total: Rp {{ number_format($order->total) }}</p>

        <button
            class="pay-btn"
            data-id="{{ $order->id }}">
            Bayar
        </button>
    </div>
@endforeach
@endsection

@section('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}">
</script>

<script>
document.querySelectorAll('.pay-btn').forEach(btn => {
    btn.addEventListener('click', async () => {
        const orderId = btn.dataset.id;

        const res = await fetch(`/dropshipper/pay/${orderId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        const snapToken = await res.text();
        window.snap.pay(snapToken);
    });
});
</script>
@endsection
