<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesananItem extends Model
{
    protected $table    = 'pesanan_item';
    protected $fillable = [
        'id_pesanan', 'id_produk', 'jumlah_pesanan',
        'harga_satuan_pesanan', 'subtotal_pesanan'
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}