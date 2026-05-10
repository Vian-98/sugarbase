<?php
namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Notifikasi;
use App\Models\Pembayaran;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $keranjang = Keranjang::with('items.produk')
            ->where('user_id', Auth::id())
            ->where('status_keranjang', 'aktif')
            ->first();

        if (!$keranjang || $keranjang->items->isEmpty()) {
            return redirect('/keranjang')->with('error', 'Keranjang kamu kosong!');
        }

        return view('checkout.index', compact('keranjang'));
    }

    public function proses(Request $request)
    {
        $request->validate(['metode' => 'required|in:transfer,cod,ewallet']);

        $keranjang = Keranjang::with('items.produk')
            ->where('user_id', Auth::id())
            ->where('status_keranjang', 'aktif')
            ->firstOrFail();

        $total = $keranjang->items->sum('subtotal_keranjang');

        $pesanan = Pesanan::create([
            'user_id'        => Auth::id(),
            'tanggal_pesan'  => today(),
            'total_harga'    => $total,
            'status_pesanan' => 'pending',
        ]);

        foreach ($keranjang->items as $item) {
            $pesanan->items()->create([
                'id_produk'            => $item->id_produk,
                'jumlah_pesanan'       => $item->jumlah_keranjang,
                'harga_satuan_pesanan' => $item->harga_satuan_keranjang,
                'subtotal_pesanan'     => $item->subtotal_keranjang,
            ]);
            $item->produk->decrement('stok', $item->jumlah_keranjang);
        }

        Pembayaran::create([
            'id_pesanan'        => $pesanan->id_pesanan,
            'metode_pembayaran' => $request->metode,
            'status_pembayaran' => 'menunggu',
            'tanggal_bayar'     => today(),
            'jumlah_bayar'      => $total,
        ]);

        $keranjang->update(['status_keranjang' => 'checkout']);

        Notifikasi::create([
            'user_id'     => Auth::id(),
            'judul'       => 'Pesanan Berhasil Dibuat',
            'pesan'       => "Pesanan #{$pesanan->id_pesanan} berhasil dibuat. Segera lakukan pembayaran.",
            'waktu_kirim' => now(),
            'status_baca' => 'belum',
        ]);

        return redirect("/pembayaran/{$pesanan->id_pesanan}");
    }
}