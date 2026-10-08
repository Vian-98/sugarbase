<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TrackingStatusSeeder extends Seeder
{
    /**
     * Seed tabel tracking_status dengan timeline pengiriman realistis.
     *
     * Setiap pesanan memiliki beberapa entry tracking yang merepresentasikan
     * perjalanan pesanan dari 'Pesanan Diterima' hingga status terakhirnya.
     *
     * Hanya pesanan yang pernah diproses yang memiliki tracking.
     * Pesanan pending (6, 7) → hanya 1 entry awal.
     * Pesanan dibatalkan (8) → ada entry pembatalan.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('tracking_status')->insert([
            /*
             * ── PESANAN 1 (Citra) - SELESAI ──────────────────────────
             */
            [
                'id_pesanan'   => 1,
                'status'       => 'Pesanan Diterima',
                'waktu_update' => $now->copy()->subDays(3)->setTime(10, 0),
                'keterangan'   => 'Pesanan #0001 berhasil dibuat dan menunggu konfirmasi pembayaran.',
                'created_at'   => $now->copy()->subDays(3),
                'updated_at'   => $now->copy()->subDays(3),
            ],
            [
                'id_pesanan'   => 1,
                'status'       => 'Pembayaran Dikonfirmasi',
                'waktu_update' => $now->copy()->subDays(3)->setTime(10, 30),
                'keterangan'   => 'Pembayaran via transfer bank sebesar Rp194.000 telah dikonfirmasi.',
                'created_at'   => $now->copy()->subDays(3),
                'updated_at'   => $now->copy()->subDays(3),
            ],
            [
                'id_pesanan'   => 1,
                'status'       => 'Sedang Diproses',
                'waktu_update' => $now->copy()->subDays(3)->setTime(11, 0),
                'keterangan'   => 'Produk sedang disiapkan oleh tim dapur SugarBase.',
                'created_at'   => $now->copy()->subDays(3),
                'updated_at'   => $now->copy()->subDays(3),
            ],
            [
                'id_pesanan'   => 1,
                'status'       => 'Dalam Pengiriman',
                'waktu_update' => $now->copy()->subDays(2)->setTime(9, 0),
                'keterangan'   => 'Pesanan sedang dalam perjalanan menuju lokasi penerima.',
                'created_at'   => $now->copy()->subDays(2),
                'updated_at'   => $now->copy()->subDays(2),
            ],
            [
                'id_pesanan'   => 1,
                'status'       => 'Pesanan Selesai',
                'waktu_update' => $now->copy()->subDays(1)->setTime(14, 30),
                'keterangan'   => 'Pesanan telah diterima oleh Citra Dewi. Terima kasih sudah berbelanja!',
                'created_at'   => $now->copy()->subDays(1),
                'updated_at'   => $now->copy()->subDays(1),
            ],

            /*
             * ── PESANAN 2 (Dani) - SELESAI ───────────────────────────
             */
            [
                'id_pesanan'   => 2,
                'status'       => 'Pesanan Diterima',
                'waktu_update' => $now->copy()->subDays(5)->setTime(13, 0),
                'keterangan'   => 'Pesanan #0002 berhasil dibuat dan menunggu konfirmasi pembayaran.',
                'created_at'   => $now->copy()->subDays(5),
                'updated_at'   => $now->copy()->subDays(5),
            ],
            [
                'id_pesanan'   => 2,
                'status'       => 'Pembayaran Dikonfirmasi',
                'waktu_update' => $now->copy()->subDays(5)->setTime(13, 15),
                'keterangan'   => 'Pembayaran via e-wallet sebesar Rp172.000 telah dikonfirmasi.',
                'created_at'   => $now->copy()->subDays(5),
                'updated_at'   => $now->copy()->subDays(5),
            ],
            [
                'id_pesanan'   => 2,
                'status'       => 'Sedang Diproses',
                'waktu_update' => $now->copy()->subDays(5)->setTime(14, 0),
                'keterangan'   => 'Pesanan sedang disiapkan oleh tim dapur SugarBase.',
                'created_at'   => $now->copy()->subDays(5),
                'updated_at'   => $now->copy()->subDays(5),
            ],
            [
                'id_pesanan'   => 2,
                'status'       => 'Dalam Pengiriman',
                'waktu_update' => $now->copy()->subDays(4)->setTime(10, 0),
                'keterangan'   => 'Pesanan dikemas dan sedang dikirim ke alamat tujuan.',
                'created_at'   => $now->copy()->subDays(4),
                'updated_at'   => $now->copy()->subDays(4),
            ],
            [
                'id_pesanan'   => 2,
                'status'       => 'Pesanan Selesai',
                'waktu_update' => $now->copy()->subDays(2)->setTime(16, 0),
                'keterangan'   => 'Pesanan telah diterima oleh Dani Pratama. Terima kasih!',
                'created_at'   => $now->copy()->subDays(2),
                'updated_at'   => $now->copy()->subDays(2),
            ],

            /*
             * ── PESANAN 3 (Gita) - DIKIRIM ───────────────────────────
             */
            [
                'id_pesanan'   => 3,
                'status'       => 'Pesanan Diterima',
                'waktu_update' => $now->copy()->subDays(7)->setTime(9, 0),
                'keterangan'   => 'Pesanan #0003 berhasil dibuat.',
                'created_at'   => $now->copy()->subDays(7),
                'updated_at'   => $now->copy()->subDays(7),
            ],
            [
                'id_pesanan'   => 3,
                'status'       => 'Pembayaran Dikonfirmasi',
                'waktu_update' => $now->copy()->subDays(7)->setTime(9, 30),
                'keterangan'   => 'Pembayaran Rp169.000 dikonfirmasi.',
                'created_at'   => $now->copy()->subDays(7),
                'updated_at'   => $now->copy()->subDays(7),
            ],
            [
                'id_pesanan'   => 3,
                'status'       => 'Sedang Diproses',
                'waktu_update' => $now->copy()->subDays(6)->setTime(10, 0),
                'keterangan'   => 'Sedang diproses di dapur.',
                'created_at'   => $now->copy()->subDays(6),
                'updated_at'   => $now->copy()->subDays(6),
            ],
            [
                'id_pesanan'   => 3,
                'status'       => 'Dalam Pengiriman',
                'waktu_update' => $now->copy()->subDays(1)->setTime(8, 0),
                'keterangan'   => 'Pesanan sedang dalam perjalanan. Estimasi tiba hari ini.',
                'created_at'   => $now->copy()->subDays(1),
                'updated_at'   => $now->copy()->subDays(1),
            ],

            /*
             * ── PESANAN 4 (Indah) - DIKIRIM ──────────────────────────
             */
            [
                'id_pesanan'   => 4,
                'status'       => 'Pesanan Diterima',
                'waktu_update' => $now->copy()->subDays(2)->setTime(15, 0),
                'keterangan'   => 'Pesanan #0004 berhasil dibuat.',
                'created_at'   => $now->copy()->subDays(2),
                'updated_at'   => $now->copy()->subDays(2),
            ],
            [
                'id_pesanan'   => 4,
                'status'       => 'Pembayaran Dikonfirmasi',
                'waktu_update' => $now->copy()->subDays(2)->setTime(15, 20),
                'keterangan'   => 'Pembayaran e-wallet Rp119.000 diterima.',
                'created_at'   => $now->copy()->subDays(2),
                'updated_at'   => $now->copy()->subDays(2),
            ],
            [
                'id_pesanan'   => 4,
                'status'       => 'Sedang Diproses',
                'waktu_update' => $now->copy()->subDays(1)->setTime(9, 0),
                'keterangan'   => 'Produk sedang disiapkan.',
                'created_at'   => $now->copy()->subDays(1),
                'updated_at'   => $now->copy()->subDays(1),
            ],
            [
                'id_pesanan'   => 4,
                'status'       => 'Dalam Pengiriman',
                'waktu_update' => $now->copy()->subDays(1)->setTime(13, 0),
                'keterangan'   => 'Pesanan sedang dikirim. Estimasi tiba besok.',
                'created_at'   => $now->copy()->subDays(1),
                'updated_at'   => $now->copy()->subDays(1),
            ],

            /*
             * ── PESANAN 5 (Fajar) - DIPROSES ─────────────────────────
             */
            [
                'id_pesanan'   => 5,
                'status'       => 'Pesanan Diterima',
                'waktu_update' => $now->copy()->subDays(1)->setTime(11, 0),
                'keterangan'   => 'Pesanan #0005 berhasil diterima.',
                'created_at'   => $now->copy()->subDays(1),
                'updated_at'   => $now->copy()->subDays(1),
            ],
            [
                'id_pesanan'   => 5,
                'status'       => 'Pembayaran Dikonfirmasi',
                'waktu_update' => $now->copy()->subDays(1)->setTime(11, 10),
                'keterangan'   => 'Pembayaran COD Rp148.000 dikonfirmasi.',
                'created_at'   => $now->copy()->subDays(1),
                'updated_at'   => $now->copy()->subDays(1),
            ],
            [
                'id_pesanan'   => 5,
                'status'       => 'Sedang Diproses',
                'waktu_update' => $now->copy()->subHours(6)->setTime(10, 0),
                'keterangan'   => 'Tim dapur sedang mempersiapkan pesanan Anda.',
                'created_at'   => $now->copy()->subHours(6),
                'updated_at'   => $now->copy()->subHours(6),
            ],

            /*
             * ── PESANAN 6 (Joko) - PENDING ───────────────────────────
             */
            [
                'id_pesanan'   => 6,
                'status'       => 'Pesanan Diterima',
                'waktu_update' => $now,
                'keterangan'   => 'Pesanan #0006 berhasil dibuat. Menunggu konfirmasi pembayaran transfer.',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],

            /*
             * ── PESANAN 7 (Rina) - PENDING ───────────────────────────
             */
            [
                'id_pesanan'   => 7,
                'status'       => 'Pesanan Diterima',
                'waktu_update' => $now,
                'keterangan'   => 'Pesanan #0007 berhasil dibuat. Menunggu konfirmasi pembayaran e-wallet.',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],

            /*
             * ── PESANAN 8 (Budi) - DIBATALKAN ────────────────────────
             */
            [
                'id_pesanan'   => 8,
                'status'       => 'Pesanan Diterima',
                'waktu_update' => $now->copy()->subDays(10)->setTime(14, 0),
                'keterangan'   => 'Pesanan #0008 berhasil dibuat.',
                'created_at'   => $now->copy()->subDays(10),
                'updated_at'   => $now->copy()->subDays(10),
            ],
            [
                'id_pesanan'   => 8,
                'status'       => 'Pesanan Dibatalkan',
                'waktu_update' => $now->copy()->subDays(9)->setTime(9, 0),
                'keterangan'   => 'Pesanan dibatalkan karena pembayaran tidak diterima dalam 24 jam.',
                'created_at'   => $now->copy()->subDays(9),
                'updated_at'   => $now->copy()->subDays(9),
            ],

            /*
             * ── PESANAN 9 (Eka) - SELESAI ────────────────────────────
             */
            [
                'id_pesanan'   => 9,
                'status'       => 'Pesanan Diterima',
                'waktu_update' => $now->copy()->subDays(14)->setTime(10, 0),
                'keterangan'   => 'Pesanan #0009 berhasil dibuat.',
                'created_at'   => $now->copy()->subDays(14),
                'updated_at'   => $now->copy()->subDays(14),
            ],
            [
                'id_pesanan'   => 9,
                'status'       => 'Pembayaran Dikonfirmasi',
                'waktu_update' => $now->copy()->subDays(14)->setTime(10, 30),
                'keterangan'   => 'Pembayaran e-wallet Rp260.000 dikonfirmasi.',
                'created_at'   => $now->copy()->subDays(14),
                'updated_at'   => $now->copy()->subDays(14),
            ],
            [
                'id_pesanan'   => 9,
                'status'       => 'Sedang Diproses',
                'waktu_update' => $now->copy()->subDays(13)->setTime(9, 0),
                'keterangan'   => 'Produk sedang disiapkan.',
                'created_at'   => $now->copy()->subDays(13),
                'updated_at'   => $now->copy()->subDays(13),
            ],
            [
                'id_pesanan'   => 9,
                'status'       => 'Dalam Pengiriman',
                'waktu_update' => $now->copy()->subDays(12)->setTime(11, 0),
                'keterangan'   => 'Pesanan dalam perjalanan.',
                'created_at'   => $now->copy()->subDays(12),
                'updated_at'   => $now->copy()->subDays(12),
            ],
            [
                'id_pesanan'   => 9,
                'status'       => 'Pesanan Selesai',
                'waktu_update' => $now->copy()->subDays(11)->setTime(15, 0),
                'keterangan'   => 'Pesanan telah diterima oleh Eka Putri. Terima kasih!',
                'created_at'   => $now->copy()->subDays(11),
                'updated_at'   => $now->copy()->subDays(11),
            ],

            /*
             * ── PESANAN 10 (Hendra) - DIPROSES ───────────────────────
             */
            [
                'id_pesanan'   => 10,
                'status'       => 'Pesanan Diterima',
                'waktu_update' => $now->setTime(8, 30),
                'keterangan'   => 'Pesanan #0010 berhasil dibuat. Pembayaran COD akan dikonfirmasi saat pengiriman.',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
            [
                'id_pesanan'   => 10,
                'status'       => 'Sedang Diproses',
                'waktu_update' => $now->setTime(9, 30),
                'keterangan'   => 'Tim dapur sedang menyiapkan Waffle Nutella Banana dan Ice Cream Sandwich.',
                'created_at'   => $now,
                'updated_at'   => $now,
            ],
        ]);
    }
}