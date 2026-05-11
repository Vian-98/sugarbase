@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

<div style="display: flex; align-items: center; gap: 16px; margin-bottom: 28px;">
    <a href="/keranjang" style="color: #667eea; text-decoration: none; font-size: 0.9em;">← Kembali ke Keranjang</a>
    <h1 style="font-size: 1.8em; color: #1f2937; margin: 0; font-weight: 700;">Konfirmasi Pesanan</h1>
</div>

<!-- STEP INDICATOR -->
<div style="display: flex; align-items: center; margin-bottom: 32px; gap: 0;">
    <div style="display: flex; align-items: center; gap: 8px;">
        <div style="width: 32px; height: 32px; background: #22c55e; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.85em; font-weight: 700;">✓</div>
        <span style="font-size: 0.85em; font-weight: 600; color: #22c55e;">Keranjang</span>
    </div>
    <div style="flex: 1; height: 2px; background: #667eea; margin: 0 12px;"></div>
    <div style="display: flex; align-items: center; gap: 8px;">
        <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.85em; font-weight: 700;">2</div>
        <span style="font-size: 0.85em; font-weight: 600; color: #667eea;">Konfirmasi</span>
    </div>
    <div style="flex: 1; height: 2px; background: #e5e7eb; margin: 0 12px;"></div>
    <div style="display: flex; align-items: center; gap: 8px;">
        <div style="width: 32px; height: 32px; background: #e5e7eb; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 0.85em; font-weight: 700;">3</div>
        <span style="font-size: 0.85em; color: #9ca3af;">Pembayaran</span>
    </div>
</div>

