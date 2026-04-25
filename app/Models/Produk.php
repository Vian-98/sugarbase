<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    public $timestamps = true;

    protected $fillable = [
        'id_kategori',
        'user_id',
        'nama_produk',
        'harga',
        'stok',
        'foto',
        'status_produk',
        'deskripsi_produk',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function keranjangItems()
    {
        return $this->hasMany(KeranjangItem::class, 'id_produk', 'id_produk');
    }

    public function pesananItems()
    {
        return $this->hasMany(PesananItem::class, 'id_produk', 'id_produk');
    }
}
