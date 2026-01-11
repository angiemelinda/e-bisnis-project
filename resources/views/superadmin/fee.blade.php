@extends('layouts.admin')

@section('title', 'Pengaturan Biaya Platform')
@section('header', 'Pengaturan Biaya Platform')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Fee Configuration Card -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-6">Atur Biaya Platform</h2>
            
            <div class="space-y-6">
                <!-- Current Fee Display -->
                <div class="bg-orange-50 border-l-4 border-orange-400 p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-orange-700">
                                Biaya platform saat ini: <span class="font-bold">{{ $currentFee }}%</span>
                            </p>
                            <p class="text-xs text-orange-600 mt-1">
                                Terakhir diperbarui: {{ $lastUpdated }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Fee Update Form -->
                <form id="updateFeeForm" action="{{ route('admin.platform-fee.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="fee_percentage" class="block text-sm font-medium text-gray-700 mb-1">
                            Persentase Biaya Baru
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm max-w-xs">
                            <input type="number" 
                                   name="fee_percentage" 
                                   id="fee_percentage"
                                   min="0" 
                                   max="100" 
                                   step="0.01"
                                   class="focus:ring-orange-500 focus:border-orange-500 block w-full pr-12 sm:text-sm border-gray-300 rounded-md p-2 border"
                                   placeholder="0.00"
                                   required>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">%</span>
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">
                            Masukkan persentase biaya platform (0-100%)
                        </p>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="button" 
                                onclick="confirmFeeUpdate()" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Fee History Card -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm p-6 h-full">
            <h2 class="text-lg font-semibold text-gray-800 mb-6">Riwayat Perubahan</h2>
            
            <div class="flow-root">
                <ul class="-mb-8">
                    @forelse($feeHistory as $history)
                    <li>
                        <div class="relative pb-8">
                            @if(!$loop->last)
                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                            @endif
                            <div class="relative flex space-x-3">
                                <div>
                                    @if($history->type === 'increase')
                                    <span class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center ring-8 ring-white">
                                        <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                        </svg>
                                    </span>
                                    @elseif($history->type === 'decrease')
                                    <span class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center ring-8 ring-white">
                                        <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                                        </svg>
                                    </span>
                                    @else
                                    <span class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center ring-8 ring-white">
                                        <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </span>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div>
                                        <p class="text-sm text-gray-500">
                                            Diubah menjadi <span class="font-medium text-gray-900">{{ $history->new_fee }}%</span>
                                            @if($history->previous_fee)
                                                @if($history->type === 'increase')
                                                    <span class="text-red-600">(+{{ number_format($history->new_fee - $history->previous_fee, 2) }}%)</span>
                                                @elseif($history->type === 'decrease')
                                                    <span class="text-green-600">({{ number_format($history->new_fee - $history->previous_fee, 2) }}%)</span>
                                                @endif
                                            @endif
                                        </p>
                                        <p class="text-xs text-gray-400">{{ $history->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    @empty
                    <li class="text-center py-4">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada riwayat</h3>
                        <p class="mt-1 text-sm text-gray-500">Belum ada perubahan biaya platform.</p>
                    </li>
                    @endforelse
                </ul>
            </div>

            @if($feeHistory->hasPages())
            <div class="mt-4">
                {{ $feeHistory->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmationModal" class="hidden fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-orange-100 sm:mx-0 sm:h-10 sm:w-10">
                    <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        Konfirmasi Perubahan Biaya
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            Anda akan mengubah biaya platform menjadi <span id="confirmFeeValue" class="font-bold"></span>.
                        </p>
                        <p class="text-sm text-gray-500 mt-2">
                            Perubahan ini akan berlaku untuk semua transaksi baru setelah disimpan.
                        </p>
                    </div>
                </div>
            </div>
            <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                <button type="button" 
                        onclick="document.getElementById('updateFeeForm').submit()" 
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-600 text-base font-medium text-white hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Ya, Simpan Perubahan
                </button>
                <button type="button" 
                        onclick="closeModal()" 
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:mt-0 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function confirmFeeUpdate() {
        const feeInput = document.getElementById('fee_percentage');
        const feeValue = parseFloat(feeInput.value);
        
        if (isNaN(feeValue) || feeValue < 0 || feeValue > 100) {
            alert('Masukkan persentase yang valid antara 0 dan 100');
            return;
        }
        
        document.getElementById('confirmFeeValue').textContent = feeValue + '%';
        openModal();
    }

    function openModal() {
        document.getElementById('confirmationModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal() {
        document.getElementById('confirmationModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Close modal when clicking outside
    document.getElementById('confirmationModal').addEventListener('click', function(e) {
        if (e.target.id === 'confirmationModal') {
            closeModal();
        }
    });
</script>
@endpush

@endsection