<form action="/checkout" method="POST">
@csrf
<div style="display: grid; grid-template-columns: 1fr 360px; gap: 24px; align-items: start;">

    <!-- KIRI: Ringkasan Item + Metode -->
    <div style="display: flex; flex-direction: column; gap: 20px;">

        <!-- Ringkasan Item -->
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
            <div style="padding: 18px 24px; border-bottom: 1px solid #e5e7eb; background: #f9fafb;">
                <h2 style="margin: 0; font-size: 1em; font-weight: 700; color: #374151;">📋 Ringkasan Item</h2>
            </div>
            <div>
                @foreach($keranjang->items as $item)
                <div style="display: flex; align-items: center; gap: 16px; padding: 16px 24px; border-bottom: 1px solid #f3f4f6;">
                    <div style="width: 52px; height: 52px; background: #f3f4f6; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.8em; flex-shrink: 0; overflow: hidden;">
    @if($item->produk->foto && !str_starts_with($item->produk->foto, '�') && !str_starts_with($item->produk->foto, '/produk/'))
        <img src="{{ asset('storage/' . $item->produk->foto) }}" style="width:100%;height:100%;object-fit:cover;">
    @elseif($item->produk->foto && str_starts_with($item->produk->foto, '/'))
        <img src="{{ asset($item->produk->foto) }}" style="width:100%;height:100%;object-fit:cover;">
    @else
        🍰
    @endif
                    </div>
                    <div style="flex: 1;">
                        <p style="margin: 0; font-weight: 600; color: #111827; font-size: 0.9em;">{{ $item->produk->nama_produk }}</p>
                        <p style="margin: 3px 0 0; font-size: 0.8em; color: #9ca3af;">{{ $item->jumlah_keranjang }} × Rp {{ number_format($item->harga_satuan_keranjang, 0, ',', '.') }}</p>
                    </div>
                    <div style="font-weight: 700; color: #667eea; font-size: 0.9em; white-space: nowrap;">
                        Rp {{ number_format($item->subtotal_keranjang, 0, ',', '.') }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Metode Pembayaran -->
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
            <div style="padding: 18px 24px; border-bottom: 1px solid #e5e7eb; background: #f9fafb;">
                <h2 style="margin: 0; font-size: 1em; font-weight: 700; color: #374151;">💳 Pilih Metode Pembayaran</h2>
            </div>
            <div style="padding: 20px 24px; display: flex; flex-direction: column; gap: 12px;">

                <!-- Transfer Bank -->
                <label style="display: flex; align-items: center; gap: 14px; padding: 16px; border: 2px solid #e5e7eb; border-radius: 10px; cursor: pointer; transition: all 0.2s;" id="label-transfer">
                    <input type="radio" name="metode" value="transfer" required onchange="pilihMetode('transfer')"
                        style="width: 18px; height: 18px; accent-color: #667eea;">
                    <div style="width: 42px; height: 42px; background: #eff6ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.4em;">🏦</div>
                    <div>
                        <p style="margin: 0; font-weight: 600; color: #1f2937; font-size: 0.95em;">Transfer Bank</p>
                        <p style="margin: 2px 0 0; font-size: 0.8em; color: #9ca3af;">BCA, Mandiri, BRI, BNI</p>
                    </div>
                </label>

                <!-- COD -->
                <label style="display: flex; align-items: center; gap: 14px; padding: 16px; border: 2px solid #e5e7eb; border-radius: 10px; cursor: pointer; transition: all 0.2s;" id="label-cod">
                    <input type="radio" name="metode" value="cod" onchange="pilihMetode('cod')"
                        style="width: 18px; height: 18px; accent-color: #667eea;">
                    <div style="width: 42px; height: 42px; background: #f0fdf4; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.4em;">🚚</div>
                    <div>
                        <p style="margin: 0; font-weight: 600; color: #1f2937; font-size: 0.95em;">COD (Bayar di Tempat)</p>
                        <p style="margin: 2px 0 0; font-size: 0.8em; color: #9ca3af;">Bayar saat barang tiba</p>
                    </div>
                </label>

                <!-- E-Wallet / QRIS -->
                <label style="display: flex; align-items: center; gap: 14px; padding: 16px; border: 2px solid #e5e7eb; border-radius: 10px; cursor: pointer; transition: all 0.2s;" id="label-ewallet">
                    <input type="radio" name="metode" value="ewallet" onchange="pilihMetode('ewallet')"
                        style="width: 18px; height: 18px; accent-color: #667eea;">
                    <div style="width: 42px; height: 42px; background: #fdf4ff; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.4em;">📱</div>
                    <div>
                        <p style="margin: 0; font-weight: 600; color: #1f2937; font-size: 0.95em;">E-Wallet / QRIS</p>
                        <p style="margin: 2px 0 0; font-size: 0.8em; color: #9ca3af;">GoPay, OVO, Dana, QRIS</p>
                    </div>
                </label>

            </div>
        </div>

    </div>

    <!-- KANAN: Ringkasan Harga -->
    <div style="position: sticky; top: 20px;">
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 24px;">
            <h2 style="font-size: 1.1em; color: #1f2937; margin: 0 0 20px; font-weight: 700; border-bottom: 1px solid #e5e7eb; padding-bottom: 14px;">Total Pembayaran</h2>

            @php $total = $keranjang->items->sum('subtotal_keranjang'); @endphp

            <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.9em; color: #6b7280;">
                <span>Subtotal</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.9em; color: #6b7280;">
                <span>Ongkir</span>
                <span style="color: #22c55e; font-weight: 600;">Gratis</span>
            </div>

            <div style="border-top: 2px solid #e5e7eb; padding-top: 14px; margin-top: 4px; display: flex; justify-content: space-between; font-size: 1.15em; font-weight: 700; color: #1f2937;">
                <span>Total</span>
                <span style="color: #667eea;">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <!-- Info Metode Dipilih -->
            <div id="info-metode" style="margin-top: 16px; padding: 12px; background: #f0f4ff; border-radius: 8px; font-size: 0.85em; color: #4338ca; display: none;"></div>

            <button type="submit"
                style="width: 100%; margin-top: 20px; padding: 14px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px; font-size: 1em; font-weight: 600; cursor: pointer; transition: opacity 0.2s;">
                🛍 Buat Pesanan
            </button>
            <p style="font-size: 0.78em; color: #9ca3af; text-align: center; margin-top: 10px; margin-bottom: 0;">
                Dengan menekan tombol di atas, kamu menyetujui syarat & ketentuan SugarBase.
            </p>
        </div>
    </div>

</div>
</form>

<script>
const infoMetode = {
    transfer: '🏦 Kamu akan diarahkan ke halaman konfirmasi transfer bank setelah pesanan dibuat.',
    cod: '🚚 Siapkan uang tunai saat kurir tiba. Tidak perlu bayar sekarang!',
    ewallet: '📱 Scan QRIS atau bayar via e-wallet favoritmu setelah pesanan dibuat.'
};

function pilihMetode(metode) {
    ['transfer','cod','ewallet'].forEach(m => {
        const label = document.getElementById('label-' + m);
        label.style.borderColor = m === metode ? '#667eea' : '#e5e7eb';
        label.style.background = m === metode ? '#f0f4ff' : 'white';
    });
    const info = document.getElementById('info-metode');
    info.style.display = 'block';
    info.textContent = infoMetode[metode];
}
</script>

<style>
@media (max-width: 900px) {
    div[style*="grid-template-columns: 1fr 360px"] { grid-template-columns: 1fr !important; }
}
</style>

@endsection