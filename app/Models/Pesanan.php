<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';

    protected $primaryKey = 'id_pesanan';
    protected $fillable   = ['user_id', 'tanggal_pesan', 'total_harga', 'status_pesanan'];
    protected $casts = [
        'tanggal_pesan' => 'datetime',
    ];

    public function items()
    {
        return $this->hasMany(PesananItem::class, 'id_pesanan', 'id_pesanan');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'id_pesanan', 'id_pesanan');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tracking()
    {
        return $this->hasMany(TrackingStatus::class, 'id_pesanan', 'id_pesanan');
    }
}
