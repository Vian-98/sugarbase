<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use App\Models\Pembayaran;

class PembayaranController extends Controller
{
    public function konfirmasi($id)
    {
        $pembayaran = Pembayaran::with('pesanan')->findOrFail($id);
        $pembayaran->update(['status_pembayaran' => 'lunas']);
        $pembayaran->pesanan->update(['status_pesanan' => 'diproses']);

        Notifikasi::create([
            'user_id'     => $pembayaran->pesanan->user_id,
            'judul'       => 'Pembayaran Dikonfirmasi',
            'pesan'       => "Pembayaran pesanan #{$pembayaran->id_pesanan} telah dikonfirmasi.",
            'waktu_kirim' => now(),
            'status_baca' => 'belum',
        ]);

        return redirect()->back()->with('success', 'Pembayaran dikonfirmasi.');
    }
}