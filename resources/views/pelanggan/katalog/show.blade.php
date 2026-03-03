@extends('layouts.pelanggan')

@section('title', $buku->judul . ' - Literasa')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex text-sm text-gray-600">
        <a href="{{ route('pelanggan.katalog.index') }}" class="hover:text-blue-600">Katalog</a>
        <span class="mx-2">/</span>
        <span class="text-gray-900">{{ $buku->judul }}</span>
    </nav>

    <!-- Book Detail -->
    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Book Cover -->
            <div>
                <div class="aspect-[2/3] overflow-hidden rounded-lg shadow-lg bg-gray-100">
                    <img src="{{ $buku->cover ? asset('storage/' . $buku->cover) : 'https://via.placeholder.com/600x900/4F46E5/FFFFFF?text=' . urlencode($buku->judul) }}" 
                         alt="{{ $buku->judul }}" 
                         class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Book Info -->
            <div class="flex flex-col">
                <div class="mb-2">
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold">
                        {{ $buku->kategori->nama_kategori ?? '-' }}
                    </span>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $buku->judul }}</h1>
                
                <div class="space-y-3 mb-6">
                    @if($buku->pengarang)
                    <div class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span><strong>Pengarang:</strong> {{ $buku->pengarang }}</span>
                    </div>
                    @endif

                    @if($buku->penerbit)
                    <div class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span><strong>Penerbit:</strong> {{ $buku->penerbit }}</span>
                    </div>
                    @endif

                    <div class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        <span><strong>ISBN:</strong> {{ $buku->isbn }}</span>
                    </div>

                    <div class="flex items-center text-gray-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <span><strong>Stok:</strong> {{ $buku->stok }} unit</span>
                    </div>
                </div>

                <div class="mb-6">
                    <p class="text-4xl font-bold text-blue-600">Rp {{ number_format($buku->harga, 0, ',', '.') }}</p>
                </div>

                @if($buku->deskripsi)
                <div class="mb-6">
                    <h3 class="font-bold text-gray-900 mb-2">Deskripsi</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $buku->deskripsi }}</p>
                </div>
                @endif

                <!-- Add to Cart Form -->
                @if($buku->stok > 0)
                <form action="{{ route('pelanggan.keranjang.add') }}" method="POST" class="mt-auto">
                    @csrf
                    <input type="hidden" name="id_buku" value="{{ $buku->id_buku }}">
                    <div class="flex items-center space-x-4 mb-4">
                        <label class="font-semibold text-gray-700">Jumlah:</label>
                        <input type="number" name="jumlah" value="1" min="1" max="{{ $buku->stok }}" 
                               class="w-24 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent">
                    </div>
                    <div class="flex space-x-4">
                        <button type="submit" class="flex-1 bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Tambah ke Keranjang
                        </button>
                    </div>
                </form>
                @else
                <div class="mt-auto">
                    <button disabled class="w-full bg-gray-300 text-gray-500 py-3 rounded-lg cursor-not-allowed font-semibold">
                        Stok Habis
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Related Books -->
    @if($relatedBooks->count() > 0)
    <div>
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Buku Terkait</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @foreach($relatedBooks as $related)
            <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden">
                <a href="{{ route('pelanggan.katalog.show', $related->id_buku) }}">
                    <div class="aspect-[2/3] overflow-hidden bg-gray-100">
                        <img src="{{ $related->cover ? asset('storage/' . $related->cover) : 'https://via.placeholder.com/300x400/4F46E5/FFFFFF?text=' . urlencode($related->judul) }}" 
                             alt="{{ $related->judul }}" 
                             class="w-full h-full object-cover hover:scale-105 transition duration-300">
                    </div>
                </a>
                <div class="p-4">
                    <a href="{{ route('pelanggan.katalog.show', $related->id_buku) }}" class="hover:text-blue-600">
                        <h3 class="font-bold text-gray-900 mb-1 line-clamp-2">{{ $related->judul }}</h3>
                    </a>
                    <p class="text-xl font-bold text-blue-600">Rp {{ number_format($related->harga, 0, ',', '.') }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
