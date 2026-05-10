<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Search products (AJAX endpoint)
     * Returns JSON array of products
     */
    public function index(Request $request)
    {
        $q = $request->input('q', '');

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $produk = Produk::where('nama_produk', 'like', '%' . $q . '%')
            ->where('status_produk', 'aktif')
            ->select('id_produk', 'nama_produk', 'harga', 'foto')
            ->take(5)
            ->get();

        return response()->json($produk);
    }
}
