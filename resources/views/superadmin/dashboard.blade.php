@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('header', 'Dashboard')

@section('content')

                <!-- Logout Superadmin -->
                <div class="flex justify-end mb-4">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow">
                            Logout
                        </button>
                    </form>
                </div>
                
                <!-- KPI Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Total Orders -->
                    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-orange-50 rounded-lg">
                                <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-medium {{ $ordersGrowth >= 0 ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50' }} px-2 py-1 rounded">{{ $ordersGrowth >= 0 ? '+' : '' }}{{ number_format($ordersGrowth, 1) }}%</span>
                        </div>
                        <h3 class="text-gray-500 text-sm font-medium mb-1">Total Orders</h3>
                        <p class="text-3xl font-bold text-orange-500">{{ number_format($totalOrders) }}</p>
                        <p class="text-xs text-gray-400 mt-2">Order bulan ini</p>
                    </div>

                    <!-- Payment Status -->
                    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-orange-50 rounded-lg">
                                <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-orange-600 bg-orange-50 px-2 py-1 rounded">{{ number_format($paymentSuccessRate, 1) }}%</span>
                        </div>
                        <h3 class="text-gray-500 text-sm font-medium mb-1">Payment Success</h3>
                        <p class="text-3xl font-bold text-orange-500">{{ number_format($paidOrders) }}</p>
                        <p class="text-xs text-gray-400 mt-2">{{ number_format($pendingPayment) }} pending payment</p>
                    </div>

                    <!-- Total Transactions -->
                    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-orange-50 rounded-lg">
                                <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-medium {{ $revenueGrowth >= 0 ? 'text-green-600 bg-green-50' : 'text-red-600 bg-red-50' }} px-2 py-1 rounded">{{ $revenueGrowth >= 0 ? '+' : '' }}{{ number_format($revenueGrowth, 1) }}%</span>
                        </div>
                        <h3 class="text-gray-500 text-sm font-medium mb-1">Total Transaksi</h3>
                        <p class="text-3xl font-bold text-orange-500">Rp {{ number_format($totalRevenue / 1000000, 1) }}M</p>
                        <p class="text-xs text-gray-400 mt-2">Volume transaksi bulan ini</p>
                    </div>

                    <!-- Platform Fees -->
                    <div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-orange-50 rounded-lg">
                                <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-1 rounded">{{ number_format(($revenueGrowth * 0.1), 1) }}%</span>
                        </div>
                        <h3 class="text-gray-500 text-sm font-medium mb-1">Biaya Platform</h3>
                        <p class="text-3xl font-bold text-orange-500">Rp {{ number_format($platformFees / 1000, 0) }}K</p>
                        <p class="text-xs text-gray-400 mt-2">Fee terkumpul bulan ini</p>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Transaction Trend Chart -->
                    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">Tren Transaksi</h3>
                                <p class="text-sm text-gray-500">7 hari terakhir</p>
                            </div>
                            <select class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500">
                                <option>7 Hari</option>
                                <option>30 Hari</option>
                                <option>90 Hari</option>
                            </select>
                        </div>
                        <canvas id="transactionChart" height="80"></canvas>
                    </div>

                    <!-- Payment Status Donut Chart -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-800">Status Pembayaran</h3>
                            <p class="text-sm text-gray-500">Distribusi status</p>
                        </div>
                        <div class="flex justify-center mb-4">
                            <canvas id="paymentChart" width="200" height="200"></canvas>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                                    <span class="text-sm text-gray-600">Lunas</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-800">{{ number_format($paymentDistribution['paid'], 1) }}%</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></span>
                                    <span class="text-sm text-gray-600">Pending</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-800">{{ number_format($paymentDistribution['pending'], 1) }}%</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                                    <span class="text-sm text-gray-600">Gagal</span>
                                </div>
                                <span class="text-sm font-semibold text-gray-800">{{ number_format($paymentDistribution['failed'], 1) }}%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="mt-6 bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Aktivitas Terbaru</h3>
                    <div class="space-y-4">
                        @forelse($recentActivities as $activity)
                        <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-4
                                    {{ $activity['icon'] === 'check' ? 'bg-green-100' : ($activity['icon'] === 'order' ? 'bg-orange-100' : 'bg-blue-100') }}">
                                    @if($activity['icon'] === 'check')
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    @elseif($activity['icon'] === 'order')
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                    @else
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">{{ $activity['message'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $activity['detail'] }}</p>
                                </div>
                            </div>
                            <span class="text-xs text-gray-400">{{ $activity['time'] }}</span>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500">
                            <p>Tidak ada aktivitas terbaru</p>
                        </div>
                        @endforelse
                    </div>
                </div>
@endsection

@push('scripts')
<script>
    // Transaction Trend Chart
    const ctx1 = document.getElementById('transactionChart').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: {!! json_encode($trendLabels) !!},
            datasets: [{
                label: 'Transaksi (Juta Rp)',
                data: {!! json_encode($trendData) !!},
                borderColor: '#F97316',
                backgroundColor: 'rgba(249, 115, 22, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointBackgroundColor: '#F97316',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value + 'M';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Payment Status Donut Chart
    const ctx2 = document.getElementById('paymentChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Lunas', 'Pending', 'Gagal'],
            datasets: [{
                data: [{{ number_format($paymentDistribution['paid'], 1) }}, {{ number_format($paymentDistribution['pending'], 1) }}, {{ number_format($paymentDistribution['failed'], 1) }}],
                backgroundColor: ['#10B981', '#F59E0B', '#EF4444'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            cutout: '70%',
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endpush

