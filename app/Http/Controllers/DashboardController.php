<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil statistik dari database
        $totalUser = DB::table('users')->count();
        $totalProduk = DB::table('produk')->count();
        $totalPesanan = DB::table('pesanan')->count();
        $totalKategori = DB::table('kategori')->count();
        
        return view('admin.dashboard', [
            'totalAkun' => $totalUser,
            'totalProduk' => $totalProduk,
            'totalPesanan' => $totalPesanan,
            'totalKategori' => $totalKategori,
        ]);
    }
}
