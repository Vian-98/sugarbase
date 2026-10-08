<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KeranjangSeeder extends Seeder
{
    /**
     * Seed tabel keranjang dan keranjang_item.
     *
     * Skenario:
     *   - Beberapa pelanggan memiliki keranjang aktif (belum checkout)
     *   - Beberapa keranjang sudah berstatus 'checkout' (telah jadi pesanan)
     *
     * Mapping user_id pelanggan:
     *   4 = Rina Amelia       7 = Gita Maharani
     *   5 = Budi Santoso      8 = Hendra Wijaya
     *   6 = Citra Dewi        9 = Indah Lestari
     *   10 = Dani Pratama     11 = Eka Putri
     *   12 = Fajar Nugroho    13 = Joko Susilo
     */
    public function run(): void
    {
        $today = Carbon::today();
        $now   = Carbon::now();

        /* ─────────────────────────────────────────────────────────────
         *  KERANJANG (8 keranjang)
         * ─────────────────────────────────────────────────────────────*/
        DB::table('keranjang')->insert([
            /* 1 - Rina: aktif */
            [
                'id_keranjang'    => 1,
                'user_id'         => 4,
                'tanggal_dibuat'  => $today,
                'status_keranjang'=> 'aktif',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            /* 2 - Budi: aktif */
            [
                'id_keranjang'    => 2,
                'user_id'         => 5,
                'tanggal_dibuat'  => $today->copy()->subDays(1),
                'status_keranjang'=> 'aktif',
                'created_at'      => $now->copy()->subDays(1),
                'updated_at'      => $now->copy()->subDays(1),
            ],
            /* 3 - Citra: checkout (sudah jadi pesanan) */
            [
                'id_keranjang'    => 3,
                'user_id'         => 6,
                'tanggal_dibuat'  => $today->copy()->subDays(3),
                'status_keranjang'=> 'checkout',
                'created_at'      => $now->copy()->subDays(3),
                'updated_at'      => $now->copy()->subDays(3),
            ],
            /* 4 - Dani: checkout */
            [
                'id_keranjang'    => 4,
                'user_id'         => 10,
                'tanggal_dibuat'  => $today->copy()->subDays(5),
                'status_keranjang'=> 'checkout',
                'created_at'      => $now->copy()->subDays(5),
                'updated_at'      => $now->copy()->subDays(5),
            ],
            /* 5 - Eka: aktif */
            [
                'id_keranjang'    => 5,
                'user_id'         => 11,
                'tanggal_dibuat'  => $today,
                'status_keranjang'=> 'aktif',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            /* 6 - Gita: checkout */
            [
                'id_keranjang'    => 6,
                'user_id'         => 7,
                'tanggal_dibuat'  => $today->copy()->subDays(7),
                'status_keranjang'=> 'checkout',
                'created_at'      => $now->copy()->subDays(7),
                'updated_at'      => $now->copy()->subDays(7),
            ],
            /* 7 - Hendra: aktif */
            [
                'id_keranjang'    => 7,
                'user_id'         => 8,
                'tanggal_dibuat'  => $today->copy()->subDays(1),
                'status_keranjang'=> 'aktif',
                'created_at'      => $now->copy()->subDays(1),
                'updated_at'      => $now->copy()->subDays(1),
            ],
            /* 8 - Indah: checkout */
            [
                'id_keranjang'    => 8,
                'user_id'         => 9,
                'tanggal_dibuat'  => $today->copy()->subDays(2),
                'status_keranjang'=> 'checkout',
                'created_at'      => $now->copy()->subDays(2),
                'updated_at'      => $now->copy()->subDays(2),
            ],
        ]);

        /* ─────────────────────────────────────────────────────────────
         *  KERANJANG_ITEM (20 item)
         * ─────────────────────────────────────────────────────────────*/
        DB::table('keranjang_item')->insert([
            /* Keranjang 1 - Rina (aktif) */
            [
                'id_keranjang'            => 1,
                'id_produk'               => 2,  /* Red Velvet Cake Slice - 38.000 */
                'jumlah_keranjang'        => 2,
                'harga_satuan_keranjang'  => 38000.00,
                'subtotal_keranjang'      => 76000.00,
                'created_at'              => $now,
                'updated_at'              => $now,
            ],
            [
                'id_keranjang'            => 1,
                'id_produk'               => 17, /* Brown Sugar Boba Milk - 28.000 */
                'jumlah_keranjang'        => 2,
                'harga_satuan_keranjang'  => 28000.00,
                'subtotal_keranjang'      => 56000.00,
                'created_at'              => $now,
                'updated_at'              => $now,
            ],

            /* Keranjang 2 - Budi (aktif) */
            [
                'id_keranjang'            => 2,
                'id_produk'               => 5,  /* Gelato Pistachio - 35.000 */
                'jumlah_keranjang'        => 3,
                'harga_satuan_keranjang'  => 35000.00,
                'subtotal_keranjang'      => 105000.00,
                'created_at'              => $now,
                'updated_at'              => $now,
            ],
            [
                'id_keranjang'            => 2,
                'id_produk'               => 21, /* Waffle Nutella Banana - 45.000 */
                'jumlah_keranjang'        => 1,
                'harga_satuan_keranjang'  => 45000.00,
                'subtotal_keranjang'      => 45000.00,
                'created_at'              => $now,
                'updated_at'              => $now,
            ],

            /* Keranjang 3 - Citra (checkout) */
            [
                'id_keranjang'            => 3,
                'id_produk'               => 13, /* Dark Chocolate Truffle - 65.000 */
                'jumlah_keranjang'        => 2,
                'harga_satuan_keranjang'  => 65000.00,
                'subtotal_keranjang'      => 130000.00,
                'created_at'              => $now->copy()->subDays(3),
                'updated_at'              => $now->copy()->subDays(3),
            ],
            [
                'id_keranjang'            => 3,
                'id_produk'               => 18, /* Matcha Latte - 32.000 */
                'jumlah_keranjang'        => 2,
                'harga_satuan_keranjang'  => 32000.00,
                'subtotal_keranjang'      => 64000.00,
                'created_at'              => $now->copy()->subDays(3),
                'updated_at'              => $now->copy()->subDays(3),
            ],

            /* Keranjang 4 - Dani (checkout) */
            [
                'id_keranjang'            => 4,
                'id_produk'               => 9,  /* Pudding Coklat Lava - 22.000 */
                'jumlah_keranjang'        => 4,
                'harga_satuan_keranjang'  => 22000.00,
                'subtotal_keranjang'      => 88000.00,
                'created_at'              => $now->copy()->subDays(5),
                'updated_at'              => $now->copy()->subDays(5),
            ],
            [
                'id_keranjang'            => 4,
                'id_produk'               => 3,  /* Cinnamon Roll - 28.000 */
                'jumlah_keranjang'        => 3,
                'harga_satuan_keranjang'  => 28000.00,
                'subtotal_keranjang'      => 84000.00,
                'created_at'              => $now->copy()->subDays(5),
                'updated_at'              => $now->copy()->subDays(5),
            ],

            /* Keranjang 5 - Eka (aktif) */
            [
                'id_keranjang'            => 5,
                'id_produk'               => 23, /* Bubble Waffle Ice Cream - 55.000 */
                'jumlah_keranjang'        => 1,
                'harga_satuan_keranjang'  => 55000.00,
                'subtotal_keranjang'      => 55000.00,
                'created_at'              => $now,
                'updated_at'              => $now,
            ],
            [
                'id_keranjang'            => 5,
                'id_produk'               => 20, /* Caramel Frappuccino - 38.000 */
                'jumlah_keranjang'        => 2,
                'harga_satuan_keranjang'  => 38000.00,
                'subtotal_keranjang'      => 76000.00,
                'created_at'              => $now,
                'updated_at'              => $now,
            ],

            /* Keranjang 6 - Gita (checkout) */
            [
                'id_keranjang'            => 6,
                'id_produk'               => 16, /* Praline Assorted Box - 85.000 */
                'jumlah_keranjang'        => 1,
                'harga_satuan_keranjang'  => 85000.00,
                'subtotal_keranjang'      => 85000.00,
                'created_at'              => $now->copy()->subDays(7),
                'updated_at'              => $now->copy()->subDays(7),
            ],
            [
                'id_keranjang'            => 6,
                'id_produk'               => 4,  /* Tiramisu Cup - 42.000 */
                'jumlah_keranjang'        => 2,
                'harga_satuan_keranjang'  => 42000.00,
                'subtotal_keranjang'      => 84000.00,
                'created_at'              => $now->copy()->subDays(7),
                'updated_at'              => $now->copy()->subDays(7),
            ],

            /* Keranjang 7 - Hendra (aktif) */
            [
                'id_keranjang'            => 7,
                'id_produk'               => 6,  /* Es Krim Matcha Swirl - 32.000 */
                'jumlah_keranjang'        => 2,
                'harga_satuan_keranjang'  => 32000.00,
                'subtotal_keranjang'      => 64000.00,
                'created_at'              => $now->copy()->subDays(1),
                'updated_at'              => $now->copy()->subDays(1),
            ],

            /* Keranjang 8 - Indah (checkout) */
            [
                'id_keranjang'            => 8,
                'id_produk'               => 24, /* Pancake Stack Berry - 42.000 */
                'jumlah_keranjang'        => 2,
                'harga_satuan_keranjang'  => 42000.00,
                'subtotal_keranjang'      => 84000.00,
                'created_at'              => $now->copy()->subDays(2),
                'updated_at'              => $now->copy()->subDays(2),
            ],
            [
                'id_keranjang'            => 8,
                'id_produk'               => 19, /* Strawberry Milkshake - 35.000 */
                'jumlah_keranjang'        => 1,
                'harga_satuan_keranjang'  => 35000.00,
                'subtotal_keranjang'      => 35000.00,
                'created_at'              => $now->copy()->subDays(2),
                'updated_at'              => $now->copy()->subDays(2),
            ],
        ]);
    }
}