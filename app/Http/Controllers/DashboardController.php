<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil statistik dari database
        $totalAkun = DB::table('akun')->count();
        $totalProduk = DB::table('produk')->count();
        $totalPesanan = DB::table('pesanan')->count();
        $totalKategori = DB::table('kategori')->count();
        
        return view('dashboard', [
            'totalAkun' => $totalAkun,
            'totalProduk' => $totalProduk,
            'totalPesanan' => $totalPesanan,
            'totalKategori' => $totalKategori,
        ]);
    }
}
