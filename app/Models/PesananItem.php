<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesananItem extends Model
{
    protected $table = 'pesanan_item';
    protected $primaryKey = 'id_pesanan_item';
    public $timestamps = false;

    protected $fillable = [
        'id_pesanan',
        'id_buku',
        'jumlah',
        'harga',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    protected $appends = ['subtotal'];

    public function getSubtotalAttribute()
    {
        return $this->harga * $this->jumlah;
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku');
    }
}
