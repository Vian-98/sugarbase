@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

<div style="margin-bottom: 32px;">
    <a href="/keranjang" style="display: inline-flex; align-items: center; gap: 6px; color: var(--text-secondary); text-decoration: none; font-size: 0.95em; font-weight: 500; margin-bottom: 16px; transition: color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-secondary)'">
        <span style="font-size: 1.2em; line-height: 1;">←</span> Kembali ke Keranjang
    </a>
    <h1 style="font-size: 2.2em; color: var(--dark); margin: 0; font-weight: 700; letter-spacing: -0.5px;">Konfirmasi Pesanan</h1>
</div>

<!-- STEP INDICATOR -->
<div style="display: flex; align-items: center; margin-bottom: 32px; gap: 0;">
    <div style="display: flex; align-items: center; gap: 8px;">
        <div style="width: 32px; height: 32px; background: #7EBB98; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.85em; font-weight: 700;">✓</div>
        <span style="font-size: 0.85em; font-weight: 600; color: #7EBB98;">Keranjang</span>
    </div>
    <div style="flex: 1; height: 2px; background: #789DBC; margin: 0 12px;"></div>
    <div style="display: flex; align-items: center; gap: 8px;">
        <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #789DBC, #9FBCCD); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.85em; font-weight: 700;">2</div>
        <span style="font-size: 0.85em; font-weight: 600; color: #789DBC;">Konfirmasi</span>
    </div>
    <div style="flex: 1; height: 2px; background: var(--border); margin: 0 12px;"></div>
    <div style="display: flex; align-items: center; gap: 8px;">
        <div style="width: 32px; height: 32px; background: #e5e7eb; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--text-secondary); font-size: 0.85em; font-weight: 700;">3</div>
        <span style="font-size: 0.85em; color: var(--text-secondary);">Pembayaran</span>
    </div>
</div>

