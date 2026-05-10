<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $query = Pesanan::with(['user', 'pembayaran'])->latest();

        if ($request->status && $request->status !== 'Semua') {
            $query->where('status_pesanan', $request->status);
        }

        $pesanan      = $query->get();
        $totalRevenue = Pesanan::whereDate('created_at', today())
            ->where('status_pesanan', '!=', 'dibatalkan')
            ->sum('total_harga');

        return view('admin.pesanan.index', compact('pesanan', 'totalRevenue'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,dikirim,selesai,dibatalkan'
        ]);

        Pesanan::findOrFail($id)->update(['status_pesanan' => $request->status]);

        return back()->with('success', 'Status pesanan diperbarui.');
    }
}