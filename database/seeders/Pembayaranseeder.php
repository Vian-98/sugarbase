<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PembayaranSeeder extends Seeder
{
    /**
     * Seed tabel pembayaran.
     *
     * Aturan:
     *   - Pesanan 'selesai'     → status_pembayaran = 'lunas'
     *   - Pesanan 'dikirim'     → status_pembayaran = 'lunas'
     *   - Pesanan 'diproses'    → status_pembayaran = 'lunas'
     *   - Pesanan 'pending'     → status_pembayaran = 'menunggu'
     *   - Pesanan 'dibatalkan'  → status_pembayaran = 'gagal'
     *
     * Metode pembayaran: transfer / cod / ewallet
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('pembayaran')->insert([
            /* Pesanan 1 - Citra - selesai */
            [
                'id_pesanan'         => 1,
                'metode_pembayaran'  => 'transfer',
                'status_pembayaran'  => 'lunas',
                'tanggal_bayar'      => $now->copy()->subDays(3)->toDateString(),
                'jumlah_bayar'       => 194000.00,
                'created_at'         => $now->copy()->subDays(3),
                'updated_at'         => $now->copy()->subDays(3),
            ],

            /* Pesanan 2 - Dani - selesai */
            [
                'id_pesanan'         => 2,
                'metode_pembayaran'  => 'ewallet',
                'status_pembayaran'  => 'lunas',
                'tanggal_bayar'      => $now->copy()->subDays(5)->toDateString(),
                'jumlah_bayar'       => 172000.00,
                'created_at'         => $now->copy()->subDays(5),
                'updated_at'         => $now->copy()->subDays(5),
            ],

            /* Pesanan 3 - Gita - dikirim */
            [
                'id_pesanan'         => 3,
                'metode_pembayaran'  => 'transfer',
                'status_pembayaran'  => 'lunas',
                'tanggal_bayar'      => $now->copy()->subDays(7)->toDateString(),
                'jumlah_bayar'       => 169000.00,
                'created_at'         => $now->copy()->subDays(7),
                'updated_at'         => $now->copy()->subDays(7),
            ],

            /* Pesanan 4 - Indah - dikirim */
            [
                'id_pesanan'         => 4,
                'metode_pembayaran'  => 'ewallet',
                'status_pembayaran'  => 'lunas',
                'tanggal_bayar'      => $now->copy()->subDays(2)->toDateString(),
                'jumlah_bayar'       => 119000.00,
                'created_at'         => $now->copy()->subDays(2),
                'updated_at'         => $now->copy()->subDays(2),
            ],

            /* Pesanan 5 - Fajar - diproses */
            [
                'id_pesanan'         => 5,
                'metode_pembayaran'  => 'cod',
                'status_pembayaran'  => 'lunas',
                'tanggal_bayar'      => $now->copy()->subDays(1)->toDateString(),
                'jumlah_bayar'       => 148000.00,
                'created_at'         => $now->copy()->subDays(1),
                'updated_at'         => $now->copy()->subDays(1),
            ],

            /* Pesanan 6 - Joko - pending (belum bayar) */
            [
                'id_pesanan'         => 6,
                'metode_pembayaran'  => 'transfer',
                'status_pembayaran'  => 'menunggu',
                'tanggal_bayar'      => $now->toDateString(),
                'jumlah_bayar'       => 95000.00,
                'created_at'         => $now,
                'updated_at'         => $now,
            ],

            /* Pesanan 7 - Rina - pending (belum bayar) */
            [
                'id_pesanan'         => 7,
                'metode_pembayaran'  => 'ewallet',
                'status_pembayaran'  => 'menunggu',
                'tanggal_bayar'      => $now->toDateString(),
                'jumlah_bayar'       => 207000.00,
                'created_at'         => $now,
                'updated_at'         => $now,
            ],

            /* Pesanan 8 - Budi - dibatalkan */
            [
                'id_pesanan'         => 8,
                'metode_pembayaran'  => 'transfer',
                'status_pembayaran'  => 'gagal',
                'tanggal_bayar'      => $now->copy()->subDays(10)->toDateString(),
                'jumlah_bayar'       => 85000.00,
                'created_at'         => $now->copy()->subDays(10),
                'updated_at'         => $now->copy()->subDays(9),
            ],

            /* Pesanan 9 - Eka - selesai */
            [
                'id_pesanan'         => 9,
                'metode_pembayaran'  => 'ewallet',
                'status_pembayaran'  => 'lunas',
                'tanggal_bayar'      => $now->copy()->subDays(14)->toDateString(),
                'jumlah_bayar'       => 260000.00,
                'created_at'         => $now->copy()->subDays(14),
                'updated_at'         => $now->copy()->subDays(14),
            ],

            /* Pesanan 10 - Hendra - diproses */
            [
                'id_pesanan'         => 10,
                'metode_pembayaran'  => 'cod',
                'status_pembayaran'  => 'menunggu',
                'tanggal_bayar'      => $now->toDateString(),
                'jumlah_bayar'       => 122000.00,
                'created_at'         => $now,
                'updated_at'         => $now,
            ],
        ]);
    }
}