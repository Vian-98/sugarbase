<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KategoriSeeder extends Seeder
{
    /**
     * Seed tabel kategori dengan kategori produk dessert SugarBase.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('kategori')->insert([
            [
                'nama_kategori'     => 'Kue & Pastry',
                'deskripsi_kategori'=> 'Berbagai pilihan kue, pastry, dan roti manis buatan tangan',
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'nama_kategori'     => 'Es Krim & Gelato',
                'deskripsi_kategori'=> 'Es krim premium, gelato Italia, dan frozen dessert segar',
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'nama_kategori'     => 'Pudding & Jelly',
                'deskripsi_kategori'=> 'Pudding susu, coklat, buah, dan aneka jelly segar',
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'nama_kategori'     => 'Coklat & Praline',
                'deskripsi_kategori'=> 'Coklat artisan, truffle, praline, dan fondue coklat',
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'nama_kategori'     => 'Minuman Manis',
                'deskripsi_kategori'=> 'Milkshake, boba, matcha latte, dan minuman dessert lainnya',
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'nama_kategori'     => 'Waffle & Crepe',
                'deskripsi_kategori'=> 'Waffle Belgium, crepe Prancis, dan pancake dengan berbagai topping',
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
        ]);
    }
}