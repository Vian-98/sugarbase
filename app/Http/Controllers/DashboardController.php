<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic counts
        $totalUser = DB::table('users')->count();
        $totalProduk = DB::table('produk')->count();
        $totalPesanan = DB::table('pesanan')->count();
        $totalKategori = DB::table('kategori')->count();

        // Revenue calculations
        $today = Carbon::today();
        $revenueToday = Pesanan::whereDate('tanggal_pesan', $today)
            ->where('status_pesanan', '!=', 'dibatalkan')
            ->sum('total_harga');

        $totalRevenue = Pesanan::where('status_pesanan', '!=', 'dibatalkan')
            ->sum('total_harga');

        $currentMonth = Carbon::now()->startOfMonth();
        $revenueMonth = Pesanan::whereDate('tanggal_pesan', '>=', $currentMonth)
            ->where('status_pesanan', '!=', 'dibatalkan')
            ->sum('total_harga');

        // Active products
        $produkAktif = DB::table('produk')->where('status_produk', 'aktif')->count();

        // Total customers (non-admin users)
        $totalPelanggan = DB::table('users')->where('role', '!=', 'admin')->count();

        // Chart data - 7 days trend
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $chartLabels[] = $date->format('d M');
            $count = Pesanan::whereDate('tanggal_pesan', $date)->count();
            $chartData[] = $count;
        }

        return view('admin.dashboard', [
            'totalAkun' => $totalUser,
            'totalProduk' => $totalProduk,
            'totalPesanan' => $totalPesanan,
            'totalKategori' => $totalKategori,
            'revenueToday' => $revenueToday ?? 0,
            'revenue' => $totalRevenue ?? 0,
            'revenueMonth' => $revenueMonth ?? 0,
            'produkAktif' => $produkAktif,
            'totalPelanggan' => $totalPelanggan,
            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
        ]);
    }
}
