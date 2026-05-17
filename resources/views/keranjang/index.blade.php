@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')

<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px;">
    <h1 style="font-size: 1.8em; color: var(--dark); margin: 0; font-weight: 700;">🛒 Keranjang Belanja</h1>
    <a href="/katalog" style="color: #789DBC; text-decoration: none; font-size: 0.9em;">← Lanjut Belanja</a>
</div>

<!-- FLASH MESSAGES -->
@if(session('success'))
<div style="background: rgba(126,187,152,0.15); border: 1px solid #86efac; color: var(--dark); font-weight: 600; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">
    ✅ {{ session('success') }}
</div>
@endif
@if(session('error'))
<div style="background: rgba(217,137,153,0.15); border: 1px solid #fca5a5; color: var(--dark); font-weight: 600; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">
    ⚠️ {{ session('error') }}
</div>
@endif

@if(!$keranjang || $keranjang->items->count() === 0)

<!-- KERANJANG KOSONG -->
<div style="background: var(--surface-strong); border-radius: 12px; padding: 80px 40px; text-align: center; border: 1px solid var(--border); box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
    <div style="font-size: 5em; margin-bottom: 20px;">🛒</div>
    <h2 style="color: var(--text-secondary); font-size: 1.4em; margin-bottom: 10px;">Keranjang Kamu Kosong</h2>
    <p style="color: var(--text-secondary); margin-bottom: 28px;">Yuk, tambahkan produk favoritmu ke keranjang!</p>
    <a href="/katalog" style="display: inline-block; background: linear-gradient(135deg, #789DBC 0%, #9FBCCD 100%); color: white; padding: 12px 32px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: opacity 0.2s;">
        Mulai Belanja →
    </a>
</div>

@else

