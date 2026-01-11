@extends('layouts.dropshipper')

@section('title', 'Pembayaran')
@section('header', 'Pembayaran')

@section('content')
<div class="max-w-6xl mx-auto">
    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-900 mb-2">Daftar Pembayaran</h2>
        <p class="text-gray-600">Selesaikan pembayaran untuk pesanan Anda</p>
    </div>

    @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm hover:shadow-md transition">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-4 mb-3">
                                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $order->order_code }}</h3>
                                    <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                            
                            @if($order->items->count() > 0)
                                <div class="mb-3">
                                    <p class="text-sm text-gray-600 mb-2">Item:</p>
                                    <div class="space-y-1">
                                        @foreach($order->items->take(3) as $item)
                                            <div class="text-sm text-gray-700">
                                                • {{ $item->product->name ?? 'N/A' }} 
                                                <span class="text-gray-500">({{ $item->quantity }} pcs × Rp {{ number_format($item->price) }})</span>
                                            </div>
                                        @endforeach
                                        @if($order->items->count() > 3)
                                            <p class="text-sm text-gray-500">+ {{ $order->items->count() - 3 }} item lainnya</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            
                            <div class="flex items-center gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">Total:</span>
                                    <span class="font-bold text-lg text-orange-600 ml-2">Rp {{ number_format($order->total) }}</span>
                                </div>
                                @if($order->payment)
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">
                                        {{ ucfirst(str_replace('_', ' ', $order->payment->status)) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex-shrink-0">
                            <button
                                class="pay-btn px-6 py-3 bg-orange-500 text-white rounded-lg font-semibold hover:bg-orange-600 transition shadow-sm hover:shadow-md"
                                data-id="{{ $order->id }}"
                                data-order-code="{{ $order->order_code }}">
                                Bayar Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white border border-gray-200 rounded-lg p-12 text-center">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Tidak Ada Pembayaran Tertunda</h3>
            <p class="text-gray-600 mb-4">Semua pembayaran Anda telah diselesaikan.</p>
            <a href="{{ route('dropshipper.catalog') }}" class="inline-block px-6 py-2 bg-orange-500 text-white rounded-lg font-medium hover:bg-orange-600 transition">
                Lanjut Belanja
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<!-- Load jQuery first -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Then load Midtrans SDK -->
<script src="https://app.sandbox.midtrans.com/snap/snap.js" 
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<!-- Add loading overlay CSS -->
<style>
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        flex-direction: column;
        color: white;
    }
    .spinner {
        border: 5px solid #f3f3f3;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
        margin-bottom: 15px;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .pay-btn {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    .pay-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
    .pay-btn .spinner {
        display: none;
        width: 20px;
        height: 20px;
        margin-right: 8px;
        border-width: 3px;
        vertical-align: middle;
    }
    .pay-btn.loading .spinner {
        display: inline-block;
    }
</style>

<script>
// Self-executing function to avoid global scope pollution
(function() {
    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Payment script loaded');
        
        // Add styles
        const style = document.createElement('style');
        style.textContent = `
            .pay-btn {
                cursor: pointer !important;
                position: relative !important;
                z-index: 9999 !important;
            }
            .pay-btn:disabled {
                opacity: 0.7;
                cursor: not-allowed;
            }
            .animate-spin {
                animation: spin 1s linear infinite;
                display: inline-block;
            }
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);

                // Function to reset button state
        function resetButton(button, originalText) {
            if (button) {
                button.disabled = false;
                button.innerHTML = originalText || 'Bayar Sekarang';
            }
        }

        // Add click handler to document and delegate to .pay-btn
        document.addEventListener('click', function(e) {
            const button = e.target.closest('.pay-btn');
            if (!button || button.disabled) return;

            e.preventDefault();
            e.stopPropagation();

            const orderId = button.getAttribute('data-id');
            const orderCode = button.getAttribute('data-order-code');
            
            if (!orderId) {
                console.error('No order ID found');
                alert('Error: Order ID tidak valid');
                return;
            }

            console.log('Processing payment for order:', orderId);
            
            // Store original button state
            const originalText = button.innerHTML;
            
            // Disable button and show loading
            button.disabled = true;
            button.innerHTML = '<span class="animate-spin">⏳</span> Memproses...';

            // Add a timeout to prevent infinite loading
            const timeoutId = setTimeout(() => {
                console.warn('Payment request timeout');
                resetButton(button, originalText);
                alert('Waktu permintaan habis. Silakan coba lagi.');
            }, 30000); // 30 seconds timeout

            // Create form data
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

            // Make the request using fetch with timeout
            Promise.race([
                fetch(`/dropshipper/payments/${orderId}/pay`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                }),
                new Promise((_, reject) => 
                    setTimeout(() => reject(new Error('Request timeout')), 25000)
                )
            ])
            .then(response => {
                clearTimeout(timeoutId);
                if (!response.ok) {
                    return response.json().then(err => { 
                        throw new Error(err.message || 'Gagal memproses pembayaran'); 
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Payment response:', data);
                
                if (data.snap_token) {
                    if (typeof window.snap !== 'undefined') {
                        // Reset button before opening payment popup
                        resetButton(button, originalText);
                        
                        window.snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                console.log('Payment success', result);
                                window.location.href = `{{ route('dropshipper.payments.finish') }}?order_id=${orderId}`;
                            },
                            onPending: function(result) {
                                console.log('Payment pending', result);
                                window.location.href = `{{ route('dropshipper.payments.unfinish') }}?order_id=${orderId}`;
                            },
                            onError: function(result) {
                                console.error('Payment error', result);
                                window.location.href = `{{ route('dropshipper.payments.error') }}?order_id=${orderId}`;
                            },
                            onClose: function() {
                                console.log('Customer closed the payment popup');
                                // Don't reset button here as it might have been reset already
                            }
                        });
                    } else {
                        throw new Error('Payment gateway tidak dapat dimuat. Silakan muat ulang halaman.');
                    }
                } else {
                    throw new Error(data.message || 'Token pembayaran tidak ditemukan');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                clearTimeout(timeoutId);
                resetButton(button, originalText);
                
                // Show user-friendly error message
                let errorMessage = 'Terjadi kesalahan saat memproses pembayaran';
                if (error.message.includes('timeout')) {
                    errorMessage = 'Waktu permintaan habis. Silakan coba lagi.';
                } else if (error.message) {
                    errorMessage = error.message;
                }
                
                alert(errorMessage);
            });
        });

        console.log('Payment handler initialized');
    });
})();
</script>
@endpush