@extends('layouts.admin')

@section('title', 'Edit Kategori - Admin Literasa')

@section('page-title', 'Edit Kategori')

@section('content')
<div class="p-8">
    <div class="max-w-2xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.kategori.update', $kategori->id_kategori) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <!-- Nama Kategori -->
                    <div>
                        <label for="nama_kategori" class="block text-sm font-semibold text-gray-700 mb-2">Nama Kategori *</label>
                        <input type="text" name="nama_kategori" id="nama_kategori" required
                               value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('nama_kategori') border-red-500 @enderror">
                        @error('nama_kategori')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent">{{ old('deskripsi', $kategori->deskripsi) }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">Opsional: Berikan deskripsi singkat tentang kategori ini</p>
                    </div>

                    <!-- Info Buku -->
                    @if($kategori->buku()->count() > 0)
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <p class="text-blue-700 text-sm">Kategori ini memiliki <strong>{{ $kategori->buku()->count() }} buku</strong></p>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('admin.kategori.index') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
