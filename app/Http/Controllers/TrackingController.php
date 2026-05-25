<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class TrackingController extends Controller
{
    public function show($id)
    {
        $pesanan = Pesanan::with([
            'tracking' => fn($q) => $q->orderBy('waktu_update', 'asc'),
            'items.produk',
            'pembayaran',
            'user'
        ])->where('user_id', Auth::id())
         ->findOrFail($id);

        return view('tracking.show', compact('pesanan'));
    }

    public function status($id)
    {
        $pesanan = Pesanan::with('tracking')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return response()->json($pesanan->tracking);
    }
}
