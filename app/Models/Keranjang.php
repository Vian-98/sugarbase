<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'tanggal_dibuat',
        'status_keranjang',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(KeranjangItem::class, 'id_keranjang', 'id_keranjang');
    }
}
