@extends('layouts.admin')

@section('title', 'Edit Buku - Admin Literasa')

@section('page-title', 'Edit Buku')

@section('content')
<div class="p-8">
    <div class="max-w-4xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.buku.update', $buku->id_buku) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Judul -->
                    <div class="md:col-span-2">
                        <label for="judul" class="block text-sm font-semibold text-gray-700 mb-2">Judul Buku *</label>
                        <input type="text" name="judul" id="judul" required
                               value="{{ old('judul', $buku->judul) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('judul') border-red-500 @enderror">
                        @error('judul')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- ISBN -->
                    <div>
                        <label for="isbn" class="block text-sm font-semibold text-gray-700 mb-2">ISBN *</label>
                        <input type="text" name="isbn" id="isbn" required
                               value="{{ old('isbn', $buku->isbn) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('isbn') border-red-500 @enderror">
                        @error('isbn')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="id_kategori" class="block text-sm font-semibold text-gray-700 mb-2">Kategori *</label>
                        <select name="id_kategori" id="id_kategori" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('id_kategori') border-red-500 @enderror">
                            <option value="">Pilih Kategori</option>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->id_kategori }}" {{ old('id_kategori', $buku->id_kategori) == $kat->id_kategori ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kategori')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Pengarang -->
                    <div>
                        <label for="pengarang" class="block text-sm font-semibold text-gray-700 mb-2">Pengarang</label>
                        <input type="text" name="pengarang" id="pengarang"
                               value="{{ old('pengarang', $buku->pengarang) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent">
                    </div>

                    <!-- Penerbit -->
                    <div>
                        <label for="penerbit" class="block text-sm font-semibold text-gray-700 mb-2">Penerbit</label>
                        <input type="text" name="penerbit" id="penerbit"
                               value="{{ old('penerbit', $buku->penerbit) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent">
                    </div>

                    <!-- Harga -->
                    <div>
                        <label for="harga" class="block text-sm font-semibold text-gray-700 mb-2">Harga *</label>
                        <input type="number" name="harga" id="harga" required min="0"
                               value="{{ old('harga', $buku->harga) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('harga') border-red-500 @enderror">
                        @error('harga')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stok -->
                    <div>
                        <label for="stok" class="block text-sm font-semibold text-gray-700 mb-2">Stok *</label>
                        <input type="number" name="stok" id="stok" required min="0"
                               value="{{ old('stok', $buku->stok) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('stok') border-red-500 @enderror">
                        @error('stok')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cover -->
                    <div class="md:col-span-2">
                        <label for="cover" class="block text-sm font-semibold text-gray-700 mb-2">Cover Buku</label>
                        
                        @if($buku->cover)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Cover saat ini:</p>
                            <img src="{{ asset('storage/' . $buku->cover) }}" alt="{{ $buku->judul }}" 
                                 class="w-32 h-48 object-cover rounded-lg shadow">
                        </div>
                        @endif
                        
                        <input type="file" name="cover" id="cover" accept="image/*"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('cover') border-red-500 @enderror">
                        <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG (Max: 2MB) - Kosongkan jika tidak ingin mengubah cover</p>
                        @error('cover')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div class="md:col-span-2">
                        <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
                    </div>

                    <!-- Status -->
                    <div class="md:col-span-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $buku->is_active) ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-600">
                            <span class="ml-2 text-sm font-semibold text-gray-700">Aktif</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('admin.buku.index') }}" 
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
