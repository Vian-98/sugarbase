<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $primaryKey = 'id_keranjang';
    protected $table      = 'keranjang';
    protected $fillable   = ['user_id', 'status_keranjang', 'tanggal_dibuat'];

    public function items()
    {
        return $this->hasMany(KeranjangItem::class, 'id_keranjang', 'id_keranjang');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}