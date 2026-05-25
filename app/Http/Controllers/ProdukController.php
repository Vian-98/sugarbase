<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Tampilkan semua produk
     */
    public function index(Request $request)
    {
        $query = Produk::with('kategori')->latest();

        if ($request->filled('q')) {
            $query->where('nama_produk', 'like', '%' . $request->q . '%');
        }

        $produk = $query->get();
        return view('produk.index', compact('produk'));
    }

    /**
     * Form tambah produk
     */
    public function create()
    {
        $kategori = Kategori::all();
        return view('produk.create', compact('kategori'));
    }

    /**
     * Simpan produk
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'id_kategori' => 'required',
            'foto' => 'nullable|image', // ⬅️ ini yang kita ubah
            'deskripsi_produk' => 'nullable'
        ]);

        $path = null;

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('produk', 'public');
        }

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'id_kategori' => $request->id_kategori,
            'foto' => $path,
            'status_produk' => 'aktif',
            'deskripsi_produk' => $request->deskripsi_produk,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Form edit produk
     */
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategori = Kategori::all();

        return view('produk.edit', compact('produk', 'kategori'));
    }

    /**
     * Update produk
     */
    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'nama_produk' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|integer',
            'id_kategori' => 'required',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'deskripsi_produk' => 'nullable'
        ]);

        $path = $produk->foto;

        if ($request->hasFile('foto')) {
            // hapus foto lama
            if ($produk->foto) {
                Storage::disk('public')->delete($produk->foto);
            }

            $path = $request->file('foto')->store('produk', 'public');
        }

        $produk->update([
            'nama_produk' => $request->nama_produk,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'id_kategori' => $request->id_kategori,
            'foto' => $path,
            'deskripsi_produk' => $request->deskripsi_produk,
        ]);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diupdate');
    }

    /**
     * Hapus produk
     */
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->foto) {
            Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();

        return back()->with('success', 'Produk berhasil dihapus');
    }

    public function show($id)
    {
        $produk = Produk::with('kategori')->findOrFail($id);
        return view('produk.show', compact('produk'));
    }
}