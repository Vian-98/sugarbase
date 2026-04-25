<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Seed tabel users dengan akun admin dan pelanggan.
     *
     * CATATAN PENTING:
     * Tabel users bawaan Laravel tidak memiliki kolom 'role'.
     * Tambahkan migration baru sebelum menjalankan seeder ini:
     *
     *   php artisan make:migration add_role_to_users_table
     *
     * Isi migration tersebut dengan:
     *   $table->enum('role', ['admin', 'pelanggan'])->default('pelanggan')->after('name');
     *
     * Lalu jalankan: php artisan migrate
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('users')->insert([
            /*
             * ──────────────────────────────────────────────────────────
             *  AKUN ADMIN (3 akun)
             * ──────────────────────────────────────────────────────────
             */
            [
                'name'              => 'Super Admin',
                'email'             => 'admin@sugarbase.id',
                'email_verified_at' => $now,
                'password'          => Hash::make('admin123'),
                'remember_token'    => null,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'name'              => 'Admin Produk',
                'email'             => 'produk@sugarbase.id',
                'email_verified_at' => $now,
                'password'          => Hash::make('admin123'),
                'remember_token'    => null,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'name'              => 'Admin Pesanan',
                'email'             => 'pesanan@sugarbase.id',
                'email_verified_at' => $now,
                'password'          => Hash::make('admin123'),
                'remember_token'    => null,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],

            /*
             * ──────────────────────────────────────────────────────────
             *  AKUN PELANGGAN (10 akun)
             * ──────────────────────────────────────────────────────────
             */
            [
                'name'              => 'Rina Amelia',
                'email'             => 'rina@gmail.com',
                'email_verified_at' => $now,
                'password'          => Hash::make('pelanggan123'),
                'remember_token'    => null,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'name'              => 'Budi Santoso',
                'email'             => 'budi@gmail.com',
                'email_verified_at' => $now,
                'password'          => Hash::make('pelanggan123'),
                'remember_token'    => null,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'name'              => 'Citra Dewi',
                'email'             => 'citra@gmail.com',
                'email_verified_at' => $now,
                'password'          => Hash::make('pelanggan123'),
                'remember_token'    => null,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'name'              => 'Dani Pratama',
                'email'             => 'dani@gmail.com',
                'email_verified_at' => $now,
                'password'          => Hash::make('pelanggan123'),
                'remember_token'    => null,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'name'              => 'Eka Putri',
                'email'             => 'eka@gmail.com',
                'email_verified_at' => $now,
                'password'          => Hash::make('pelanggan123'),
                'remember_token'    => null,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'name'              => 'Fajar Nugroho',
                'email'             => 'fajar@gmail.com',
                'email_verified_at' => $now,
                'password'          => Hash::make('pelanggan123'),
                'remember_token'    => null,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'name'              => 'Gita Maharani',
                'email'             => 'gita@gmail.com',
                'email_verified_at' => $now,
                'password'          => Hash::make('pelanggan123'),
                'remember_token'    => null,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'name'              => 'Hendra Wijaya',
                'email'             => 'hendra@gmail.com',
                'email_verified_at' => $now,
                'password'          => Hash::make('pelanggan123'),
                'remember_token'    => null,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'name'              => 'Indah Lestari',
                'email'             => 'indah@gmail.com',
                'email_verified_at' => $now,
                'password'          => Hash::make('pelanggan123'),
                'remember_token'    => null,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'name'              => 'Joko Susilo',
                'email'             => 'joko@gmail.com',
                'email_verified_at' => $now,
                'password'          => Hash::make('pelanggan123'),
                'remember_token'    => null,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
        ]);
    }
}