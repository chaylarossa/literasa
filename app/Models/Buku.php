<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'id_buku';
    public $timestamps = false;

    protected $fillable = [
        'id_kategori',
        'judul',
        'isbn',
        'pengarang',
        'penerbit',
        'deskripsi',
        'harga',
        'stok',
        'cover',
        'is_active',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriBuku::class, 'id_kategori');
    }

    public function keranjangItems()
    {
        return $this->hasMany(Keranjang::class, 'id_buku');
    }

    public function pesananItems()
    {
        return $this->hasMany(PesananItem::class, 'id_buku');
    }
}
