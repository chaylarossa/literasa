@extends('layouts.admin')

@section('title', 'Detail Pesanan - Literasa')
@section('page-title', 'Detail Pesanan')

@section('content')
<div class="space-y-6">
    <!-- Order Info -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $pesanan->nomor_pesanan }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ $pesanan->tanggal_pesanan ? $pesanan->tanggal_pesanan->format('d M Y, H:i') : '-' }}</p>
            </div>
            <span class="px-4 py-2 rounded-full text-sm font-semibold
                @if($pesanan->status_pesanan == 'menunggu_konfirmasi') bg-yellow-100 text-yellow-800
                @elseif($pesanan->status_pesanan == 'diproses') bg-blue-100 text-blue-800
                @elseif($pesanan->status_pesanan == 'dikirim') bg-purple-100 text-purple-800
                @elseif($pesanan->status_pesanan == 'selesai') bg-green-100 text-green-800
                @else bg-red-100 text-red-800
                @endif">
                {{ str_replace('_', ' ', ucfirst($pesanan->status_pesanan)) }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Customer Info -->
            <div>
                <h3 class="font-bold text-gray-900 mb-3">Informasi Pelanggan</h3>
                <div class="space-y-2 text-sm">
                    <p><span class="text-gray-600">Nama:</span> <span class="font-medium">{{ $pesanan->user->nama }}</span></p>
                    <p><span class="text-gray-600">Email:</span> <span class="font-medium">{{ $pesanan->user->email }}</span></p>
                    <p><span class="text-gray-600">No HP:</span> <span class="font-medium">{{ $pesanan->user->no_hp }}</span></p>
                </div>
            </div>

            <!-- Shipping Info -->
            <div>
                <h3 class="font-bold text-gray-900 mb-3">Informasi Pengiriman</h3>
                <div class="space-y-2 text-sm">
                    <p><span class="text-gray-600">Penerima:</span> <span class="font-medium">{{ $pesanan->nama_penerima }}</span></p>
                    <p><span class="text-gray-600">No HP:</span> <span class="font-medium">{{ $pesanan->no_hp }}</span></p>
                    <p><span class="text-gray-600">Alamat:</span> <span class="font-medium">{{ $pesanan->alamat }}</span></p>
                    <p><span class="text-gray-600">Kota:</span> <span class="font-medium">{{ $pesanan->kota }}, {{ $pesanan->kode_pos }}</span></p>
                    <p><span class="text-gray-600">Ekspedisi:</span> <span class="font-medium">{{ $pesanan->ekspedisi }}</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="font-bold text-gray-900 mb-4">Item Pesanan</h3>
        <div class="space-y-4">
            @foreach($pesanan->items as $item)
            <div class="flex items-center space-x-4 pb-4 border-b last:border-b-0">
                <img src="{{ $item->buku->cover ? asset('storage/' . $item->buku->cover) : 'https://via.placeholder.com/80x120' }}" 
                     alt="{{ $item->buku->judul }}" 
                     class="w-16 h-24 object-cover rounded">
                <div class="flex-1">
                    <p class="font-semibold text-gray-900">{{ $item->buku->judul }}</p>
                    <p class="text-sm text-gray-600">{{ $item->buku->pengarang }}</p>
                    <p class="text-sm text-gray-600 mt-1">{{ $item->jumlah }} x Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                </div>
                <p class="font-bold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
            </div>
            @endforeach
        </div>

        <!-- Total -->
        <div class="mt-6 pt-6 border-t space-y-2">
            <div class="flex justify-between text-sm">
                <span class="text-gray-600">Subtotal Produk</span>
                <span class="font-medium">Rp {{ number_format($pesanan->total_produk, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-600">Ongkir ({{ $pesanan->ekspedisi }})</span>
                <span class="font-medium">Rp {{ number_format($pesanan->ongkir, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between text-lg font-bold pt-2 border-t">
                <span>Total Pembayaran</span>
                <span class="text-blue-600">Rp {{ number_format($pesanan->total_pembayaran, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Payment Info -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="font-bold text-gray-900 mb-3">Metode Pembayaran</h3>
        <p class="text-gray-700">
            @if($pesanan->metode_pembayaran == 'transfer')
                <span class="font-semibold">Transfer Bank</span>
            @elseif($pesanan->metode_pembayaran == 'ewallet')
                <span class="font-semibold">E-Wallet</span>
            @else
                <span class="font-semibold">QRIS</span>
            @endif
        </p>
    </div>

    <!-- Update Status -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="font-bold text-gray-900 mb-4">Update Status Pesanan</h3>
        <form action="{{ route('admin.pesanan.updateStatus', $pesanan->id_pesanan) }}" method="POST" class="flex items-center space-x-4">
            @csrf
            @method('PUT')
            <select name="status_pesanan" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent">
                <option value="menunggu_konfirmasi" {{ $pesanan->status_pesanan == 'menunggu_konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                <option value="diproses" {{ $pesanan->status_pesanan == 'diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="dikirim" {{ $pesanan->status_pesanan == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                <option value="selesai" {{ $pesanan->status_pesanan == 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="dibatalkan" {{ $pesanan->status_pesanan == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-semibold">
                Update Status
            </button>
        </form>
    </div>

    <!-- Actions -->
    <div class="flex space-x-4">
        <a href="{{ route('admin.pesanan.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition font-semibold">
            Kembali
        </a>
        <a href="https://wa.me/{{ $pesanan->no_hp }}?text=Halo%20{{ $pesanan->nama_penerima }},%20pesanan%20{{ $pesanan->nomor_pesanan }}%20Anda" 
           target="_blank"
           class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition font-semibold">
            Hubungi via WhatsApp
        </a>
    </div>
</div>
@endsection
