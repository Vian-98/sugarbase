<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NotifikasiSeeder extends Seeder
{
    /**
     * Seed tabel notifikasi dengan berbagai jenis notifikasi sistem SugarBase.
     *
     * Jenis notifikasi yang disimulasikan:
     *   - Konfirmasi pesanan baru
     *   - Update status pengiriman
     *   - Konfirmasi pembayaran
     *   - Pesanan selesai
     *   - Promo & penawaran
     *   - Pesanan dibatalkan
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('notifikasi')->insert([
            /*
             * ── NOTIFIKASI UNTUK CITRA (user_id=6) ───────────────────
             */
            [
                'user_id'     => 6,
                'judul'       => 'Pesanan Berhasil Dibuat',
                'pesan'       => 'Pesanan #0001 sebesar Rp194.000 berhasil dibuat. Silakan selesaikan pembayaran.',
                'waktu_kirim' => $now->copy()->subDays(3)->setTime(10, 0),
                'status_baca' => 'sudah',
                'created_at'  => $now->copy()->subDays(3),
                'updated_at'  => $now->copy()->subDays(3),
            ],
            [
                'user_id'     => 6,
                'judul'       => 'Pembayaran Dikonfirmasi',
                'pesan'       => 'Pembayaran pesanan #0001 telah dikonfirmasi. Pesanan Anda sedang diproses.',
                'waktu_kirim' => $now->copy()->subDays(3)->setTime(10, 30),
                'status_baca' => 'sudah',
                'created_at'  => $now->copy()->subDays(3),
                'updated_at'  => $now->copy()->subDays(3),
            ],
            [
                'user_id'     => 6,
                'judul'       => 'Pesanan Dalam Pengiriman',
                'pesan'       => 'Pesanan #0001 Anda sedang dalam perjalanan. Estimasi tiba hari ini.',
                'waktu_kirim' => $now->copy()->subDays(2)->setTime(9, 0),
                'status_baca' => 'sudah',
                'created_at'  => $now->copy()->subDays(2),
                'updated_at'  => $now->copy()->subDays(2),
            ],
            [
                'user_id'     => 6,
                'judul'       => 'Pesanan Selesai',
                'pesan'       => 'Pesanan #0001 telah selesai. Bagaimana pengalaman berbelanja Anda? Berikan ulasan!',
                'waktu_kirim' => $now->copy()->subDays(1)->setTime(14, 30),
                'status_baca' => 'sudah',
                'created_at'  => $now->copy()->subDays(1),
                'updated_at'  => $now->copy()->subDays(1),
            ],

            /*
             * ── NOTIFIKASI UNTUK DANI (user_id=10) ───────────────────
             */
            [
                'user_id'     => 10,
                'judul'       => 'Pesanan Berhasil Dibuat',
                'pesan'       => 'Pesanan #0002 sebesar Rp172.000 berhasil dibuat.',
                'waktu_kirim' => $now->copy()->subDays(5)->setTime(13, 0),
                'status_baca' => 'sudah',
                'created_at'  => $now->copy()->subDays(5),
                'updated_at'  => $now->copy()->subDays(5),
            ],
            [
                'user_id'     => 10,
                'judul'       => 'Pesanan Selesai',
                'pesan'       => 'Pesanan #0002 telah diterima. Terima kasih sudah berbelanja di SugarBase!',
                'waktu_kirim' => $now->copy()->subDays(2)->setTime(16, 0),
                'status_baca' => 'sudah',
                'created_at'  => $now->copy()->subDays(2),
                'updated_at'  => $now->copy()->subDays(2),
            ],

            /*
             * ── NOTIFIKASI UNTUK GITA (user_id=7) ────────────────────
             */
            [
                'user_id'     => 7,
                'judul'       => 'Pesanan Berhasil Dibuat',
                'pesan'       => 'Pesanan #0003 sebesar Rp169.000 berhasil dibuat.',
                'waktu_kirim' => $now->copy()->subDays(7)->setTime(9, 0),
                'status_baca' => 'sudah',
                'created_at'  => $now->copy()->subDays(7),
                'updated_at'  => $now->copy()->subDays(7),
            ],
            [
                'user_id'     => 7,
                'judul'       => 'Pesanan Dalam Pengiriman',
                'pesan'       => 'Pesanan #0003 sedang dalam perjalanan ke alamat Anda. Estimasi tiba hari ini!',
                'waktu_kirim' => $now->copy()->subDays(1)->setTime(8, 0),
                'status_baca' => 'belum',
                'created_at'  => $now->copy()->subDays(1),
                'updated_at'  => $now->copy()->subDays(1),
            ],

            /*
             * ── NOTIFIKASI UNTUK INDAH (user_id=9) ───────────────────
             */
            [
                'user_id'     => 9,
                'judul'       => 'Pesanan Berhasil Dibuat',
                'pesan'       => 'Pesanan #0004 sebesar Rp119.000 berhasil dibuat.',
                'waktu_kirim' => $now->copy()->subDays(2)->setTime(15, 0),
                'status_baca' => 'sudah',
                'created_at'  => $now->copy()->subDays(2),
                'updated_at'  => $now->copy()->subDays(2),
            ],
            [
                'user_id'     => 9,
                'judul'       => 'Pesanan Sedang Dikirim',
                'pesan'       => 'Kabar baik! Pesanan #0004 Anda sedang dalam pengiriman. Harap pastikan ada di rumah.',
                'waktu_kirim' => $now->copy()->subDays(1)->setTime(13, 0),
                'status_baca' => 'belum',
                'created_at'  => $now->copy()->subDays(1),
                'updated_at'  => $now->copy()->subDays(1),
            ],

            /*
             * ── NOTIFIKASI UNTUK FAJAR (user_id=12) ──────────────────
             */
            [
                'user_id'     => 12,
                'judul'       => 'Pesanan Berhasil Dibuat',
                'pesan'       => 'Pesanan #0005 sebesar Rp148.000 berhasil dibuat dengan metode COD.',
                'waktu_kirim' => $now->copy()->subDays(1)->setTime(11, 0),
                'status_baca' => 'sudah',
                'created_at'  => $now->copy()->subDays(1),
                'updated_at'  => $now->copy()->subDays(1),
            ],
            [
                'user_id'     => 12,
                'judul'       => 'Pesanan Sedang Diproses',
                'pesan'       => 'Tim dapur SugarBase sedang menyiapkan Croissant Butter dan Molten Chocolate Lava Anda.',
                'waktu_kirim' => $now->copy()->subHours(6),
                'status_baca' => 'belum',
                'created_at'  => $now->copy()->subHours(6),
                'updated_at'  => $now->copy()->subHours(6),
            ],

            /*
             * ── NOTIFIKASI UNTUK JOKO (user_id=13) ───────────────────
             */
            [
                'user_id'     => 13,
                'judul'       => 'Pesanan Menunggu Pembayaran',
                'pesan'       => 'Pesanan #0006 sebesar Rp95.000 berhasil dibuat. Selesaikan transfer dalam 24 jam.',
                'waktu_kirim' => $now,
                'status_baca' => 'belum',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],

            /*
             * ── NOTIFIKASI UNTUK RINA (user_id=4) ────────────────────
             */
            [
                'user_id'     => 4,
                'judul'       => 'Pesanan Menunggu Pembayaran',
                'pesan'       => 'Pesanan #0007 sebesar Rp207.000 berhasil dibuat. Selesaikan pembayaran e-wallet.',
                'waktu_kirim' => $now,
                'status_baca' => 'belum',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'user_id'     => 4,
                'judul'       => '🍰 Promo Akhir Pekan!',
                'pesan'       => 'Dapatkan diskon 15% untuk semua produk Kue & Pastry akhir pekan ini. Gunakan kode: SUGAR15.',
                'waktu_kirim' => $now->copy()->subHours(2),
                'status_baca' => 'belum',
                'created_at'  => $now->copy()->subHours(2),
                'updated_at'  => $now->copy()->subHours(2),
            ],

            /*
             * ── NOTIFIKASI UNTUK BUDI (user_id=5) ────────────────────
             */
            [
                'user_id'     => 5,
                'judul'       => 'Pesanan Dibatalkan',
                'pesan'       => 'Pesanan #0008 dibatalkan karena batas waktu pembayaran telah habis.',
                'waktu_kirim' => $now->copy()->subDays(9)->setTime(9, 0),
                'status_baca' => 'sudah',
                'created_at'  => $now->copy()->subDays(9),
                'updated_at'  => $now->copy()->subDays(9),
            ],
            [
                'user_id'     => 5,
                'judul'       => '🍦 Produk Baru Telah Hadir!',
                'pesan'       => 'Bubble Waffle Ice Cream kini tersedia di SugarBase! Cobain sekarang sebelum kehabisan.',
                'waktu_kirim' => $now->copy()->subDays(1),
                'status_baca' => 'belum',
                'created_at'  => $now->copy()->subDays(1),
                'updated_at'  => $now->copy()->subDays(1),
            ],

            /*
             * ── NOTIFIKASI UNTUK EKA (user_id=11) ────────────────────
             */
            [
                'user_id'     => 11,
                'judul'       => 'Pesanan Selesai',
                'pesan'       => 'Pesanan #0009 telah selesai. Terima kasih telah memilih SugarBase!',
                'waktu_kirim' => $now->copy()->subDays(11)->setTime(15, 0),
                'status_baca' => 'sudah',
                'created_at'  => $now->copy()->subDays(11),
                'updated_at'  => $now->copy()->subDays(11),
            ],

            /*
             * ── NOTIFIKASI UNTUK HENDRA (user_id=8) ──────────────────
             */
            [
                'user_id'     => 8,
                'judul'       => 'Pesanan Berhasil Dibuat',
                'pesan'       => 'Pesanan #0010 sebesar Rp122.000 berhasil dibuat dengan metode COD.',
                'waktu_kirim' => $now->setTime(8, 30),
                'status_baca' => 'belum',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'user_id'     => 8,
                'judul'       => 'Pesanan Sedang Diproses',
                'pesan'       => 'Kabar baik! Pesanan #0010 Anda sedang dipersiapkan oleh tim dapur kami.',
                'waktu_kirim' => $now->setTime(9, 30),
                'status_baca' => 'belum',
                'created_at'  => $now,
                'updated_at'  => $now,
            ],

            /*
             * ── NOTIFIKASI BROADCAST - SEMUA PELANGGAN ───────────────
             * Notifikasi promo untuk beberapa pelanggan aktif
             */
            [
                'user_id'     => 4,
                'judul'       => '🎉 SugarBase Grand Launch!',
                'pesan'       => 'Selamat datang di SugarBase! Nikmati gratis ongkos kirim untuk 3 pesanan pertama Anda.',
                'waktu_kirim' => $now->copy()->subDays(30),
                'status_baca' => 'sudah',
                'created_at'  => $now->copy()->subDays(30),
                'updated_at'  => $now->copy()->subDays(30),
            ],
            [
                'user_id'     => 5,
                'judul'       => '🎉 SugarBase Grand Launch!',
                'pesan'       => 'Selamat datang di SugarBase! Nikmati gratis ongkos kirim untuk 3 pesanan pertama Anda.',
                'waktu_kirim' => $now->copy()->subDays(30),
                'status_baca' => 'sudah',
                'created_at'  => $now->copy()->subDays(30),
                'updated_at'  => $now->copy()->subDays(30),
            ],
        ]);
    }
}