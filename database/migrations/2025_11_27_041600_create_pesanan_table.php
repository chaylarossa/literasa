<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->unsignedBigInteger('id_pengguna');
            $table->string('nama_penerima', 100);
            $table->string('no_hp', 20);
            $table->text('alamat');
            $table->string('kota', 100);
            $table->string('kode_pos', 10);
            $table->timestamp('tanggal_pesanan')->useCurrent();
            $table->string('ekspedisi', 50);
            $table->decimal('ongkir', 12, 2)->default(0);
            $table->decimal('total_produk', 12, 2);
            $table->decimal('total_pembayaran', 12, 2);
            $table->string('metode_pembayaran');
            $table->enum('status_pesanan', ['menunggu_konfirmasi', 'diproses', 'dikirim', 'selesai', 'dibatalkan'])->default('menunggu_konfirmasi');
            
            $table->foreign('id_pengguna')->references('id_pengguna')->on('pengguna');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
