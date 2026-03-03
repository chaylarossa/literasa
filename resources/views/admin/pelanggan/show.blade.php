@extends('layouts.admin')

@section('title', 'Detail Pelanggan - Literasa')
@section('page-title', 'Detail Pelanggan')

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <a href="{{ route('admin.pelanggan.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-semibold">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Daftar Pelanggan
    </a>

    <!-- Customer Profile -->
    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="flex items-start justify-between mb-6">
            <div class="flex items-center">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-full flex items-center justify-center text-white text-3xl font-bold">
                    {{ strtoupper(substr($pelanggan->nama, 0, 1)) }}
                </div>
                <div class="ml-6">
                    <h2 class="text-3xl font-bold text-gray-900">{{ $pelanggan->nama }}</h2>
                    <p class="text-gray-600 mt-1">Pelanggan sejak {{ $pelanggan->created_at ? $pelanggan->created_at->format('d M Y') : '-' }}</p>
                    <div class="flex items-center space-x-3 mt-2">
                        @if($pelanggan->is_active)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                <span class="w-2 h-2 bg-red-500 rounded-full mr-2"></span>
                                Nonaktif
                            </span>
                        @endif
                        
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                            {{ $pelanggan->pesanan_count }} Pesanan
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="flex space-x-2">
                <form action="{{ route('admin.pelanggan.toggleStatus', $pelanggan->id_pengguna) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" 
                            class="px-4 py-2 {{ $pelanggan->is_active ? 'bg-orange-600 hover:bg-orange-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-lg transition font-semibold"
                            onclick="return confirm('Yakin ingin {{ $pelanggan->is_active ? 'menonaktifkan' : 'mengaktifkan' }} pelanggan ini?')">
                        {{ $pelanggan->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                </form>
                
                @if($pelanggan->no_hp)
                <a href="https://wa.me/{{ $pelanggan->no_hp }}" 
                   target="_blank"
                   class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition font-semibold">
                    <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                    </svg>
                    WhatsApp
                </a>
                @endif
            </div>
        </div>

        <!-- Customer Info Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-8 pt-8 border-t">
            <div>
                <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Informasi Kontak
                </h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-semibold text-gray-900">{{ $pelanggan->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">No. Telepon</p>
                        <p class="font-semibold text-gray-900">{{ $pelanggan->no_hp ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Alamat
                </h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Alamat Lengkap</p>
                        <p class="font-semibold text-gray-900">{{ $pelanggan->alamat ?? '-' }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Kota</p>
                            <p class="font-semibold text-gray-900">{{ $pelanggan->kota ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Kode Pos</p>
                            <p class="font-semibold text-gray-900">{{ $pelanggan->kode_pos ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Pesanan</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $pelanggan->pesanan_count }}</h3>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Belanja</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-2">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</h3>
                </div>
                <div class="bg-green-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Login Terakhir</p>
                    <h3 class="text-lg font-bold text-gray-900 mt-2">{{ $pelanggan->last_login ? $pelanggan->last_login->format('d M Y') : 'Belum pernah' }}</h3>
                </div>
                <div class="bg-purple-100 p-3 rounded-lg">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Order History -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-900">Riwayat Pesanan</h3>
        </div>

        @if($pesanan->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Invoice</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Item</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Total</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($pesanan as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900">{{ $order->nomor_pesanan }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $order->tanggal_pesanan ? $order->tanggal_pesanan->format('d M Y, H:i') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $order->items->count() }} item
                        </td>
                        <td class="px-6 py-4 text-right font-semibold text-gray-900">
                            Rp {{ number_format($order->total_pembayaran, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($order->status_pesanan == 'menunggu_konfirmasi') bg-yellow-100 text-yellow-800
                                @elseif($order->status_pesanan == 'diproses') bg-blue-100 text-blue-800
                                @elseif($order->status_pesanan == 'dikirim') bg-purple-100 text-purple-800
                                @elseif($order->status_pesanan == 'selesai') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ str_replace('_', ' ', ucfirst($order->status_pesanan)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.pesanan.show', $order->id_pesanan) }}" 
                               class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                                Lihat Detail →
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($pesanan->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $pesanan->links() }}
        </div>
        @endif
        @else
        <div class="px-6 py-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <p class="text-gray-500 text-lg font-semibold">Belum ada riwayat pesanan</p>
        </div>
        @endif
    </div>
</div>
@endsection
