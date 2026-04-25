<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    public $timestamps = true;

    protected $fillable = [
        'nama_kategori',
        'deskripsi_kategori',
    ];

    public function produk()
    {
        return $this->hasMany(Produk::class, 'id_kategori', 'id_kategori');
    }
}
