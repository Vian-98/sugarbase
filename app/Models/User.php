<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',         // ← ditambahkan untuk A1
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // Relationships
    public function produk()
    {
        return $this->hasMany(Produk::class, 'user_id');
    }

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class, 'user_id');
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'user_id');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'user_id');
    }
}
