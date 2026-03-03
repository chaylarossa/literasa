@extends('layouts.pelanggan')

@section('title', 'Pesanan Saya - Literasa')

@section('content')
<div class="space-y-6">
    <h1 class="text-3xl font-bold text-gray-900">Pesanan Saya</h1>

    @if($pesanan->count() > 0)
    <div class="space-y-4">
        @foreach($pesanan as $order)
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="font-bold text-gray-900 text-lg">{{ $order->nomor_pesanan }}</p>
                    <p class="text-sm text-gray-600">{{ $order->tanggal_pesanan ? $order->tanggal_pesanan->format('d M Y, H:i') : '-' }}</p>
                </div>
                <span class="px-4 py-2 rounded-full text-sm font-semibold
                    @if($order->status_pesanan == 'menunggu_konfirmasi') bg-yellow-100 text-yellow-800
                    @elseif($order->status_pesanan == 'diproses') bg-blue-100 text-blue-800
                    @elseif($order->status_pesanan == 'dikirim') bg-purple-100 text-purple-800
                    @elseif($order->status_pesanan == 'selesai') bg-green-100 text-green-800
                    @else bg-red-100 text-red-800
                    @endif">
                    {{ str_replace('_', ' ', ucfirst($order->status_pesanan)) }}
                </span>
            </div>

            <div class="border-t border-b py-4 mb-4">
                @foreach($order->items as $item)
                <div class="flex items-center space-x-4 mb-3 last:mb-0">
                    <img src="{{ $item->buku->cover ? asset('storage/' . $item->buku->cover) : 'https://via.placeholder.com/80x120' }}" 
                         alt="{{ $item->buku->judul }}" 
                         class="w-16 h-24 object-cover rounded">
                    <div class="flex-1">
                        <p class="font-semibold text-gray-900">{{ $item->buku->judul }}</p>
                        <p class="text-sm text-gray-600">{{ $item->jumlah }} x Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                    </div>
                    <p class="font-bold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>

            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-600">Total Pembayaran</p>
                    <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('pelanggan.pesanan.invoice', $order->id_pesanan) }}" 
                       class="px-6 py-2 border border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 transition font-semibold">
                        Lihat Invoice
                    </a>
                    @if($order->status_pesanan == 'menunggu_konfirmasi')
                    <a href="https://wa.me/6285810621329?text=Halo%20Literasa,%20saya%20ingin%20konfirmasi%20pembayaran%20untuk%20pesanan%20{{ $order->nomor_pesanan }}" 
                       target="_blank"
                       class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition font-semibold">
                        Konfirmasi Pembayaran
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $pesanan->links() }}
    </div>
    @else
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
        </svg>
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Pesanan</h3>
        <p class="text-gray-600 mb-6">Mulai belanja dan buat pesanan pertamamu</p>
        <a href="{{ route('pelanggan.katalog.index') }}" 
           class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
            Mulai Belanja
        </a>
    </div>
    @endif
</div>
@endsection
