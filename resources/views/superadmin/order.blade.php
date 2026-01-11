@extends('layouts.admin')

@section('title', 'Manajemen Pesanan B2B')
@section('header', 'Manajemen Pesanan B2B')

@section('content')
<div class="space-y-6">
    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form method="GET" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Company Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Perusahaan</label>
                    <select name="company_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                        <option value="">Semua Perusahaan</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Terkirim</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <!-- Date Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pesanan</label>
                    <input type="date" name="order_date" value="{{ request('order_date') }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                </div>

                <!-- PO Number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor PO</label>
                    <input type="text" name="po_number" value="{{ request('po_number') }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500" 
                           placeholder="Masukkan nomor PO">
                </div>
            </div>

            <div class="flex justify-between items-center pt-2">
                <div class="text-sm text-gray-500">
                    Menampilkan {{ $orders->total() }} pesanan
                </div>
                <div class="flex space-x-2">
                    <button type="button" onclick="window.location.href='{{ route('superadmin.b2b.orders.index') }}'" 
                            class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                        Reset Filter
                    </button>
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                        <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Terapkan Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Orders List -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <div class="flex items-center">
                                Nomor Pesanan
                                <button type="button" class="ml-1" onclick="sortBy('order_number')">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                    </svg>
                                </button>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Perusahaan
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Aksi</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">#{{ $order->order_number }}</div>
                            <div class="text-xs text-gray-500">PO: {{ $order->po_number ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $order->company->name }}</div>
                            <div class="text-xs text-gray-500">{{ $order->company->pic_name ?? 'Tidak ada PIC' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $order->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900">
                            Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'processing' => 'bg-blue-100 text-blue-800',
                                    'shipped' => 'bg-indigo-100 text-indigo-800',
                                    'delivered' => 'bg-purple-100 text-purple-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ][$order->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('superadmin.b2b.orders.show', $order->id) }}" 
                               class="text-orange-600 hover:text-orange-900 mr-3">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                            Tidak ada data pesanan yang ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
        <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Menampilkan
                        <span class="font-medium">{{ $orders->firstItem() }}</span>
                        sampai
                        <span class="font-medium">{{ $orders->lastItem() }}</span>
                        dari
                        <span class="font-medium">{{ $orders->total() }}</span> hasil
                    </p>
                </div>
                <div>
                    {{ $orders->withQueryString()->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Order Detail Modal -->
<div id="orderDetailModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Detail Pesanan #<span id="orderNumber"></span>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500" id="orderDate"></p>
                    </div>
                    <button type="button" onclick="closeOrderModal()" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Tutup</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Order Summary -->
                    <div class="md:col-span-2">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-900 mb-3">Ringkasan Pesanan</h4>
                            <div id="orderItems" class="space-y-4">
                                <!-- Order items will be populated by JavaScript -->
                            </div>
                            <div class="mt-6 border-t border-gray-200 pt-4">
                                <div class="flex justify-between text-base font-medium text-gray-900">
                                    <p>Total</p>
                                    <p id="orderTotal"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Order Notes -->
                        <div class="mt-6">
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Catatan Pesanan</h4>
                            <p id="orderNotes" class="text-sm text-gray-500 italic">Tidak ada catatan</p>
                        </div>
                    </div>

                    <!-- Order Status Timeline -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Status Pesanan</h4>
                        <div class="flow-root">
                            <ul id="orderTimeline" class="-mb-8">
                                <!-- Timeline items will be populated by JavaScript -->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="closeOrderModal()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Function to format currency
    function formatCurrency(amount) {
        return new Intl.NumberFormat('id-ID', { 
            style: 'currency', 
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(amount).replace('IDR', 'Rp');
    }

    // Function to format date
    function formatDate(dateString) {
        const options = { 
            year: 'numeric', 
            month: 'short', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        };
        return new Date(dateString).toLocaleDateString('id-ID', options);
    }

    // Function to show order details in modal
    async function showOrderDetails(orderId) {
        try {
            // In a real application, you would fetch order details via AJAX
            // const response = await fetch(`/api/orders/${orderId}`);
            // const order = await response.json();
            
            // For demo purposes, we'll use a mock order
            const order = {
                id: orderId,
                order_number: 'B2B-' + orderId.toString().padStart(6, '0'),
                po_number: 'PO-' + Math.floor(100000 + Math.random() * 900000),
                company: {
                    name: 'PT. Contoh Perusahaan',
                    pic_name: 'Budi Santoso',
                    phone: '081234567890'
                },
                items: [
                    { 
                        product_name: 'Produk A', 
                        quantity: 10, 
                        price: 150000, 
                        total: 1500000,
                        sku: 'SKU-001'
                    },
                    { 
                        product_name: 'Produk B', 
                        quantity: 5, 
                        price: 250000, 
                        total: 1250000,
                        sku: 'SKU-002'
                    }
                ],
                subtotal: 2750000,
                tax: 275000,
                shipping_cost: 50000,
                grand_total: 3075000,
                status: 'processing',
                notes: 'Mohon dikirim segera, terima kasih.',
                created_at: new Date().toISOString(),
                updated_at: new Date().toISOString(),
                status_history: [
                    {
                        status: 'pending',
                        note: 'Pesanan diterima',
                        created_at: new Date(Date.now() - 86400000 * 2).toISOString()
                    },
                    {
                        status: 'processing',
                        note: 'Pesanan sedang diproses',
                        created_at: new Date(Date.now() - 86400000).toISOString()
                    },
                    {
                        status: 'shipped',
                        note: 'Pesanan telah dikirim',
                        created_at: new Date().toISOString()
                    }
                ]
            };

            // Update modal content
            document.getElementById('orderNumber').textContent = order.order_number;
            document.getElementById('orderDate').textContent = `Dibuat pada ${formatDate(order.created_at)}`;
            
            // Update order items
            const orderItemsContainer = document.getElementById('orderItems');
            orderItemsContainer.innerHTML = order.items.map(item => `
                <div class="flex justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900">${item.product_name}</p>
                        <p class="text-xs text-gray-500">${item.sku} • ${item.quantity} x ${formatCurrency(item.price)}</p>
                    </div>
                    <p class="text-sm font-medium text-gray-900 ml-4">${formatCurrency(item.total)}</p>
                </div>
            `).join('');

            // Update order total
            document.getElementById('orderTotal').textContent = formatCurrency(order.grand_total);

            // Update order notes
            const notesElement = document.getElementById('orderNotes');
            notesElement.textContent = order.notes || 'Tidak ada catatan';

            // Update status timeline
            const timelineContainer = document.getElementById('orderTimeline');
            const statuses = [
                { status: 'pending', label: 'Menunggu', icon: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z' },
                { status: 'processing', label: 'Diproses', icon: 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15' },
                { status: 'shipped', label: 'Dikirim', icon: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' },
                { status: 'delivered', label: 'Terkirim', icon: 'M5 13l4 4L19 7' },
                { status: 'completed', label: 'Selesai', icon: 'M5 13l4 4L19 7' }
            ];

            let timelineHTML = '';
            let currentStatusIndex = statuses.findIndex(s => s.status === order.status);
            
            statuses.forEach((status, index) => {
                const isActive = index <= currentStatusIndex;
                const isLast = index === statuses.length - 1;
                const statusHistory = order.status_history.find(sh => sh.status === status.status);
                const statusDate = statusHistory ? formatDate(statusHistory.created_at) : '';

                timelineHTML += `
                    <li>
                        <div class="relative pb-8">
                            ${!isLast ? '<span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>' : ''}
                            <div class="relative flex space-x-3">
                                <div>
                                    <span class="h-8 w-8 rounded-full ${isActive ? 'bg-orange-500' : 'bg-gray-300'} flex items-center justify-center ring-8 ring-white">
                                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${status.icon}" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div>
                                        <p class="text-sm ${isActive ? 'text-gray-900' : 'text-gray-500'}">${status.label}</p>
                                        ${statusDate ? `<p class="text-xs text-gray-500">${statusDate}</p>` : ''}
                                        ${statusHistory && statusHistory.note ? `<p class="text-xs text-gray-500 mt-1">${statusHistory.note}</p>` : ''}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                `;
            });

            timelineContainer.innerHTML = timelineHTML;

            // Show modal
            document.getElementById('orderDetailModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

        } catch (error) {
            console.error('Error fetching order details:', error);
            alert('Gagal memuat detail pesanan. Silakan coba lagi.');
        }
    }

    // Function to close order modal
    function closeOrderModal() {
        document.getElementById('orderDetailModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Close modal when clicking outside
    document.getElementById('orderDetailModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeOrderModal();
        }
    });

    // Sort functionality
    function sortBy(column) {
        const url = new URL(window.location.href);
        const sort = url.searchParams.get('sort');
        const direction = (sort === `-${column}`) ? column : `-${column}`;
        url.searchParams.set('sort', direction);
        window.location.href = url.toString();
    }

    // Initialize date picker
    document.addEventListener('DOMContentLoaded', function() {
        const dateInputs = document.querySelectorAll('input[type="date"]');
        dateInputs.forEach(input => {
            if (!input.value && input.name === 'order_date') {
                input.value = new Date().toISOString().split('T')[0];
            }
        });
    });
</script>
@endpush

@endsection