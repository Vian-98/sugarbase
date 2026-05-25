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
        try {
            $pembayaran = Pembayaran::whereHas('pesanan',
                fn($q) => $q->where('user_id', Auth::id())
            )->findOrFail($id);

            $pembayaran->update(['status_pembayaran' => 'menunggu']);

            Notifikasi::create([
                'user_id'     => Auth::id(),
                'judul'       => 'Menunggu Konfirmasi Admin',
                'pesan'       => "Pembayaran pesanan #{$pembayaran->id_pesanan} sedang menunggu konfirmasi admin.",
                'waktu_kirim' => now(),
                'status_baca' => 'belum',
            ]);

            return redirect('/pesanan/saya')
                ->with('success', 'Laporan pembayaran berhasil dikirim! Menunggu konfirmasi admin.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengirim konfirmasi. Silakan coba lagi.');
        }
    }
}