<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    /**
     * Tampilkan semua notifikasi
     */
    public function index()
    {
        $notifikasi = Notifikasi::orderByRaw("
                CASE 
                    WHEN status_baca = 'belum' THEN 0
                    ELSE 1
                END
            ")
            ->orderBy('waktu_kirim', 'desc')
            ->get();

        return view('notifikasi.index', compact('notifikasi'));
    }

    /**
     * Tandai 1 notifikasi sebagai sudah dibaca
     */
    public function markAsRead($id)
    {
        $notif = Notifikasi::findOrFail($id);
        $notif->status_baca = 'sudah';
        $notif->save();

        return back();
    }

    /**
     * Tandai semua notifikasi sebagai sudah dibaca
     */
    public function markAllAsRead()
    {
        Notifikasi::where('status_baca', 'belum')
            ->update(['status_baca' => 'sudah']);

        return back();
    }
}