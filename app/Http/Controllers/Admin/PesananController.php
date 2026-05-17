<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\TrackingStatus;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $query = Pesanan::with(['user', 'pembayaran'])->latest();

        if ($request->status && $request->status !== 'semua') {
            $query->where('status_pesanan', $request->status);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($subQuery) use ($q) {
                $subQuery->where('id_pesanan', 'like', '%' . $q . '%')
                    ->orWhereHas('user', function ($userQuery) use ($q) {
                        $userQuery->where('name', 'like', '%' . $q . '%')
                            ->orWhere('email', 'like', '%' . $q . '%');
                    });
            });
        }

        $pesanan = $query->get();
        
        // Calculate revenue for TODAY (before status filtering)
        $revenueHariIni = Pesanan::whereDate('tanggal_pesan', today())
            ->where('status_pesanan', '!=', 'dibatalkan')
            ->sum('total_harga');

        return view('admin.pesanan.index', compact('pesanan', 'revenueHariIni'));
    }

    public function show($id)
    {
        $pesanan = Pesanan::with(['user', 'items.produk', 'pembayaran', 'tracking'])->findOrFail($id);
        return view('admin.pesanan.show', compact('pesanan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,dikirim,selesai,dibatalkan'
        ]);

        Pesanan::findOrFail($id)->update(['status_pesanan' => $request->status]);

        return back()->with('success', 'Status pesanan diperbarui.');
    }

    public function addTracking(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string',
            'keterangan' => 'nullable|string'
        ]);

        $pesanan = Pesanan::findOrFail($id);

        TrackingStatus::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'status' => $request->status,
            'waktu_update' => now(),
            'keterangan' => $request->keterangan ?? ''
        ]);

        return back()->with('success', 'Tracking pesanan ditambahkan.');
    }
}