<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil statistik dari database
        $totalUser      = DB::table('users')->count();
        $totalProduk    = DB::table('produk')->count();
        $totalPesanan   = DB::table('pesanan')->count();
        $totalKategori  = DB::table('kategori')->count();
        $totalPelanggan = DB::table('users')->where('role', 'pelanggan')->count();

        // Revenue
        $revenue = DB::table('pesanan')->sum('total_harga');

        // Produk aktif
        $produkAktif = DB::table('produk')->where('status', 'aktif')->count();

        // Data chart
        $chartLabels = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        $chartData   = [5, 8, 3, 10, 7, 4, 9];

        return view('dashboard', [
            'totalAkun'      => $totalUser,
            'totalProduk'    => $totalProduk,
            'totalPesanan'   => $totalPesanan,
            'totalKategori'  => $totalKategori,
            'totalPelanggan' => $totalPelanggan,
            'revenue'        => $revenue,
            'produkAktif'    => $produkAktif,
            'chartLabels'    => $chartLabels,
            'chartData'      => $chartData,
        ]);
    }
}