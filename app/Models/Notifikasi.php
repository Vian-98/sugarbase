<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notifikasi';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'judul',
        'pesan',
        'waktu_kirim',
        'status_baca',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
