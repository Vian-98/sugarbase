<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    /**
     * Tampilkan semua notifikasi
     */
    public function index()
    {
        $notifikasi = Notifikasi::where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->orderByRaw("
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
        $notif = Notifikasi::where('id_notifikasi', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notif->status_baca = 'sudah';
        $notif->save();

        // If AJAX/JSON requested, return json with new admin total
        if (request()->wantsJson() || request()->ajax()) {
            $adminTotal = Notifikasi::where('status_baca', 'belum')->count();
            return response()->json(['ok' => true, 'admin_total' => $adminTotal]);
        }

        return back();
    }

    /**
     * Tandai semua notifikasi sebagai sudah dibaca
     */
    public function markAllAsRead()
    {
        Notifikasi::where('user_id', Auth::id())
            ->where('status_baca', 'belum')
            ->update(['status_baca' => 'sudah']);

        if (request()->wantsJson() || request()->ajax()) {
            $adminTotal = Notifikasi::where('status_baca', 'belum')->count();
            return response()->json(['ok' => true, 'admin_total' => $adminTotal]);
        }

        return back();
    }
}