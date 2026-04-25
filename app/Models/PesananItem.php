<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesananItem extends Model
{
    protected $table = 'pesanan_item';
    protected $primaryKey = 'id_pesanan_item';
    public $timestamps = true;

    protected $fillable = [
        'id_pesanan',
        'id_produk',
        'jumlah_pesanan',
        'harga_satuan_pesanan',
        'subtotal_pesanan',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
