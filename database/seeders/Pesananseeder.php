<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PesananSeeder extends Seeder
{
    /**
     * Seed tabel pesanan dan pesanan_item dengan skenario realistis.
     *
     * Status pesanan yang digunakan:
     *   pending     → baru masuk, belum diproses
     *   diproses    → sedang disiapkan
     *   dikirim     → dalam perjalanan
     *   selesai     → sudah diterima pelanggan
     *   dibatalkan  → dibatalkan
     */
    public function run(): void
    {
        $now = Carbon::now();

        /* ─────────────────────────────────────────────────────────────
         *  PESANAN (10 pesanan dari berbagai pelanggan)
         * ─────────────────────────────────────────────────────────────*/
        DB::table('pesanan')->insert([
            /* 1 - Citra | selesai | 3 hari lalu */
            [
                'id_pesanan'     => 1,
                'user_id'        => 6,
                'tanggal_pesan'  => $now->copy()->subDays(3)->toDateString(),
                'total_harga'    => 194000.00,
                'status_pesanan' => 'selesai',
                'created_at'     => $now->copy()->subDays(3),
                'updated_at'     => $now->copy()->subDays(1),
            ],
            /* 2 - Dani | selesai | 5 hari lalu */
            [
                'id_pesanan'     => 2,
                'user_id'        => 10,
                'tanggal_pesan'  => $now->copy()->subDays(5)->toDateString(),
                'total_harga'    => 172000.00,
                'status_pesanan' => 'selesai',
                'created_at'     => $now->copy()->subDays(5),
                'updated_at'     => $now->copy()->subDays(2),
            ],
            /* 3 - Gita | dikirim | 7 hari lalu */
            [
                'id_pesanan'     => 3,
                'user_id'        => 7,
                'tanggal_pesan'  => $now->copy()->subDays(7)->toDateString(),
                'total_harga'    => 169000.00,
                'status_pesanan' => 'dikirim',
                'created_at'     => $now->copy()->subDays(7),
                'updated_at'     => $now->copy()->subDays(1),
            ],
            /* 4 - Indah | dikirim | 2 hari lalu */
            [
                'id_pesanan'     => 4,
                'user_id'        => 9,
                'tanggal_pesan'  => $now->copy()->subDays(2)->toDateString(),
                'total_harga'    => 119000.00,
                'status_pesanan' => 'dikirim',
                'created_at'     => $now->copy()->subDays(2),
                'updated_at'     => $now->copy()->subDays(1),
            ],
            /* 5 - Fajar | diproses | 1 hari lalu */
            [
                'id_pesanan'     => 5,
                'user_id'        => 12,
                'tanggal_pesan'  => $now->copy()->subDays(1)->toDateString(),
                'total_harga'    => 148000.00,
                'status_pesanan' => 'diproses',
                'created_at'     => $now->copy()->subDays(1),
                'updated_at'     => $now->copy()->subHours(6),
            ],
            /* 6 - Joko | pending | hari ini */
            [
                'id_pesanan'     => 6,
                'user_id'        => 13,
                'tanggal_pesan'  => $now->toDateString(),
                'total_harga'    => 95000.00,
                'status_pesanan' => 'pending',
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            /* 7 - Rina | pending | hari ini */
            [
                'id_pesanan'     => 7,
                'user_id'        => 4,
                'tanggal_pesan'  => $now->toDateString(),
                'total_harga'    => 207000.00,
                'status_pesanan' => 'pending',
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
            /* 8 - Budi | dibatalkan | 10 hari lalu */
            [
                'id_pesanan'     => 8,
                'user_id'        => 5,
                'tanggal_pesan'  => $now->copy()->subDays(10)->toDateString(),
                'total_harga'    => 85000.00,
                'status_pesanan' => 'dibatalkan',
                'created_at'     => $now->copy()->subDays(10),
                'updated_at'     => $now->copy()->subDays(9),
            ],
            /* 9 - Eka | selesai | 14 hari lalu */
            [
                'id_pesanan'     => 9,
                'user_id'        => 11,
                'tanggal_pesan'  => $now->copy()->subDays(14)->toDateString(),
                'total_harga'    => 260000.00,
                'status_pesanan' => 'selesai',
                'created_at'     => $now->copy()->subDays(14),
                'updated_at'     => $now->copy()->subDays(11),
            ],
            /* 10 - Hendra | diproses | hari ini */
            [
                'id_pesanan'     => 10,
                'user_id'        => 8,
                'tanggal_pesan'  => $now->toDateString(),
                'total_harga'    => 122000.00,
                'status_pesanan' => 'diproses',
                'created_at'     => $now,
                'updated_at'     => $now,
            ],
        ]);

        /* ─────────────────────────────────────────────────────────────
         *  PESANAN_ITEM
         * ─────────────────────────────────────────────────────────────*/
        DB::table('pesanan_item')->insert([
            /* Pesanan 1 - Citra (total 194.000) */
            [
                'id_pesanan'           => 1,
                'id_produk'            => 13, /* Dark Chocolate Truffle - 65.000 */
                'jumlah_pesanan'       => 2,
                'harga_satuan_pesanan' => 65000.00,
                'subtotal_pesanan'     => 130000.00,
                'created_at'           => $now->copy()->subDays(3),
                'updated_at'           => $now->copy()->subDays(3),
            ],
            [
                'id_pesanan'           => 1,
                'id_produk'            => 18, /* Matcha Latte - 32.000 */
                'jumlah_pesanan'       => 2,
                'harga_satuan_pesanan' => 32000.00,
                'subtotal_pesanan'     => 64000.00,
                'created_at'           => $now->copy()->subDays(3),
                'updated_at'           => $now->copy()->subDays(3),
            ],

            /* Pesanan 2 - Dani (total 172.000) */
            [
                'id_pesanan'           => 2,
                'id_produk'            => 9,  /* Pudding Coklat Lava - 22.000 */
                'jumlah_pesanan'       => 4,
                'harga_satuan_pesanan' => 22000.00,
                'subtotal_pesanan'     => 88000.00,
                'created_at'           => $now->copy()->subDays(5),
                'updated_at'           => $now->copy()->subDays(5),
            ],
            [
                'id_pesanan'           => 2,
                'id_produk'            => 3,  /* Cinnamon Roll - 28.000 */
                'jumlah_pesanan'       => 3,
                'harga_satuan_pesanan' => 28000.00,
                'subtotal_pesanan'     => 84000.00,
                'created_at'           => $now->copy()->subDays(5),
                'updated_at'           => $now->copy()->subDays(5),
            ],

            /* Pesanan 3 - Gita (total 169.000) */
            [
                'id_pesanan'           => 3,
                'id_produk'            => 16, /* Praline Assorted Box - 85.000 */
                'jumlah_pesanan'       => 1,
                'harga_satuan_pesanan' => 85000.00,
                'subtotal_pesanan'     => 85000.00,
                'created_at'           => $now->copy()->subDays(7),
                'updated_at'           => $now->copy()->subDays(7),
            ],
            [
                'id_pesanan'           => 3,
                'id_produk'            => 4,  /* Tiramisu Cup - 42.000 */
                'jumlah_pesanan'       => 2,
                'harga_satuan_pesanan' => 42000.00,
                'subtotal_pesanan'     => 84000.00,
                'created_at'           => $now->copy()->subDays(7),
                'updated_at'           => $now->copy()->subDays(7),
            ],

            /* Pesanan 4 - Indah (total 119.000) */
            [
                'id_pesanan'           => 4,
                'id_produk'            => 24, /* Pancake Stack Berry - 42.000 */
                'jumlah_pesanan'       => 2,
                'harga_satuan_pesanan' => 42000.00,
                'subtotal_pesanan'     => 84000.00,
                'created_at'           => $now->copy()->subDays(2),
                'updated_at'           => $now->copy()->subDays(2),
            ],
            [
                'id_pesanan'           => 4,
                'id_produk'            => 19, /* Strawberry Milkshake - 35.000 */
                'jumlah_pesanan'       => 1,
                'harga_satuan_pesanan' => 35000.00,
                'subtotal_pesanan'     => 35000.00,
                'created_at'           => $now->copy()->subDays(2),
                'updated_at'           => $now->copy()->subDays(2),
            ],

            /* Pesanan 5 - Fajar (total 148.000) */
            [
                'id_pesanan'           => 5,
                'id_produk'            => 1,  /* Croissant Butter - 25.000 */
                'jumlah_pesanan'       => 2,
                'harga_satuan_pesanan' => 25000.00,
                'subtotal_pesanan'     => 50000.00,
                'created_at'           => $now->copy()->subDays(1),
                'updated_at'           => $now->copy()->subDays(1),
            ],
            [
                'id_pesanan'           => 5,
                'id_produk'            => 14, /* Molten Chocolate Lava - 48.000 */
                'jumlah_pesanan'       => 2,
                'harga_satuan_pesanan' => 48000.00,
                'subtotal_pesanan'     => 96000.00,
                'created_at'           => $now->copy()->subDays(1),
                'updated_at'           => $now->copy()->subDays(1),
            ],

            /* Pesanan 6 - Joko (total 95.000) */
            [
                'id_pesanan'           => 6,
                'id_produk'            => 8,  /* Sundae Strawberry - 45.000 */
                'jumlah_pesanan'       => 1,
                'harga_satuan_pesanan' => 45000.00,
                'subtotal_pesanan'     => 45000.00,
                'created_at'           => $now,
                'updated_at'           => $now,
            ],
            [
                'id_pesanan'           => 6,
                'id_produk'            => 17, /* Brown Sugar Boba Milk - 28.000 */
                'jumlah_pesanan'       => 2,
                'harga_satuan_pesanan' => 28000.00,
                'subtotal_pesanan'     => 56000.00,
                'created_at'           => $now,
                'updated_at'           => $now,
            ],

            /* Pesanan 7 - Rina (total 207.000) */
            [
                'id_pesanan'           => 7,
                'id_produk'            => 2,  /* Red Velvet Cake Slice - 38.000 */
                'jumlah_pesanan'       => 2,
                'harga_satuan_pesanan' => 38000.00,
                'subtotal_pesanan'     => 76000.00,
                'created_at'           => $now,
                'updated_at'           => $now,
            ],
            [
                'id_pesanan'           => 7,
                'id_produk'            => 22, /* Crepe Suzette - 38.000 */
                'jumlah_pesanan'       => 1,
                'harga_satuan_pesanan' => 38000.00,
                'subtotal_pesanan'     => 38000.00,
                'created_at'           => $now,
                'updated_at'           => $now,
            ],
            [
                'id_pesanan'           => 7,
                'id_produk'            => 20, /* Caramel Frappuccino - 38.000 */
                'jumlah_pesanan'       => 2,
                'harga_satuan_pesanan' => 38000.00,
                'subtotal_pesanan'     => 76000.00,
                'created_at'           => $now,
                'updated_at'           => $now,
            ],
            [
                'id_pesanan'           => 7,
                'id_produk'            => 11, /* Jelly Lychee Rose - 18.000 */
                'jumlah_pesanan'       => 1,
                'harga_satuan_pesanan' => 18000.00,
                'subtotal_pesanan'     => 17000.00,
                'created_at'           => $now,
                'updated_at'           => $now,
            ],

            /* Pesanan 8 - Budi (dibatalkan, total 85.000) */
            [
                'id_pesanan'           => 8,
                'id_produk'            => 16, /* Praline Assorted Box - 85.000 */
                'jumlah_pesanan'       => 1,
                'harga_satuan_pesanan' => 85000.00,
                'subtotal_pesanan'     => 85000.00,
                'created_at'           => $now->copy()->subDays(10),
                'updated_at'           => $now->copy()->subDays(10),
            ],

            /* Pesanan 9 - Eka (selesai, total 260.000) */
            [
                'id_pesanan'           => 9,
                'id_produk'            => 23, /* Bubble Waffle Ice Cream - 55.000 */
                'jumlah_pesanan'       => 2,
                'harga_satuan_pesanan' => 55000.00,
                'subtotal_pesanan'     => 110000.00,
                'created_at'           => $now->copy()->subDays(14),
                'updated_at'           => $now->copy()->subDays(14),
            ],
            [
                'id_pesanan'           => 9,
                'id_produk'            => 6,  /* Es Krim Matcha Swirl - 32.000 */
                'jumlah_pesanan'       => 2,
                'harga_satuan_pesanan' => 32000.00,
                'subtotal_pesanan'     => 64000.00,
                'created_at'           => $now->copy()->subDays(14),
                'updated_at'           => $now->copy()->subDays(14),
            ],
            [
                'id_pesanan'           => 9,
                'id_produk'            => 10, /* Panna Cotta Vanilla - 27.000 */
                'jumlah_pesanan'       => 2,
                'harga_satuan_pesanan' => 27000.00,
                'subtotal_pesanan'     => 54000.00,
                'created_at'           => $now->copy()->subDays(14),
                'updated_at'           => $now->copy()->subDays(14),
            ],
            [
                'id_pesanan'           => 9,
                'id_produk'            => 12, /* Mango Pudding Thai - 24.000 */
                'jumlah_pesanan'       => 1,
                'harga_satuan_pesanan' => 24000.00,
                'subtotal_pesanan'     => 32000.00,
                'created_at'           => $now->copy()->subDays(14),
                'updated_at'           => $now->copy()->subDays(14),
            ],

            /* Pesanan 10 - Hendra (diproses, total 122.000) */
            [
                'id_pesanan'           => 10,
                'id_produk'            => 21, /* Waffle Nutella Banana - 45.000 */
                'jumlah_pesanan'       => 1,
                'harga_satuan_pesanan' => 45000.00,
                'subtotal_pesanan'     => 45000.00,
                'created_at'           => $now,
                'updated_at'           => $now,
            ],
            [
                'id_pesanan'           => 10,
                'id_produk'            => 7,  /* Ice Cream Sandwich - 29.000 */
                'jumlah_pesanan'       => 2,
                'harga_satuan_pesanan' => 29000.00,
                'subtotal_pesanan'     => 58000.00,
                'created_at'           => $now,
                'updated_at'           => $now,
            ],
            [
                'id_pesanan'           => 10,
                'id_produk'            => 11, /* Jelly Lychee Rose - 18.000 */
                'jumlah_pesanan'       => 1,
                'harga_satuan_pesanan' => 18000.00,
                'subtotal_pesanan'     => 18000.00,
                'created_at'           => $now,
                'updated_at'           => $now,
            ],
        ]);
    }
}