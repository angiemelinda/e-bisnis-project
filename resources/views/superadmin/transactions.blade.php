@extends('layouts.superadmin')

@section('title', 'Daftar Transaksi')
@section('header', 'Transaksi')

@section('content')
<div class="bg-white shadow rounded-lg p-5 overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-orange-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">ID Transaksi</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Dropshipper</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Total</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($transactions as $trx)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $trx->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $trx->dropshipper->name ?? '-' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">${{ number_format($trx->total,2) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    @if($trx->status == 'completed')
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                    @elseif($trx->status == 'pending')
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                    @elseif($trx->status == 'cancelled')
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Batal</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $trx->created_at->format('Y-m-d H:i') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    <a href="{{ route('superadmin.transactions.show', $trx->id) }}" class="text-blue-500 hover:underline">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="mt-4">
    {{ $transactions->links() }}
</div>
@endsection
