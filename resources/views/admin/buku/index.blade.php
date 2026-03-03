@extends('layouts.admin')

@section('title', 'Kelola Buku - Admin Literasa')
@section('page-title', 'Kelola Buku')

@section('content')
<!-- Success Message -->
@if(session('success'))
<div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded">
    <div class="flex items-center">
        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
        </svg>
        <p class="text-green-700 font-semibold">{{ session('success') }}</p>
    </div>
</div>
@endif

<div class="flex justify-between items-center mb-6">
    <div class="flex items-center space-x-4">
        <div class="flex space-x-2">
            <a href="{{ route('admin.buku.index') }}" class="px-4 py-2 rounded-lg transition text-sm font-semibold {{ request('status') ? 'bg-gray-100 text-gray-700 hover:bg-gray-200' : 'bg-blue-600 text-white hover:bg-blue-700' }}">
                Semua
            </a>
            <a href="{{ route('admin.buku.index', ['status' => 'aktif']) }}" class="px-4 py-2 rounded-lg transition text-sm font-semibold {{ request('status') === 'aktif' ? 'bg-blue-600 text-white hover:bg-blue-700' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Aktif
            </a>
            <a href="{{ route('admin.buku.index', ['status' => 'nonaktif']) }}" class="px-4 py-2 rounded-lg transition text-sm font-semibold {{ request('status') === 'nonaktif' ? 'bg-blue-600 text-white hover:bg-blue-700' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Nonaktif
            </a>
        </div>
    </div>
    <a href="{{ route('admin.buku.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition font-semibold flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Tambah Buku
    </a>
</div>

<!-- View Toggle -->
<div class="flex justify-end mb-4">
    <div class="flex space-x-2 bg-gray-100 rounded-lg p-1">
        <button class="p-2 bg-white rounded shadow-sm">
            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
            </svg>
        </button>
        <button class="p-2 hover:bg-white rounded transition">
            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
            </svg>
        </button>
    </div>
</div>

<!-- Products Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($buku as $book)
    <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden flex flex-col">
        <div class="relative">
            <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://via.placeholder.com/300x400/4F46E5/FFFFFF?text=' . urlencode($book->judul) }}" 
                 alt="{{ $book->judul }}" 
                 class="w-full h-64 object-cover">
            <span class="absolute top-2 left-2 px-2 py-1 bg-green-500 text-white text-xs font-semibold rounded">
                {{ $book->is_active ? 'Aktif' : 'Nonaktif' }}
            </span>
        </div>
        <div class="p-4 flex flex-col flex-grow">
            <h3 class="font-bold text-gray-900 mb-1 line-clamp-2">{{ $book->judul }}</h3>
            <p class="text-sm text-gray-600 mb-2">{{ $book->pengarang }}</p>
            <div class="flex justify-between items-center mb-3">
                <div>
                    <p class="text-xs text-gray-500">Harga</p>
                    <p class="text-lg font-bold text-blue-600">Rp {{ number_format($book->harga, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Stok</p>
                    <p class="text-lg font-bold text-gray-900">{{ $book->stok }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Kategori</p>
                    <p class="text-sm font-bold text-gray-900">{{ $book->kategori->nama_kategori ?? '-' }}</p>
                </div>
            </div>
            <div class="flex space-x-2 mt-auto">
                <a href="{{ route('admin.buku.edit', $book->id_buku) }}" class="flex-1 bg-blue-600 text-white text-center py-2 rounded hover:bg-blue-700 transition text-sm font-semibold">
                    Edit
                </a>
                <form action="{{ route('admin.buku.destroy', $book->id_buku) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700 transition text-sm font-semibold">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-12 bg-white rounded-lg shadow">
        <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
        </svg>
        <p class="text-gray-500">Belum ada buku. Tambahkan buku pertama Anda!</p>
    </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $buku->links() }}
</div>
@endsection
