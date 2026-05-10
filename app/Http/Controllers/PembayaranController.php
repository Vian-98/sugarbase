<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function show($id)
    {
        $pesanan = Pesanan::with(['items.produk', 'pembayaran'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('pembayaran.show', compact('pesanan'));
    }

    public function konfirmasiPelanggan($id)
    {
        $pesanan = Pesanan::where('user_id', Auth::id())->findOrFail($id);
        $pesanan->pembayaran->update(['status_pembayaran' => 'lunas']);

        return redirect('/pesanan/saya')->with('success', 'Pembayaran dikonfirmasi! Pesanan sedang diproses.');
    }
}