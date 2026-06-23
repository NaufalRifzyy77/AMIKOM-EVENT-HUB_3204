@extends('layouts.admin')

@section('title', 'Laporan Transaksi - Admin')
@section('page_title', 'Laporan Transaksi')
@section('page_subtitle', 'Pantau arus kas dan penjualan tiket Anda.')

@section('content')
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <!-- Table Wrapper -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <!-- Table Header -->
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Order ID</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Detail Pembeli</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Event</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Tgl Transaksi</th>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-slate-900">Status</th>
                    <th class="px-6 py-4 text-right text-sm font-semibold text-slate-900">Total Tagihan</th>
                </tr>
            </thead>

            <!-- Table Body -->
            <tbody class="divide-y divide-slate-200">
                @forelse($transactions as $trx)
                <tr class="{{ $trx->status == 'pending' ? 'text-slate-400' : '' }}">
                    <!-- Order ID -->
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $trx->status == 'pending' ? 'bg-slate-100' : 'text-indigo-600 bg-indigo-50' }}">
                            {{ $trx->order_id }}
                        </span>
                    </td>

                    <!-- Detail Pembeli -->
                    <td class="px-6 py-4">
                        <div class="space-y-1">
                            <p class="font-semibold text-slate-900">{{ $trx->customer_name }}</p>
                            <p class="text-xs text-slate-500">{{ $trx->customer_email }}</p>
                            <p class="text-xs text-slate-500">{{ $trx->customer_phone }}</p>
                        </div>
                    </td>

                    <!-- Event -->
                    <td class="px-6 py-4">
                        <p class="text-slate-900 font-medium">{{ $trx->event->title ?? '-' }}</p>
                    </td>

                    <!-- Tgl Transaksi -->
                    <td class="px-6 py-4">
                        <p class="text-slate-600">{{ $trx->created_at->format('d M Y, H:i') }}</p>
                    </td>

                    <!-- Status -->
                    <td class="px-6 py-4">
                        @if($trx->status === 'settlement' || $trx->status === 'success')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                Success
                            </span>
                        @elseif($trx->status === 'pending')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-800">
                                {{ ucfirst($trx->status) }}
                            </span>
                        @endif
                    </td>

                    <!-- Total Tagihan -->
                    <td class="px-6 py-4 text-right {{ $trx->status == 'pending' ? '' : 'text-slate-900' }}">
                        <p class="font-semibold">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</p>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center gap-2">
                            <svg class="w-12 h-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <p class="text-slate-500 font-medium">Belum ada transaksi</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($transactions->hasPages())
    <div class="px-6 py-4 border-t border-slate-200">
        {{ $transactions->links() }}
    </div>
    @endif
</div>
@endsection
