<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackingStatus extends Model
{
    protected $table = 'tracking_status';
    protected $primaryKey = 'id_tracking';
    public $timestamps = true;

    protected $fillable = [
        'id_pesanan',
        'status',
        'waktu_update',
        'keterangan',
    ];

    protected $casts = [
        'waktu_update' => 'datetime',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }
}
