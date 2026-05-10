<?php
namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function show($id)
    {
        $pembayaran = Pembayaran::with('pesanan')
            ->whereHas('pesanan', fn($q) => $q->where('user_id', Auth::id()))
            ->findOrFail($id);

        return view('pembayaran.show', compact('pembayaran'));
    }

    public function konfirmasiPelanggan($id)
    {
        $pembayaran = Pembayaran::whereHas('pesanan',
            fn($q) => $q->where('user_id', Auth::id())
        )->findOrFail($id);

        $pembayaran->update(['status_pembayaran' => 'lunas']);
        $pembayaran->pesanan->update(['status_pesanan' => 'diproses']);

        Notifikasi::create([
            'user_id'     => Auth::id(),
            'judul'       => 'Pembayaran Dikonfirmasi',
            'pesan'       => "Pembayaran pesanan #{$pembayaran->id_pesanan} telah dikonfirmasi.",
            'waktu_kirim' => now(),
            'status_baca' => 'belum',
        ]);

        return redirect('/pesanan/saya')->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }
}