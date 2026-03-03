@extends('layouts.pelanggan')

@section('title', 'Checkout - Literasa')

@section('content')
<div class="space-y-6">
    <h1 class="text-3xl font-bold text-gray-900">Checkout</h1>

    <form action="{{ route('pelanggan.pesanan.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @csrf
        
        <!-- Checkout Form -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Shipping Info -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Informasi Pengiriman</h2>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Penerima *</label>
                        <input type="text" name="nama_penerima" required value="{{ old('nama_penerima', Auth::user()->nama) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('nama_penerima') border-red-500 @enderror">
                        @error('nama_penerima')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon *</label>
                        <input type="tel" name="no_hp" required value="{{ old('no_hp', Auth::user()->no_hp ?? '') }}"
                               placeholder="08xxxxxxxxxx"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('no_hp') border-red-500 @enderror">
                        @error('no_hp')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap *</label>
                        <textarea name="alamat" required rows="4"
                                  placeholder="Jl. Contoh No. 123, RT/RW 001/002"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('alamat') border-red-500 @enderror">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Kota *</label>
                            <input type="text" name="kota" required value="{{ old('kota') }}"
                                   placeholder="Jakarta"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('kota') border-red-500 @enderror">
                            @error('kota')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Pos *</label>
                            <input type="text" name="kode_pos" required value="{{ old('kode_pos') }}"
                                   placeholder="12345"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('kode_pos') border-red-500 @enderror">
                            @error('kode_pos')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Ekspedisi *</label>
                        <select name="ekspedisi" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('ekspedisi') border-red-500 @enderror">
                            <option value="">Pilih Ekspedisi</option>
                            <option value="JNE" {{ old('ekspedisi') == 'JNE' ? 'selected' : '' }}>JNE</option>
                            <option value="J&T" {{ old('ekspedisi') == 'J&T' ? 'selected' : '' }}>J&T Express</option>
                            <option value="SiCepat" {{ old('ekspedisi') == 'SiCepat' ? 'selected' : '' }}>SiCepat</option>
                            <option value="AnterAja" {{ old('ekspedisi') == 'AnterAja' ? 'selected' : '' }}>AnterAja</option>
                        </select>
                        @error('ekspedisi')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Ongkos Kirim *</label>
                        <input type="number" name="ongkir" required value="{{ old('ongkir', 10000) }}" min="0" step="1000"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent @error('ongkir') border-red-500 @enderror">
                        <p class="mt-1 text-sm text-gray-500">Estimasi ongkir Rp 10.000 - Rp 50.000</p>
                        @error('ongkir')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Metode Pembayaran</h2>
                
                <div class="space-y-3">
                    <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="metode_pembayaran" value="transfer" required checked
                               class="w-4 h-4 text-blue-600 focus:ring-blue-600">
                        <div class="ml-3">
                            <p class="font-semibold text-gray-900">Transfer Bank</p>
                            <p class="text-sm text-gray-600">BCA - 1234567890 | Mandiri - 9876543210</p>
                        </div>
                    </label>

                    <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="metode_pembayaran" value="ewallet" required
                               class="w-4 h-4 text-blue-600 focus:ring-blue-600">
                        <div class="ml-3">
                            <p class="font-semibold text-gray-900">E-Wallet</p>
                            <p class="text-sm text-gray-600">GoPay, OVO, Dana, ShopeePay</p>
                        </div>
                    </label>

                    <label class="flex items-center p-4 border border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="metode_pembayaran" value="qris" required
                               class="w-4 h-4 text-blue-600 focus:ring-blue-600">
                        <div class="ml-3">
                            <p class="font-semibold text-gray-900">QRIS</p>
                            <p class="text-sm text-gray-600">Scan QRIS untuk pembayaran</p>
                        </div>
                    </label>

                    <div id="qris-demo" class="hidden border border-dashed border-gray-300 rounded-lg p-4 bg-gray-50">
                        <p class="text-sm text-gray-700 font-semibold mb-3">QRIS</p>
                        <div class="bg-white rounded-lg p-4 inline-block">
                            <img src="{{ asset('images/qris-demo.png') }}" alt="QRIS" class="mx-auto max-w-[240px]" loading="lazy">
                        </div>
                        <p class="text-xs text-gray-500 mt-3">Tunjukkan/scan QRIS ini untuk menyelesaikan pembayaran.</p>
                    </div>
                </div>
                @error('metode_pembayaran')
                    <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-24">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Ringkasan Pesanan</h3>
                
                <div class="space-y-3 mb-4">
                    @foreach($items as $item)
                    <div class="flex justify-between text-sm">
                        <div class="flex-1">
                            <p class="text-gray-900 font-medium">{{ $item->buku->judul }}</p>
                            <p class="text-gray-600">{{ $item->jumlah }} x Rp {{ number_format($item->buku->harga, 0, ',', '.') }}</p>
                        </div>
                        <p class="text-gray-900 font-semibold">Rp {{ number_format($item->buku->harga * $item->jumlah, 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>

                <div class="border-t pt-4 space-y-2 mb-6">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal Produk</span>
                        <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Ongkos Kirim</span>
                        <span id="ongkir-display">Rp 10.000</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold text-gray-900 pt-2 border-t">
                        <span>Total Pembayaran</span>
                        <span class="text-blue-600" id="total-display">Rp {{ number_format($total + 10000, 0, ',', '.') }}</span>
                    </div>
                </div>

                <button type="submit" 
                        class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition font-semibold">
                    Buat Pesanan
                </button>
            </div>
        </div>
    </form>
</div>

<script>
// Update total when ongkir changes
document.querySelector('input[name="ongkir"]').addEventListener('input', function() {
    const subtotal = {{ $total }};
    const ongkir = parseFloat(this.value) || 0;
    const total = subtotal + ongkir;
    
    document.getElementById('ongkir-display').textContent = 'Rp ' + ongkir.toLocaleString('id-ID');
    document.getElementById('total-display').textContent = 'Rp ' + total.toLocaleString('id-ID');
});

// Toggle QRIS demo when payment option selected
document.querySelectorAll('input[name="metode_pembayaran"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        const showQris = this.value === 'qris';
        document.getElementById('qris-demo').classList.toggle('hidden', !showQris);
    });
});
</script>
@endsection
