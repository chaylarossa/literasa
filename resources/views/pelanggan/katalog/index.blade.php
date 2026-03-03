@extends('layouts.pelanggan')

@section('title', 'Katalog Buku - Literasa')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Katalog Buku</h1>
        <p class="text-gray-600 mt-2">Temukan buku favoritmu dari koleksi kami</p>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('pelanggan.katalog.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Cari Buku</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Judul buku atau pengarang..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent">
            </div>

            <!-- Category Filter -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                <select name="kategori" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent">
                    <option value="">Semua Kategori</option>
                    @foreach($kategori as $kat)
                    <option value="{{ $kat->id_kategori }}" {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>
                        {{ $kat->nama_kategori }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Sort -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Urutkan</label>
                <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent">
                    <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                    <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Termurah</option>
                    <option value="termahal" {{ request('sort') == 'termahal' ? 'selected' : '' }}>Termahal</option>
                    <option value="terpopuler" {{ request('sort') == 'terpopuler' ? 'selected' : '' }}>Terpopuler</option>
                </select>
            </div>

            <div class="md:col-span-4 flex justify-end space-x-3">
                <a href="{{ route('pelanggan.katalog.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Reset
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Terapkan
                </button>
            </div>
        </form>
    </div>

    <!-- Results Count -->
    <div class="flex justify-between items-center">
        <p class="text-gray-600">Menampilkan <span class="font-semibold">{{ $buku->count() }}</span> dari <span class="font-semibold">{{ $buku->total() }}</span> buku</p>
    </div>

    <!-- Books Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($buku as $book)
        <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden flex flex-col">
            <a href="{{ route('pelanggan.katalog.show', $book->id_buku) }}" class="block">
                <div class="aspect-[2/3] overflow-hidden bg-gray-100">
                    <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://via.placeholder.com/300x400/4F46E5/FFFFFF?text=' . urlencode($book->judul) }}" 
                         alt="{{ $book->judul }}" 
                         class="w-full h-full object-cover hover:scale-105 transition duration-300">
                </div>
            </a>
            <div class="p-4 flex flex-col flex-grow">
                <a href="{{ route('pelanggan.katalog.show', $book->id_buku) }}" class="hover:text-blue-600">
                    <h3 class="font-bold text-gray-900 mb-1 line-clamp-2">{{ $book->judul }}</h3>
                </a>
                <p class="text-sm text-gray-600 mb-2">{{ $book->pengarang }}</p>
                <p class="text-xs text-gray-500 mb-3">{{ $book->kategori->nama_kategori ?? '-' }}</p>
                <div class="mt-auto">
                    <p class="text-xl font-bold text-blue-600 mb-3">Rp {{ number_format($book->harga, 0, ',', '.') }}</p>
                    @if($book->stok > 0)
                    <form action="{{ route('pelanggan.keranjang.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_buku" value="{{ $book->id_buku }}">
                        <input type="hidden" name="jumlah" value="1">
                        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition font-semibold">
                            + Keranjang
                        </button>
                    </form>
                    @else
                    <button disabled class="w-full bg-gray-300 text-gray-500 py-2 rounded-lg cursor-not-allowed">
                        Stok Habis
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-4 text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-gray-500 text-lg">Tidak ada buku yang ditemukan</p>
            <a href="{{ route('pelanggan.katalog.index') }}" class="text-blue-600 hover:text-blue-700 mt-2 inline-block">
                Reset pencarian
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $buku->links() }}
    </div>
</div>
@endsection
