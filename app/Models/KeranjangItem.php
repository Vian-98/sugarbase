<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeranjangItem extends Model
{
    protected $table = 'keranjang_item';
    protected $primaryKey = 'id_keranjang_item';
    public $timestamps = true;

    protected $fillable = [
        'id_keranjang',
        'id_produk',
        'jumlah_keranjang',
        'harga_satuan_keranjang',
        'subtotal_keranjang',
    ];

    public function keranjang()
    {
        return $this->belongsTo(Keranjang::class, 'id_keranjang', 'id_keranjang');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
