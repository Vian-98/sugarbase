<?php
namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function milikSaya(Request $request)
    {
        $query = Pesanan::with('pembayaran', 'items.produk')
            ->where('user_id', Auth::id())
            ->latest();

        if ($request->status && $request->status !== 'semua') {
            $query->where('status_pesanan', $request->status);
        }

        $pesanan = $query->get();

        // ✅ Hitung total per status untuk filter badge
        $totalPerStatus = [
            'semua' => Pesanan::where('user_id', Auth::id())->count(),
            'pending' => Pesanan::where('user_id', Auth::id())->where('status_pesanan', 'pending')->count(),
            'diproses' => Pesanan::where('user_id', Auth::id())->where('status_pesanan', 'diproses')->count(),
            'dikirim' => Pesanan::where('user_id', Auth::id())->where('status_pesanan', 'dikirim')->count(),
            'selesai' => Pesanan::where('user_id', Auth::id())->where('status_pesanan', 'selesai')->count(),
            'dibatalkan' => Pesanan::where('user_id', Auth::id())->where('status_pesanan', 'dibatalkan')->count(),
        ];

        return view('pesanan.saya', compact('pesanan', 'totalPerStatus'));
    }

    public function show($id)
    {
        $pesanan = Pesanan::with('pembayaran', 'items.produk', 'user')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('pesanan.show', compact('pesanan'));
    }
}