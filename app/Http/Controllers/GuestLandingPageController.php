<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestLandingPageController extends Controller
{
    /**
     * Display the guest landing page (read-only view)
     * Shows products and categories but no action buttons
     * If user is logged in, redirect to their dashboard
     */
    public function index()
    {
        // Jika user sudah login, redirect ke beranda atau admin dashboard
        if (Auth::check()) {
            return redirect(Auth::user()->role === 'admin' ? '/admin/dashboard' : '/beranda');
        }

        // Ambil semua kategori
        $kategori = Kategori::all();

        // Ambil produk terlaris (berdasarkan stok terbanyak)
        $produkTerlaris = Produk::where('status_produk', 'aktif')
            ->orderBy('stok', 'desc')
            ->take(8)
            ->get();

        // Ambil produk terbaru
        $produkTerbaru = Produk::where('status_produk', 'aktif')
            ->latest()
            ->take(4)
            ->get();

        return view('guest.landing', compact('kategori', 'produkTerlaris', 'produkTerbaru'));
    }

    /**
     * Show product details (read-only for guest)
     */
    public function showProduct($id)
    {
        // Jika user sudah login, redirect ke produk authenticated
        if (Auth::check()) {
            return redirect("/produk/{$id}");
        }

        $produk = Produk::with('kategori')->findOrFail($id);
        return view('guest.product-detail', compact('produk'));
    }

    /**
     * Show katalog (all products) for guest
     */
    public function katalog(Request $request)
    {
        // Jika user sudah login, redirect ke katalog authenticated
        if (Auth::check()) {
            return redirect('/katalog?' . http_build_query($request->query()));
        }

        $query = Produk::where('status_produk', 'aktif');

        if ($request->kategori) {
            $query->where('id_kategori', $request->kategori);
        }

        if ($request->search) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        $produk = $query->paginate(12);
        $kategori = Kategori::all();

        return view('guest.katalog', compact('produk', 'kategori'));
    }
}
