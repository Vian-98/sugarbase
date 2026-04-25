<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProdukSeeder extends Seeder
{
    /**
     * Seed tabel produk dengan 24 produk dessert SugarBase.
     *
     * Mapping user_id (manager/admin):
     *   user_id = 1 → Super Admin
     *   user_id = 2 → Admin Produk
     *   user_id = 3 → Admin Pesanan
     *
     * Mapping id_kategori:
     *   1 = Kue & Pastry
     *   2 = Es Krim & Gelato
     *   3 = Pudding & Jelly
     *   4 = Coklat & Praline
     *   5 = Minuman Manis
     *   6 = Waffle & Crepe
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('produk')->insert([
            /*
             * ── KATEGORI 1: KUE & PASTRY ──────────────────────────────
             */
            [
                'id_kategori'     => 1,
                'user_id'         => 2,
                'nama_produk'     => 'Croissant Butter Original',
                'harga'           => 25000.00,
                'stok'            => 50,
                'foto'            => 'produk/croissant-butter.jpg',
                'status_produk'   => 'aktif',
                'deskripsi_produk'=> 'Croissant lapis-lapis dengan butter premium, renyah di luar lembut di dalam',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'id_kategori'     => 1,
                'user_id'         => 2,
                'nama_produk'     => 'Red Velvet Cake Slice',
                'harga'           => 38000.00,
                'stok'            => 30,
                'foto'            => 'produk/red-velvet-slice.jpg',
                'status_produk'   => 'aktif',
                'deskripsi_produk'=> 'Potongan kue red velvet lembut dengan cream cheese frosting tebal',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'id_kategori'     => 1,
                'user_id'         => 2,
                'nama_produk'     => 'Cinnamon Roll',
                'harga'           => 28000.00,
                'stok'            => 40,
                'foto'            => 'produk/cinnamon-roll.jpg',
                'status_produk'   => 'aktif',
                'deskripsi_produk'=> 'Roti gulung kayu manis dengan glazing vanilla yang manis dan wangi',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'id_kategori'     => 1,
                'user_id'         => 2,
                'nama_produk'     => 'Tiramisu Cup',
                'harga'           => 42000.00,
                'stok'            => 25,
                'foto'            => 'produk/tiramisu-cup.jpg',
                'status_produk'   => 'aktif',
                'deskripsi_produk'=> 'Tiramisu autentik Italia dalam cup, espresso dan mascarpone lembut',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],

            /*
             * ── KATEGORI 2: ES KRIM & GELATO ─────────────────────────
             */
            [
                'id_kategori'     => 2,
                'user_id'         => 2,
                'nama_produk'     => 'Gelato Pistachio',
                'harga'           => 35000.00,
                'stok'            => 60,
                'foto'            => 'produk/gelato-pistachio.jpg',
                'status_produk'   => 'aktif',
                'deskripsi_produk'=> 'Gelato Italia asli dengan pistachio panggang dari Sicilia, creamy dan nutty',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'id_kategori'     => 2,
                'user_id'         => 2,
                'nama_produk'     => 'Es Krim Matcha Swirl',
                'harga'           => 32000.00,
                'stok'            => 45,
                'foto'            => 'produk/eskrim-matcha.jpg',
                'status_produk'   => 'aktif',
                'deskripsi_produk'=> 'Es krim matcha premium Jepang dengan swirl vanilla bean',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'id_kategori'     => 2,
                'user_id'         => 2,
                'nama_produk'     => 'Ice Cream Sandwich',
                'harga'           => 29000.00,
                'stok'            => 55,
                'foto'            => 'produk/icecream-sandwich.jpg',
                'status_produk'   => 'aktif',
                'deskripsi_produk'=> 'Es krim vanilla diapit dua cookies coklat renyah buatan sendiri',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'id_kategori'     => 2,
                'user_id'         => 2,
                'nama_produk'     => 'Sundae Strawberry',
                'harga'           => 45000.00,
                'stok'            => 35,
                'foto'            => 'produk/sundae-strawberry.jpg',
                'status_produk'   => 'aktif',
                'deskripsi_produk'=> 'Es krim vanilla dengan saus strawberry segar, whipped cream, dan cherry',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],

            /*
             * ── KATEGORI 3: PUDDING & JELLY ──────────────────────────
             */
            [
                'id_kategori'     => 3,
                'user_id'         => 1,
                'nama_produk'     => 'Pudding Coklat Lava',
                'harga'           => 22000.00,
                'stok'            => 70,
                'foto'            => 'produk/pudding-coklat-lava.jpg',
                'status_produk'   => 'aktif',
                'deskripsi_produk'=> 'Pudding coklat lembut dengan lava coklat cair di tengahnya',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'id_kategori'     => 3,
                'user_id'         => 1,
                'nama_produk'     => 'Panna Cotta Vanilla',
                'harga'           => 27000.00,
                'stok'            => 40,
                'foto'            => 'produk/panna-cotta.jpg',
                'status_produk'   => 'aktif',
                'deskripsi_produk'=> 'Panna cotta susu segar dengan vanilla bean dan saus buah merah',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'id_kategori'     => 3,
                'user_id'         => 1,
                'nama_produk'     => 'Jelly Lychee Rose',
                'harga'           => 18000.00,
                'stok'            => 80,
                'foto'            => 'produk/jelly-lychee.jpg',
                'status_produk'   => 'aktif',
                'deskripsi_produk'=> 'Jelly lychee segar dengan aroma bunga mawar dan isian buah lychee asli',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'id_kategori'     => 3,
                'user_id'         => 1,
                'nama_produk'     => 'Mango Pudding Thai',
                'harga'           => 24000.00,
                'stok'            => 50,
                'foto'            => 'produk/mango-pudding.jpg',
                'status_produk'   => 'aktif',
                'deskripsi_produk'=> 'Pudding mangga Thailand dengan santan dan saus mango segar di atas',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],

            /*
             * ── KATEGORI 4: COKLAT & PRALINE ─────────────────────────
             */
            [
                'id_kategori'     => 4,
                'user_id'         => 1,
                'nama_produk'     => 'Dark Chocolate Truffle',
                'harga'           => 65000.00,
                'stok'            => 20,
                'foto'            => 'produk/dark-truffle.jpg',
                'status_produk'   => 'aktif',
                'deskripsi_produk'=> 'Truffle dark chocolate 70% cocoa handmade, isi 6 pcs per box',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'id_kategori'     => 4,
                'user_id'         => 1,
                'nama_produk'     => 'Molten Chocolate Lava',
                'harga'           => 48000.00,
                'stok'            => 30,
                'foto'            => 'produk/molten-lava.jpg',
                'status_produk'   => 'aktif',
                'deskripsi_produk'=> 'Kue coklat hangat dengan lava cair di dalam, disajikan dengan es krim vanilla',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'id_kategori'     => 4,
                'user_id'         => 2,
                'nama_produk'     => 'Belgian Waffle Coklat',
                'harga'           => 52000.00,
                'stok'            => 15,
                'foto'            => 'produk/belgian-coklat.jpg',
                'status_produk'   => 'nonaktif',
                'deskripsi_produk'=> 'Waffle Belgium dengan topping coklat Belgian asli dan hazelnut',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'id_kategori'     => 4,
                'user_id'         => 2,
                'nama_produk'     => 'Praline Assorted Box',
                'harga'           => 85000.00,
                'stok'            => 10,
                'foto'            => 'produk/praline-box.jpg',
                'status_produk'   => 'aktif',
                'deskripsi_produk'=> 'Kotak praline assorted 12 pcs, rasa: caramel, hazelnut, raspberry, mint',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],

            /*
             * ── KATEGORI 5: MINUMAN MANIS ─────────────────────────────
             */
            [
                'id_kategori'     => 5,
                'user_id'         => 3,
                'nama_produk'     => 'Brown Sugar Boba Milk',
                'harga'           => 28000.00,
                'stok'            => 100,
                'foto'            => 'produk/boba-brownsugar.jpg',
                'status_produk'   => 'aktif',
                'deskripsi_produk'=> 'Teh susu dengan boba pearl kenyal dan sirup brown sugar caramel',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'id_kategori'     => 5,
                'user_id'         => 3,
                'nama_produk'     => 'Matcha Latte',
                'harga'           => 32000.00,
                'stok'            => 80,
                'foto'            => 'produk/matcha-latte.jpg',
                'status_produk'   => 'aktif',
                'deskripsi_produk'=> 'Matcha ceremonial grade Jepang dengan susu fresh, bisa pilih panas/dingin',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'id_kategori'     => 5,
                'user_id'         => 3,
                'nama_produk'     => 'Strawberry Milkshake',
                'harga'           => 35000.00,
                'stok'            => 60,
                'foto'            => 'produk/milkshake-strawberry.jpg',
                'status_produk'   => 'aktif',
                'deskripsi_produk'=> 'Milkshake strawberry segar dengan es krim dan whipped cream berlimpah',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'id_kategori'     => 5,
                'user_id'         => 3,
                'nama_produk'     => 'Caramel Frappuccino',
                'harga'           => 38000.00,
                'stok'            => 70,
                'foto'            => 'produk/caramel-frappe.jpg',
                'status_produk'   => 'aktif',
                'deskripsi_produk'=> 'Minuman kopi dingin blended dengan caramel drizzle dan whipped cream',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],

            /*
             * ── KATEGORI 6: WAFFLE & CREPE ───────────────────────────
             */
            [
                'id_kategori'     => 6,
                'user_id'         => 3,
                'nama_produk'     => 'Waffle Nutella Banana',
                'harga'           => 45000.00,
                'stok'            => 40,
                'foto'            => 'produk/waffle-nutella.jpg',
                'status_produk'   => 'aktif',
                'deskripsi_produk'=> 'Waffle renyah dengan spread Nutella, pisang segar, dan es krim vanilla',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'id_kategori'     => 6,
                'user_id'         => 3,
                'nama_produk'     => 'Crepe Suzette',
                'harga'           => 38000.00,
                'stok'            => 35,
                'foto'            => 'produk/crepe-suzette.jpg',
                'status_produk'   => 'aktif',
                'deskripsi_produk'=> 'Crepe tipis ala Prancis dengan saus orange butter caramelized yang harum',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'id_kategori'     => 6,
                'user_id'         => 3,
                'nama_produk'     => 'Bubble Waffle Ice Cream',
                'harga'           => 55000.00,
                'stok'            => 25,
                'foto'            => 'produk/bubble-waffle.jpg',
                'status_produk'   => 'aktif',
                'deskripsi_produk'=> 'Waffle bubble khas Hong Kong dengan 2 scoop gelato pilihan dan toping bebas',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
            [
                'id_kategori'     => 6,
                'user_id'         => 3,
                'nama_produk'     => 'Pancake Stack Berry',
                'harga'           => 42000.00,
                'stok'            => 30,
                'foto'            => 'produk/pancake-berry.jpg',
                'status_produk'   => 'aktif',
                'deskripsi_produk'=> 'Tumpukan pancake fluffy dengan mixed berry segar, maple syrup, dan butter',
                'created_at'      => $now,
                'updated_at'      => $now,
            ],
        ]);
    }
}