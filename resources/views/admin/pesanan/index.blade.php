@extends('layouts.admin')

@section('title', 'Kelola Pesanan - Literasa')
@section('page-title', 'Kelola Pesanan')

@section('content')
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <!-- Filter Tabs -->
    <div class="border-b border-gray-200">
        <nav class="flex space-x-8 px-6 py-4">
            <a href="{{ route('admin.pesanan.index') }}" class="pb-2 px-3 border-b-2 {{ !request('status') ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} font-medium text-sm transition whitespace-nowrap">
                Semua Pesanan
            </a>
            <a href="{{ route('admin.pesanan.index', ['status' => 'menunggu_konfirmasi']) }}" class="pb-2 px-3 border-b-2 {{ request('status') == 'menunggu_konfirmasi' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} font-medium text-sm transition whitespace-nowrap">
                Menunggu Konfirmasi
            </a>
            <a href="{{ route('admin.pesanan.index', ['status' => 'diproses']) }}" class="pb-2 px-3 border-b-2 {{ request('status') == 'diproses' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} font-medium text-sm transition whitespace-nowrap">
                Diproses
            </a>
            <a href="{{ route('admin.pesanan.index', ['status' => 'dikirim']) }}" class="pb-2 px-3 border-b-2 {{ request('status') == 'dikirim' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} font-medium text-sm transition whitespace-nowrap">
                Dikirim
            </a>
            <a href="{{ route('admin.pesanan.index', ['status' => 'selesai']) }}" class="pb-2 px-3 border-b-2 {{ request('status') == 'selesai' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} font-medium text-sm transition whitespace-nowrap">
                Selesai
            </a>
        </nav>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto mt-4">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No Invoice</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pembayaran</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($pesanan as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-semibold text-gray-900">{{ $order->nomor_pesanan }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $order->user->nama }}</div>
                        <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $order->tanggal_pesanan ? $order->tanggal_pesanan->format('d M Y, H:i') : '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm font-semibold text-gray-900">Rp {{ number_format($order->total_pembayaran, 0, ',', '.') }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="text-sm text-gray-600">
                            @if($order->metode_pembayaran == 'transfer')
                                Transfer Bank
                            @elseif($order->metode_pembayaran == 'ewallet')
                                E-Wallet
                            @else
                                QRIS
                            @endif
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($order->status_pesanan == 'menunggu_konfirmasi') bg-yellow-100 text-yellow-800
                            @elseif($order->status_pesanan == 'diproses') bg-blue-100 text-blue-800
                            @elseif($order->status_pesanan == 'dikirim') bg-purple-100 text-purple-800
                            @elseif($order->status_pesanan == 'selesai') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ str_replace('_', ' ', ucfirst($order->status_pesanan)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.pesanan.show', $order->id_pesanan) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-12 text-center">
                        <div class="text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="mt-4 text-sm">Tidak ada pesanan</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $pesanan->links() }}
    </div>
</div>
@endsection