<form action="/checkout" method="POST">
@csrf
<div style="display: grid; grid-template-columns: 1fr 360px; gap: 24px; align-items: start;">

    <!-- KIRI: Ringkasan Item + Metode -->
    <div style="display: flex; flex-direction: column; gap: 20px;">

        <!-- Ringkasan Item -->
        <div style="background: var(--surface-strong); border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
            <div style="padding: 18px 24px; border-bottom: 1px solid var(--border); background: var(--surface-muted);">
                <h2 style="margin: 0; font-size: 1em; font-weight: 700; color: var(--dark);">📋 Ringkasan Item</h2>
            </div>
            <div>
                @foreach($keranjang->items as $item)
                <div style="display: flex; align-items: center; gap: 16px; padding: 16px 24px; border-bottom: 1px solid var(--border);">
                    <div style="width: 52px; height: 52px; background: var(--surface-muted); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.8em; flex-shrink: 0; overflow: hidden;">
    @if($item->produk->foto && !str_starts_with($item->produk->foto, '�') && !str_starts_with($item->produk->foto, '/produk/'))
        <img src="{{ asset('storage/' . $item->produk->foto) }}" style="width:100%;height:100%;object-fit:cover;">
    @elseif($item->produk->foto && str_starts_with($item->produk->foto, '/'))
        <img src="{{ asset($item->produk->foto) }}" style="width:100%;height:100%;object-fit:cover;">
    @else
        🍰
    @endif
                    </div>
                    <div style="flex: 1;">
                        <p style="margin: 0; font-weight: 600; color: var(--dark); font-size: 0.9em;">{{ $item->produk->nama_produk }}</p>
                        <p style="margin: 3px 0 0; font-size: 0.8em; color: var(--text-secondary);">{{ $item->jumlah_keranjang }} × Rp {{ number_format($item->harga_satuan_keranjang, 0, ',', '.') }}</p>
                    </div>
                    <div style="font-weight: 700; color: var(--dark); font-size: 0.9em; white-space: nowrap;">
                        Rp {{ number_format($item->subtotal_keranjang, 0, ',', '.') }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Metode Pembayaran -->
        <div style="background: var(--surface-strong); border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
            <div style="padding: 18px 24px; border-bottom: 1px solid var(--border); background: var(--surface-muted);">
                <h2 style="margin: 0; font-size: 1em; font-weight: 700; color: var(--dark);">💳 Pilih Metode Pembayaran</h2>
            </div>
            <div style="padding: 20px 24px; display: flex; flex-direction: column; gap: 12px;">

                <!-- Transfer Bank -->
                <label style="display: flex; align-items: center; gap: 14px; padding: 16px; border: 1px solid var(--border); border-radius: 10px; cursor: pointer; transition: all 0.2s;" id="label-transfer">
                    <input type="radio" name="metode" value="transfer" required checked onchange="pilihMetode('transfer')"
                        style="width: 18px; height: 18px; accent-color: #789DBC;">
                    <div style="width: 42px; height: 42px; background: rgba(120,157,188,0.15); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.4em;">🏦</div>
                    <div>
                        <p style="margin: 0; font-weight: 600; color: var(--dark); font-size: 0.95em;">Transfer Bank</p>
                        <p style="margin: 2px 0 0; font-size: 0.8em; color: var(--text-secondary);">BCA, Mandiri, BRI, BNI</p>
                    </div>
                </label>

                <!-- COD -->
                <label style="display: flex; align-items: center; gap: 14px; padding: 16px; border: 1px solid var(--border); border-radius: 10px; cursor: pointer; transition: all 0.2s;" id="label-cod">
                    <input type="radio" name="metode" value="cod" onchange="pilihMetode('cod')"
                        style="width: 18px; height: 18px; accent-color: #789DBC;">
                    <div style="width: 42px; height: 42px; background: rgba(126,187,152,0.15); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.4em;">🚚</div>
                    <div>
                        <p style="margin: 0; font-weight: 600; color: var(--dark); font-size: 0.95em;">COD (Bayar di Tempat)</p>
                        <p style="margin: 2px 0 0; font-size: 0.8em; color: var(--text-secondary);">Bayar saat barang tiba</p>
                    </div>
                </label>

                <!-- E-Wallet / QRIS -->
                <label style="display: flex; align-items: center; gap: 14px; padding: 16px; border: 1px solid var(--border); border-radius: 10px; cursor: pointer; transition: all 0.2s;" id="label-ewallet">
                    <input type="radio" name="metode" value="ewallet" onchange="pilihMetode('ewallet')"
                        style="width: 18px; height: 18px; accent-color: #789DBC;">
                    <div style="width: 42px; height: 42px; background: rgba(217,137,153,0.15); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.4em;">📱</div>
                    <div>
                        <p style="margin: 0; font-weight: 600; color: var(--dark); font-size: 0.95em;">E-Wallet / QRIS</p>
                        <p style="margin: 2px 0 0; font-size: 0.8em; color: var(--text-secondary);">GoPay, OVO, Dana, QRIS</p>
                    </div>
                </label>

            </div>
        </div>

    </div>

    <!-- KANAN: Ringkasan Harga -->
    <div style="position: sticky; top: 20px;">
        <div style="background: var(--surface-strong); border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 24px;">
            <h2 style="font-size: 1.1em; color: var(--dark); margin: 0 0 20px; font-weight: 700; border-bottom: 1px solid var(--border); padding-bottom: 14px;">Total Pembayaran</h2>

            @php $total = $keranjang->items->sum('subtotal_keranjang'); @endphp

            <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.9em; color: var(--text-secondary);">
                <span>Subtotal</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 0.9em; color: var(--text-secondary);">
                <span>Ongkir</span>
                <span style="color: var(--dark); font-weight: 600;">Gratis</span>
            </div>

            <div style="border-top: 2px solid var(--border); padding-top: 14px; margin-top: 4px; display: flex; justify-content: space-between; font-size: 1.15em; font-weight: 700; color: var(--dark);">
                <span>Total</span>
                <span style="color: var(--dark);">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <!-- Info Metode Dipilih -->
            <div id="info-metode" style="margin-top: 16px; padding: 12px; background: rgba(120,157,188,0.15); border-radius: 8px; font-size: 0.85em; color: var(--dark); display: none;"></div>

            <button type="submit"
                style="width: 100%; margin-top: 20px; padding: 14px; background: linear-gradient(135deg, #789DBC 0%, #688CAD 100%); color: white; border: none; border-radius: 8px; font-size: 1.05em; font-weight: 700; cursor: pointer; transition: opacity 0.2s; box-shadow: 0 4px 12px rgba(120, 157, 188, 0.4);">
                🛍 Buat Pesanan
            </button>
            <p style="font-size: 0.78em; color: var(--text-secondary); text-align: center; margin-top: 10px; margin-bottom: 0;">
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
        label.style.borderColor = m === metode ? 'var(--primary)' : 'var(--border)';
        label.style.background = m === metode ? 'var(--surface-muted)' : 'transparent';
    });
    const info = document.getElementById('info-metode');
    info.style.display = 'block';
    info.textContent = infoMetode[metode];
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    // Check which radio is selected and apply styling
    const selectedRadio = document.querySelector('input[name="metode"]:checked');
    if (selectedRadio) {
        pilihMetode(selectedRadio.value);
    }
});
</script>

<style>
@media (max-width: 900px) {
    div[style*="grid-template-columns: 1fr 360px"] { grid-template-columns: 1fr !important; }
}
</style>

@endsection