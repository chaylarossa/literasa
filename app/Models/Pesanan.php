<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    public $timestamps = true;
    const CREATED_AT = 'tanggal_pesanan';
    const UPDATED_AT = null;

    protected $fillable = [
        'id_pengguna',
        'nama_penerima',
        'no_hp',
        'alamat',
        'kota',
        'kode_pos',
        'ekspedisi',
        'ongkir',
        'total_produk',
        'total_pembayaran',
        'metode_pembayaran',
        'status_pesanan',
    ];

    protected $casts = [
        'tanggal_pesanan' => 'datetime',
        'ongkir' => 'decimal:2',
        'total_produk' => 'decimal:2',
        'total_pembayaran' => 'decimal:2',
    ];

    protected $appends = ['nomor_pesanan', 'total'];

    public function getNomorPesananAttribute()
    {
        return 'INV-' . str_pad($this->id_pesanan, 6, '0', STR_PAD_LEFT);
    }

    public function getTotalAttribute()
    {
        return $this->total_pembayaran;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_pengguna');
    }

    public function items()
    {
        return $this->hasMany(PesananItem::class, 'id_pesanan');
    }
}
