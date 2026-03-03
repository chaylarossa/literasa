@extends('layouts.pelanggan')

@section('title', 'Invoice #' . $pesanan->nomor_pesanan . ' - Literasa')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <!-- Header -->
        <div class="flex justify-between items-start mb-8 pb-8 border-b">
            <div>
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-lg flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold text-gray-900">Literasa</span>
                </div>
                <p class="text-gray-600">Toko Buku Online Terpercaya</p>
                <p class="text-gray-600">info@literasa.com</p>
                <p class="text-gray-600">+62 858-1062-1329</p>
            </div>
            <div class="text-right">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">INVOICE</h1>
                <p class="text-gray-600"><strong>No:</strong> {{ $pesanan->nomor_pesanan }}</p>
                <p class="text-gray-600"><strong>Tanggal:</strong> {{ $pesanan->tanggal_pesanan ? $pesanan->tanggal_pesanan->format('d M Y') : '-' }}</p>
                <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold mt-2
                    @if($pesanan->status_pesanan == 'menunggu_konfirmasi') bg-yellow-100 text-yellow-800
                    @elseif($pesanan->status_pesanan == 'diproses') bg-blue-100 text-blue-800
                    @elseif($pesanan->status_pesanan == 'dikirim') bg-purple-100 text-purple-800
                    @elseif($pesanan->status_pesanan == 'selesai') bg-green-100 text-green-800
                    @else bg-red-100 text-red-800
                    @endif">
                    {{ str_replace('_', ' ', ucfirst($pesanan->status_pesanan)) }}
                </span>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="grid grid-cols-2 gap-8 mb-8 pb-8 border-b">
            <div>
                <h3 class="font-bold text-gray-900 mb-3">Informasi Pelanggan</h3>
                <p class="text-gray-700"><strong>Nama:</strong> {{ $pesanan->user->nama }}</p>
                <p class="text-gray-700"><strong>Email:</strong> {{ $pesanan->user->email }}</p>
            </div>
            <div>
                <h3 class="font-bold text-gray-900 mb-3">Informasi Pengiriman</h3>
                <p class="text-gray-700"><strong>Nama Penerima:</strong> {{ $pesanan->nama_penerima }}</p>
                <p class="text-gray-700"><strong>Telepon:</strong> {{ $pesanan->no_hp }}</p>
                <p class="text-gray-700"><strong>Alamat:</strong> {{ $pesanan->alamat }}</p>
                <p class="text-gray-700"><strong>Kota:</strong> {{ $pesanan->kota }}, {{ $pesanan->kode_pos }}</p>
                <p class="text-gray-700"><strong>Ekspedisi:</strong> {{ $pesanan->ekspedisi }}</p>
            </div>
        </div>

        <!-- Order Items -->
        <div class="mb-8">
            <h3 class="font-bold text-gray-900 mb-4">Detail Pesanan</h3>
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Buku</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Harga</th>
                        <th class="px-4 py-3 text-center text-sm font-semibold text-gray-700">Jumlah</th>
                        <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($pesanan->items as $item)
                    <tr>
                        <td class="px-4 py-4">
                            <p class="font-semibold text-gray-900">{{ $item->buku->judul }}</p>
                            <p class="text-sm text-gray-600">{{ $item->buku->pengarang }}</p>
                        </td>
                        <td class="px-4 py-4 text-center text-gray-700">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td class="px-4 py-4 text-center text-gray-700">{{ $item->jumlah }}</td>
                        <td class="px-4 py-4 text-right font-semibold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="3" class="px-4 py-4 text-right font-bold text-gray-900">Total</td>
                        <td class="px-4 py-4 text-right font-bold text-blue-600 text-xl">Rp {{ number_format($pesanan->total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Payment Info -->
        <div class="bg-blue-50 rounded-lg p-6 mb-8">
            <h3 class="font-bold text-gray-900 mb-3">Metode Pembayaran</h3>
            <p class="text-gray-700 mb-4">
                <strong>
                    @if($pesanan->metode_pembayaran == 'transfer')
                        Transfer Bank
                    @elseif($pesanan->metode_pembayaran == 'ewallet')
                        E-Wallet
                    @elseif($pesanan->metode_pembayaran == 'qris')
                        QRIS
                    @endif
                </strong>
            </p>
            
            @if($pesanan->status_pesanan == 'menunggu_konfirmasi')
                @if($pesanan->metode_pembayaran == 'transfer')
                <div class="bg-white rounded-lg p-4">
                    <p class="text-sm text-gray-700 mb-2"><strong>Transfer ke salah satu rekening:</strong></p>
                    <p class="text-gray-700">Bank BCA - 1234567890</p>
                    <p class="text-gray-700">Bank Mandiri - 9876543210</p>
                    <p class="text-gray-700 text-sm mt-1">a.n. PT Literasa Indonesia</p>
                    <p class="text-sm text-gray-600 mt-3">
                        Setelah transfer, kirim bukti pembayaran via WhatsApp ke 
                        <a href="https://wa.me/6285810621329?text=Halo%20Literasa,%20saya%20ingin%20konfirmasi%20pembayaran%20untuk%20invoice%20{{ $pesanan->nomor_pesanan }}" 
                           target="_blank" 
                           class="text-blue-600 hover:text-blue-700 font-semibold">+62 858-1062-1329</a>
                    </p>
                </div>
                @elseif($pesanan->metode_pembayaran == 'ewallet')
                <div class="bg-white rounded-lg p-4">
                    <p class="text-sm text-gray-700 mb-2"><strong>Pilih salah satu E-Wallet:</strong></p>
                    <p class="text-gray-700">GoPay - 085810621329</p>
                    <p class="text-gray-700">OVO - 085810621329</p>
                    <p class="text-gray-700">Dana - 085810621329</p>
                    <p class="text-gray-700">ShopeePay - 085810621329</p>
                    <p class="text-sm text-gray-600 mt-3">
                        Setelah transfer, kirim bukti pembayaran via WhatsApp ke 
                        <a href="https://wa.me/6285810621329?text=Halo%20Literasa,%20saya%20ingin%20konfirmasi%20pembayaran%20untuk%20invoice%20{{ $pesanan->nomor_pesanan }}" 
                           target="_blank" 
                           class="text-blue-600 hover:text-blue-700 font-semibold">+62 858-1062-1329</a>
                    </p>
                </div>
                @elseif($pesanan->metode_pembayaran == 'qris')
                <div class="bg-white rounded-lg p-4 text-center">
                    <p class="text-sm text-gray-700 mb-3"><strong>Scan QRIS untuk pembayaran:</strong></p>
                    <div class="bg-gray-100 rounded-lg p-4 inline-block">
                        <img src="{{ asset('images/qris-demo.txt') }}" alt="QRIS" class="mx-auto max-w-[240px]" loading="lazy">
                    </div>
                    <p class="text-sm text-gray-600 mt-3">
                        Setelah scan, kirim bukti pembayaran via WhatsApp ke 
                        <a href="https://wa.me/6285810621329?text=Halo%20Literasa,%20saya%20ingin%20konfirmasi%20pembayaran%20untuk%20invoice%20{{ $pesanan->nomor_pesanan }}" 
                           target="_blank" 
                           class="text-blue-600 hover:text-blue-700 font-semibold">+62 858-1062-1329</a>
                    </p>
                </div>
                @endif
            @endif
        </div>

        @if($pesanan->catatan)
        <div class="mb-8">
            <h3 class="font-bold text-gray-900 mb-2">Catatan</h3>
            <p class="text-gray-700">{{ $pesanan->catatan }}</p>
        </div>
        @endif>

        <!-- Actions -->
        <div class="flex justify-between items-center pt-8 border-t">
            <a href="{{ route('pelanggan.pesanan.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold">
                ← Kembali ke Pesanan
            </a>
            <a href="https://wa.me/6285810621329?text=Halo%20Literasa,%20saya%20ingin%20bertanya%20tentang%20pesanan%20{{ $pesanan->nomor_pesanan }}" 
               target="_blank"
               class="inline-block px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                Hubungi Admin
            </a>
        </div>
    </div>
</div>
@endsection
