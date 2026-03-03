@extends('layouts.admin')

@section('title', 'Tambah Kategori - Admin Literasa')

@section('page-title', 'Tambah Kategori')

@section('content')
<div class="p-8">
    <div class="max-w-2xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf
                
                <div class="space-y-6">
                    <!-- Nama Kategori -->
                    <div>
                        <label for="nama_kategori" class="block text-sm font-semibold text-gray-700 mb-2">Nama Kategori *</label>
                        <input type="text" name="nama_kategori" id="nama_kategori" required
                               value="{{ old('nama_kategori') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('nama_kategori') border-red-500 @enderror">
                        @error('nama_kategori')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent">{{ old('deskripsi') }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">Opsional: Berikan deskripsi singkat tentang kategori ini</p>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('admin.kategori.index') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
