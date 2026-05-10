<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    /**
     * Display catalog with filters and sorting
     */
    public function index(Request $request)
    {
        // Base query
        $query = Produk::with('kategori')->where('status_produk', 'aktif');

        // Filter by kategori
        if ($request->filled('kategori')) {
            $query->where('id_kategori', $request->kategori);
        }

        // Filter by search query
        if ($request->filled('q')) {
            $query->where('nama_produk', 'like', '%' . $request->q . '%');
        }

        // Sort
        $sort = $request->input('sort', 'terbaru');
        match ($sort) {
            'harga_asc' => $query->orderBy('harga', 'asc'),
            'harga_desc' => $query->orderBy('harga', 'desc'),
            'terbaru' => $query->latest(),
            default => $query->latest(),
        };

        // Paginate
        $produk = $query->paginate(12)->appends($request->query());

        // Ambil semua kategori untuk filter sidebar
        $kategori = Kategori::all();

        return view('katalog.index', compact('produk', 'kategori'));
    }
}
