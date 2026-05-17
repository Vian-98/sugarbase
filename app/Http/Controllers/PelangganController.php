<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', '!=', 'admin');

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($subQuery) use ($q) {
                $subQuery->where('name', 'like', '%' . $q . '%')
                    ->orWhere('email', 'like', '%' . $q . '%')
                    ->orWhere('phone', 'like', '%' . $q . '%')
                    ->orWhere('id', 'like', '%' . $q . '%');
            });
        }

        $pelanggan = $query->paginate(15)->appends($request->query());
        return view('pelanggan.index', compact('pelanggan'));
    }

    public function show($id)
    {
        $pelanggan = User::findOrFail($id);
        $pesanan = $pelanggan->pesanan()->with('items', 'pembayaran', 'tracking')->get();
        return view('pelanggan.show', compact('pelanggan', 'pesanan'));
    }
}
