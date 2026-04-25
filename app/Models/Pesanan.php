<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'tanggal_pesan',
        'total_harga',
        'status_pesanan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(PesananItem::class, 'id_pesanan', 'id_pesanan');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_pesanan', 'id_pesanan');
    }

    public function tracking()
    {
        return $this->hasMany(TrackingStatus::class, 'id_pesanan', 'id_pesanan');
    }
}
