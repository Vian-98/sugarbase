<?php
namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function milikSaya(Request $request)
    {
        $query = Pesanan::with('pembayaran')
            ->where('user_id', Auth::id())
            ->latest();

        if ($request->status && $request->status !== 'Semua') {
            $query->where('status_pesanan', $request->status);
        }

        $pesanan = $query->get();

        return view('pesanan.saya', compact('pesanan'));
    }
}