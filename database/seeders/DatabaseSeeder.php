<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Urutan pemanggilan SANGAT PENTING karena foreign key constraints.
     * Jangan ubah urutan ini kecuali Anda memahami relasi antar tabel.
     *
     * ┌─────────────────────────────────────────────────────────────┐
     * │  DEPENDENCY ORDER (dari parent → child)                     │
     * │                                                             │
     * │  1. UserSeeder         → parent untuk semua tabel          │
     * │  2. KategoriSeeder     → parent untuk produk               │
     * │  3. ProdukSeeder       → dep: users, kategori              │
     * │  4. KeranjangSeeder    → dep: users, produk                │
     * │  5. PesananSeeder      → dep: users, produk                │
     * │  6. PembayaranSeeder   → dep: pesanan                      │
     * │  7. TrackingStatusSeeder → dep: pesanan                    │
     * │  8. NotifikasiSeeder   → dep: users                        │
     * └─────────────────────────────────────────────────────────────┘
     *
     * CARA MENJALANKAN:
     *
     *   1. Fresh install (migrasi + seeder):
     *      php artisan migrate:fresh --seed
     *
     *   2. Hanya seeder (tanpa migrasi ulang):
     *      php artisan db:seed
     *
     *   3. Seeder spesifik saja:
     *      php artisan db:seed --class=ProdukSeeder
     *
     * AKUN LOGIN:
     *   Admin     → admin@sugarbase.id   / admin123
     *   Pelanggan → rina@gmail.com       / pelanggan123
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            KategoriSeeder::class,
            ProdukSeeder::class,
            KeranjangSeeder::class,
            PesananSeeder::class,
            PembayaranSeeder::class,
            TrackingStatusSeeder::class,
            NotifikasiSeeder::class,
        ]);
    }
}