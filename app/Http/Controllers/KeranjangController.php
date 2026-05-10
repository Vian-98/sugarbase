<?php
namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\KeranjangItem;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    public function index()
    {
        $keranjang = Keranjang::with('items.produk')
            ->where('user_id', Auth::id())
            ->where('status_keranjang', 'aktif')
            ->first();

        return view('keranjang.index', compact('keranjang'));
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'jumlah'    => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->id_produk);

        if ($request->jumlah > $produk->stok) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $keranjang = Keranjang::firstOrCreate(
            ['user_id' => Auth::id(), 'status_keranjang' => 'aktif'],
            ['tanggal_dibuat' => today()]
        );

        $item = $keranjang->items()->where('id_produk', $request->id_produk)->first();

        if ($item) {
            $jumlahBaru = $item->jumlah_keranjang + $request->jumlah;
            if ($jumlahBaru > $produk->stok) {
                return back()->with('error', 'Stok tidak mencukupi.');
            }
            $item->update([
                'jumlah_keranjang'   => $jumlahBaru,
                'subtotal_keranjang' => $produk->harga * $jumlahBaru,
            ]);
        } else {
            $keranjang->items()->create([
                'id_produk'              => $request->id_produk,
                'jumlah_keranjang'       => $request->jumlah,
                'harga_satuan_keranjang' => $produk->harga,
                'subtotal_keranjang'     => $produk->harga * $request->jumlah,
            ]);
        }

        return redirect('/keranjang')->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $item   = KeranjangItem::findOrFail($id);
        $produk = $item->produk;

        $request->validate(['jumlah' => 'required|integer|min:1']);

        if ($request->jumlah > $produk->stok) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $item->update([
            'jumlah_keranjang'   => $request->jumlah,
            'subtotal_keranjang' => $item->harga_satuan_keranjang * $request->jumlah,
        ]);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function hapus($id)
    {
        KeranjangItem::findOrFail($id)->delete();
        return back()->with('success', 'Item dihapus dari keranjang.');
    }
}