<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeranjangItem extends Model
{
    protected $table    = 'keranjang_item';
    protected $fillable = [
        'id_keranjang', 'id_produk', 'jumlah_keranjang',
        'harga_satuan_keranjang', 'subtotal_keranjang'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}