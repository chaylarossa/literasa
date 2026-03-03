@extends('layouts.pelanggan')

@section('title', 'Keranjang Belanja - Literasa')

@section('content')
<div class="space-y-6">
    <h1 class="text-3xl font-bold text-gray-900">Keranjang Belanja</h1>

    @if($items->count() > 0)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Cart Items -->
        <div class="lg:col-span-2 space-y-4">
            @foreach($items as $item)
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex space-x-4">
                    <img src="{{ $item->buku->cover ? asset('storage/' . $item->buku->cover) : 'https://via.placeholder.com/150x200/4F46E5/FFFFFF?text=Book' }}" 
                         alt="{{ $item->buku->judul }}" 
                         class="w-24 h-32 object-cover rounded">
                    
                    <div class="flex-1">
                        <h3 class="font-bold text-gray-900 mb-1">{{ $item->buku->judul }}</h3>
                        <p class="text-sm text-gray-600 mb-2">{{ $item->buku->pengarang }}</p>
                        <p class="text-lg font-bold text-blue-600 mb-4">Rp {{ number_format($item->buku->harga, 0, ',', '.') }}</p>
                        
                        <div class="flex items-center space-x-4">
                            <form action="{{ route('pelanggan.keranjang.update', $item->id) }}" method="POST" class="flex items-center space-x-2">
                                @csrf
                                @method('PUT')
                                <label class="text-sm font-semibold text-gray-700">Jumlah:</label>
                                <input type="number" name="jumlah" value="{{ $item->jumlah }}" min="1" max="{{ $item->buku->stok }}" 
                                       class="w-20 px-3 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-blue-600 focus:border-transparent">
                                <button type="submit" class="text-blue-600 hover:text-blue-700 text-sm font-semibold">Update</button>
                            </form>
                            
                            <form action="{{ route('pelanggan.keranjang.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-semibold">Hapus</button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <p class="text-sm text-gray-600 mb-1">Subtotal</p>
                        <p class="text-xl font-bold text-gray-900">Rp {{ number_format($item->buku->harga * $item->jumlah, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Ringkasan Pesanan</h3>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal ({{ $items->count() }} item)</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Biaya Admin</span>
                        <span>Rp 0</span>
                    </div>
                    <div class="border-t pt-3">
                        <div class="flex justify-between text-lg font-bold text-gray-900">
                            <span>Total</span>
                            <span class="text-blue-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <a href="{{ route('pelanggan.pesanan.checkout') }}" 
                   class="block w-full bg-blue-600 text-white text-center py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                    Lanjut ke Checkout
                </a>
                
                <a href="{{ route('pelanggan.katalog.index') }}" 
                   class="block w-full text-center text-blue-600 hover:text-blue-700 mt-3 font-semibold">
                    Lanjut Belanja
                </a>
            </div>
        </div>
    </div>
    @else
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        <h3 class="text-2xl font-bold text-gray-900 mb-2">Keranjang Kosong</h3>
        <p class="text-gray-600 mb-6">Belum ada buku di keranjang Anda</p>
        <a href="{{ route('pelanggan.katalog.index') }}" 
           class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
            Mulai Belanja
        </a>
    </div>
    @endif
</div>
@endsection
