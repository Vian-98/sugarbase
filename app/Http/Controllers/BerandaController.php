<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    /**
     * Display the home page with featured products and categories
     */
    public function index()
    {
        // Ambil semua kategori
        $kategori = Kategori::all();

        // Ambil produk terlaris (berdasarkan stok terbanyak)
        // Note: pesanan_item table dihapus karena empty dan unused
        $produkTerlaris = Produk::where('status_produk', 'aktif')
            ->orderBy('stok', 'desc')
            ->take(8)
            ->get();

        // Ambil produk terbaru
        $produkTerbaru = Produk::where('status_produk', 'aktif')
            ->latest()
            ->take(4)
            ->get();

        return view('beranda.index', compact('kategori', 'produkTerlaris', 'produkTerbaru'));
    }
}