<div style="display: grid; grid-template-columns: 1fr 340px; gap: 24px; align-items: start;">

    <!-- TABEL ITEM -->
    <div style="background: var(--surface-strong); border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
        <div style="padding: 20px 24px; border-bottom: 1px solid var(--border);">
            <span style="font-weight: 600; color: var(--text-secondary);">{{ $keranjang->items->count() }} item dalam keranjang</span>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: var(--surface-muted); font-size: 0.9em; color: var(--dark); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                        <th style="padding: 14px 24px; text-align: left;">Produk</th>
                        <th style="padding: 14px 12px; text-align: center;">Harga</th>
                        <th style="padding: 14px 12px; text-align: center;">Jumlah</th>
                        <th style="padding: 14px 12px; text-align: center;">Subtotal</th>
                        <th style="padding: 14px 24px; text-align: center;">Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($keranjang->items as $item)
                    <tr style="border-top: 1px solid var(--border); transition: background 0.2s;" onmouseover="this.style.background='var(--border)'" onmouseout="this.style.background='transparent'">
                        <!-- Foto + Nama -->
                        <td style="padding: 18px 24px;">
                            <div style="display: flex; align-items: center; gap: 14px;">
                                @if($item->produk->foto)
                                <img src="{{ asset('storage/' . $item->produk->foto) }}" alt="{{ $item->produk->nama_produk }}" 
                                    style="width: 64px; height: 64px; object-fit: cover; border-radius: 8px; flex-shrink: 0;">
                                @else
                                <div style="width: 64px; height: 64px; background: var(--surface-muted); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 2em; flex-shrink: 0;">
                                    🍰
                                </div>
                                @endif
                                <div>
                                    <p style="margin: 0; font-weight: 600; color: var(--dark); font-size: 0.95em;">{{ $item->produk->nama_produk }}</p>
                                    <p style="margin: 4px 0 0; font-size: 0.8em; color: var(--text-secondary);">{{ $item->produk->kategori->nama_kategori ?? '' }}</p>
                                </div>
                            </div>
                        </td>

                        <!-- Harga Satuan -->
                        <td style="padding: 18px 12px; text-align: center; color: #789DBC; font-weight: 600; font-size: 0.9em; white-space: nowrap;">
                            Rp {{ number_format($item->harga_satuan_keranjang, 0, ',', '.') }}
                        </td>

                        <!-- Update Qty -->
                        <td style="padding: 18px 12px; text-align: center;">
                            <form action="/keranjang/update/{{ $item->id_item }}" method="POST" style="display: flex; align-items: center; justify-content: center; gap: 0;">
                                @csrf
                                <button type="button" onclick="ubahQtyItem(this, -1)"
                                    style="width: 32px; height: 32px; border: 1px solid var(--border); background: var(--gradient-soft); color: var(--text-secondary); cursor: pointer; border-radius: 6px 0 0 6px; font-size: 1em;">−</button>
                                <input type="number" name="jumlah" value="{{ $item->jumlah_keranjang }}" min="1" max="{{ $item->produk->stok }}"
                                    style="width: 48px; height: 32px; border: 1px solid var(--border); border-left: none; border-right: none; text-align: center; font-size: 0.9em; -moz-appearance: textfield; outline: none; background: transparent; color: var(--dark);">
                                <button type="button" onclick="ubahQtyItem(this, 1)"
                                    style="width: 32px; height: 32px; border: 1px solid var(--border); background: var(--gradient-soft); color: var(--text-secondary); cursor: pointer; border-radius: 0 6px 6px 0; font-size: 1em;">+</button>
                                <button type="submit"
                                    style="margin-left: 8px; padding: 0 10px; height: 32px; background: #789DBC; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 0.78em; font-weight: 600; white-space: nowrap;">Update</button>
                            </form>
                        </td>

                        <!-- Subtotal -->
                        <td style="padding: 18px 12px; text-align: center; font-weight: 700; color: var(--dark); white-space: nowrap;">
                            Rp {{ number_format($item->subtotal_keranjang, 0, ',', '.') }}
                        </td>

                        <!-- Hapus -->
                        <td style="padding: 18px 24px; text-align: center;">
                            <form action="/keranjang/hapus/{{ $item->id_item }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus item ini?')"
                                    style="background: rgba(217,137,153,0.15); color: var(--danger); border: 1px solid #fca5a5; width: 36px; height: 36px; border-radius: 8px; cursor: pointer; font-size: 1em; transition: all 0.2s;">🗑</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- RINGKASAN -->
    <div style="position: sticky; top: 20px;">
        <div style="background: var(--surface-strong); border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 24px;">
            <h2 style="font-size: 1.1em; color: var(--dark); margin: 0 0 20px; font-weight: 700; border-bottom: 1px solid var(--border); padding-bottom: 14px;">Ringkasan Pesanan</h2>

            @php $total = $keranjang->items->sum('subtotal_keranjang'); @endphp

            <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.9em; color: var(--text-secondary);">
                <span>Subtotal ({{ $keranjang->items->count() }} item)</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.9em; color: var(--text-secondary);">
                <span>Ongkir</span>
                <span style="color: #7EBB98;">Gratis</span>
            </div>

            <div style="border-top: 2px solid #e5e7eb; padding-top: 14px; margin-top: 14px; display: flex; justify-content: space-between; font-size: 1.1em; font-weight: 700; color: var(--dark);">
                <span>Total</span>
                <span style="color: #789DBC;">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <a href="/checkout"
                style="display: block; margin-top: 20px; padding: 14px; background: linear-gradient(135deg, #789DBC 0%, #688CAD 100%); color: white; text-align: center; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 1.05em; transition: opacity 0.2s; box-shadow: 0 4px 12px rgba(120, 157, 188, 0.4);">
                Lanjut ke Pembayaran →
            </a>
            <a href="/katalog" style="display: block; margin-top: 12px; padding: 12px; background: var(--surface-muted); color: var(--dark); text-align: center; border-radius: 8px; text-decoration: none; font-size: 0.95em; font-weight: 600; border: 1px solid var(--border);">
                ← Tambah Produk Lain
            </a>
        </div>
    </div>

</div>
@endif

<script>
function ubahQtyItem(btn, delta) {
    const form = btn.closest('form');
    const input = form.querySelector('input[type=number]');
    const max = parseInt(input.max);
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    if (val > max) val = max;
    input.value = val;
}
</script>

<style>
input[type=number]::-webkit-outer-spin-button,
input[type=number]::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
@media (max-width: 900px) {
    div[style*="grid-template-columns: 1fr 340px"] { grid-template-columns: 1fr !important; }
}
</style>

@endsection