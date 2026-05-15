<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\TrackingStatus;
use App\Models\Notifikasi;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function tambah(Request $request, $id_pesanan)
    {
        $request->validate([
            'status'     => 'required|string|max:50',
            'keterangan' => 'required|string|max:255',
        ]);

        TrackingStatus::create([
            'id_pesanan'   => $id_pesanan,
            'status'       => $request->status,
            'waktu_update' => now(),
            'keterangan'   => $request->keterangan,
        ]);

        $statusMap = [
            'Sedang Diproses'       => 'diproses',
            'Dalam Pengiriman'      => 'dikirim',
            'Pesanan Selesai'       => 'selesai',
            'Pesanan Dibatalkan'    => 'dibatalkan',
        ];

        if (isset($statusMap[$request->status])) {
            $pesanan = Pesanan::find($id_pesanan);
            $pesanan->update(['status_pesanan' => $statusMap[$request->status]]);

            Notifikasi::create([
                'user_id'     => $pesanan->user_id,
                'judul'       => 'Update Pesanan #' . $id_pesanan,
                'pesan'       => $request->keterangan,
                'waktu_kirim' => now(),
                'status_baca' => 'belum',
            ]);
        }

        return redirect()->back()->with('success', 'Status tracking diperbarui.');
    }
}
