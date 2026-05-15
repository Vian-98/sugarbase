<?php

namespace App\Http\Controllers;

use App\Models\User;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = User::where('role', '!=', 'admin')->paginate(15);
        return view('pelanggan.index', compact('pelanggan'));
    }

    public function show($id)
    {
        $pelanggan = User::findOrFail($id);
        $pesanan = $pelanggan->pesanan()->with('items', 'pembayaran', 'tracking')->get();
        return view('pelanggan.show', compact('pelanggan', 'pesanan'));
    }
}
