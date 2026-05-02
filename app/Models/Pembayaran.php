<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $primaryKey = 'id_pembayaran';
    protected $fillable   = [
        'id_pesanan', 'metode_pembayaran', 'status_pembayaran',
        'tanggal_bayar', 'jumlah_bayar'
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }
}