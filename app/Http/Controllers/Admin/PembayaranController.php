<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notifikasi;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with('pesanan.user')->orderBy('created_at', 'desc');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($subQuery) use ($q) {
                $subQuery->where('id_pembayaran', 'like', '%' . $q . '%')
                    ->orWhere('id_pesanan', 'like', '%' . $q . '%')
                    ->orWhere('metode_pembayaran', 'like', '%' . $q . '%')
                    ->orWhere('status_pembayaran', 'like', '%' . $q . '%')
                    ->orWhereHas('pesanan.user', function ($userQuery) use ($q) {
                        $userQuery->where('name', 'like', '%' . $q . '%')
                            ->orWhere('email', 'like', '%' . $q . '%');
                    });
            });
        }

        $pembayaran = $query->get();
        return view('admin.pembayaran.index', compact('pembayaran'));
    }

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