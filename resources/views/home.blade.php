@extends('layouts.app')

@section('title', 'Literasa - Toko Buku Online Terpercaya')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-blue-600 via-blue-500 to-indigo-600 py-24 overflow-hidden">
    <!-- Decorative elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-white opacity-10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-white opacity-10 rounded-full blur-3xl"></div>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="text-white">
                <h1 class="text-6xl font-extrabold mb-6 leading-tight">
                    Temukan Buku<br>
                    <span class="text-yellow-300">Favoritmu</span>
                </h1>
                <p class="text-xl text-blue-100 mb-10 leading-relaxed">
                    Jelajahi dunia di mana setiap halaman membawa petualangan baru. Di Literasa, kami menyediakan koleksi buku yang beragam dan berkualitas.
                </p>
                <a href="{{ route('login') }}" class="inline-flex items-center bg-white text-blue-600 px-8 py-4 rounded-full text-lg font-bold hover:bg-yellow-300 hover:text-blue-800 transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                    Jelajahi Sekarang
                    <svg class="w-6 h-6 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
            <div class="relative">
                <!-- Book Slider -->
                <div class="flex space-x-6 justify-center">
                    @foreach($bukuPopuler->take(3) as $index => $buku)
                    <div class="flex-shrink-0 w-44 transform {{ $index === 1 ? 'scale-110 -rotate-2' : ($index === 0 ? 'rotate-6' : '-rotate-6') }} transition-transform duration-300 hover:scale-125 hover:rotate-0">
                        <img src="{{ $buku->cover ? asset('storage/' . $buku->cover) : 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=300&h=450&fit=crop' }}" 
                             alt="{{ $buku->judul }}" 
                             class="w-full h-64 object-cover rounded-xl shadow-2xl border-4 border-white">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section -->
<section id="tentang" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Tentang Literasa</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Toko buku online terpercaya dengan koleksi beragam dan harga terjangkau
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center mb-16">
            <div>
                <img src="https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=600" alt="Toko Buku" class="rounded-lg shadow-xl">
            </div>
            <div>
                <h3 class="text-3xl font-bold text-gray-900 mb-4">Cerita Kami</h3>
                <p class="text-gray-600 mb-4">
                    Literasa didirikan dengan misi sederhana: membuat buku berkualitas dapat diakses oleh semua orang. Kami percaya bahwa membaca membuka dunia baru dan memperluas wawasan.
                </p>
                <p class="text-gray-600 mb-4">
                    Dengan ribuan judul dari berbagai genre, kami berkomitmen untuk membantu Anda menemukan bacaan favorit berikutnya. Dari bestseller hingga permata tersembunyi, koleksi kami memiliki sesuatu untuk setiap pembaca.
                </p>
                <p class="text-gray-600">
                    Bergabunglah dengan komunitas pecinta buku kami dan temukan kegembiraan membaca bersama Literasa.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-6">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Pilihan Berkualitas</h3>
                <p class="text-gray-600">Buku pilihan berkualitas dari penerbit terpercaya</p>
            </div>
            <div class="text-center p-6">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Harga Terjangkau</h3>
                <p class="text-gray-600">Harga kompetitif dan promo menarik setiap bulan</p>
            </div>
            <div class="text-center p-6">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Pengiriman Cepat</h3>
                <p class="text-gray-600">Pengiriman cepat dan terpercaya ke seluruh Indonesia</p>
            </div>
        </div>
    </div>
</section>

<!-- Recommended Books Section -->
<section class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-12">
            <h2 class="text-4xl font-bold text-gray-900">Rekomendasi Untuk Anda</h2>
            <a href="{{ route('login') }}" class="flex items-center text-blue-600 hover:text-blue-700 font-semibold text-lg group">
                Lihat Semua
                <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @foreach($bukuPopuler as $buku)
            <div class="group flex flex-col">
                <a href="{{ route('buku.show', $buku->id_buku) }}" class="block flex-1 flex flex-col">
                    <div class="relative overflow-hidden rounded-2xl shadow-lg mb-4 aspect-[2/3] transform transition-all duration-300 group-hover:shadow-2xl group-hover:-translate-y-2">
                        <img src="{{ $buku->cover ? asset('storage/' . $buku->cover) : 'https://images.unsplash.com/photo-1543002588-bfa74002ed7e?w=400&h=600&fit=crop' }}" 
                             alt="{{ $buku->judul }}" 
                             class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <div class="space-y-2 flex-1 flex flex-col">
                        <h3 class="font-bold text-gray-900 line-clamp-2 group-hover:text-blue-600 transition-colors leading-tight min-h-[2.5rem]">{{ $buku->judul }}</h3>
                        <p class="text-sm text-gray-500 line-clamp-1">{{ $buku->pengarang ?? 'Unknown' }}</p>
                        <div class="flex items-center justify-between">
                            <div class="flex text-yellow-400 text-xs">
                                ★★★★★
                            </div>
                            <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-full line-clamp-1">{{ $buku->kategori->nama_kategori ?? '' }}</span>
                        </div>
                        <p class="text-xl font-bold text-blue-600 mt-auto">Rp {{ number_format($buku->harga, 0, ',', '.') }}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
