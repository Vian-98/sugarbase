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
                        <th style="padding: 14px 24px; text-align: left; min-width: 250px;">Produk</th>
                        <th style="padding: 14px 12px; text-align: center; min-width: 110px;">Harga</th>
                        <th style="padding: 14px 12px; text-align: center; min-width: 120px;">Jumlah</th>
                        <th style="padding: 14px 12px; text-align: center; min-width: 130px;">Subtotal</th>
                        <th style="padding: 14px 24px; text-align: center; min-width: 60px;">Hapus</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($keranjang->items as $item)
                    <tr style="border-top: 1px solid var(--border); transition: background 0.2s;" onmouseover="this.style.background='var(--border)'" onmouseout="this.style.background='transparent'">
                        <!-- Foto + Nama -->
                        <td style="padding: 16px 24px; vertical-align: middle;">
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
                        <td style="padding: 16px 12px; text-align: center; color: #789DBC; font-weight: 600; font-size: 0.95em; white-space: nowrap; vertical-align: middle;">
                            Rp {{ number_format($item->harga_satuan_keranjang, 0, ',', '.') }}
                        </td>

                        <!-- Update Qty -->
                        <td style="padding: 16px 12px; text-align: center; vertical-align: middle;">
                            <div class="qty-group" data-item-id="{{ $item->id_item }}" data-max-stock="{{ $item->produk->stok }}" style="display: flex; align-items: center; justify-content: center; gap: 0;">
                                <button type="button" class="qty-btn qty-minus"
                                    style="width: 28px; height: 28px; border: 1px solid var(--border); background: rgba(255, 227, 227, 0.3); color: #789DBC; cursor: pointer; border-radius: 4px 0 0 4px; font-size: 0.9em; font-weight: bold; transition: all 0.2s ease; display: flex; align-items: center; justify-content: center;">−</button>
                                <input type="number" class="qty-input" value="{{ $item->jumlah_keranjang }}" min="1" max="{{ $item->produk->stok }}"
                                    style="width: 45px; height: 28px; border: 1px solid var(--border); border-left: none; border-right: none; text-align: center; font-size: 0.9em; font-weight: 600; -moz-appearance: textfield; outline: none; background: var(--surface-strong); color: var(--dark);">
                                <button type="button" class="qty-btn qty-plus"
                                    style="width: 28px; height: 28px; border: 1px solid var(--border); background: rgba(201, 233, 210, 0.3); color: #789DBC; cursor: pointer; border-radius: 0 4px 4px 0; font-size: 0.9em; font-weight: bold; transition: all 0.2s ease; display: flex; align-items: center; justify-content: center;">+</button>
                            </div>
                            <span class="qty-status" style="display: block; font-size: 0.7em; color: #789DBC; font-weight: 600; margin-top: 4px; min-height: 12px; text-align: center;"></span>
                        </td>

                        <!-- Subtotal -->
                        <td style="padding: 16px 12px; text-align: center; font-weight: 700; color: var(--dark); white-space: nowrap; font-size: 0.95em; vertical-align: middle;">
                            Rp {{ number_format($item->subtotal_keranjang, 0, ',', '.') }}
                        </td>

                        <!-- Hapus -->
                        <td style="padding: 16px 24px; text-align: center; vertical-align: middle;">
                            <form action="/keranjang/hapus/{{ $item->id_item }}" method="POST" style="margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus item ini?')"
                                    style="background: rgba(217,137,153,0.15); color: var(--danger); border: 1px solid #fca5a5; width: 36px; height: 36px; border-radius: 8px; cursor: pointer; font-size: 1em; transition: all 0.2s ease; display: inline-flex; align-items: center; justify-content: center; padding: 0;">🗑</button>
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
document.addEventListener('DOMContentLoaded', function() {
    // Event delegation untuk tombol qty
    document.querySelectorAll('.qty-group').forEach(group => {
        const minusBtn = group.querySelector('.qty-minus');
        const plusBtn = group.querySelector('.qty-plus');
        const input = group.querySelector('.qty-input');
        const status = group.parentElement.querySelector('.qty-status');
        const itemId = group.dataset.itemId;
        const maxStock = parseInt(group.dataset.maxStock);

        if (!minusBtn || !plusBtn || !input || !status) {
            console.error('Element tidak ditemukan', { minusBtn, plusBtn, input, status });
            return;
        }

        // Get CSRF token
        const getCsrfToken = () => {
            return document.querySelector('meta[name="csrf-token"]')?.content || '';
        };

        // Function untuk update quantity
        async function updateQty(newQty) {
            const minQty = 1;
            const maxQty = maxStock;

            // Validate
            if (newQty < minQty) newQty = minQty;
            if (newQty > maxQty) newQty = maxQty;

            input.value = newQty;
            status.textContent = '⏳ Updating...';
            status.style.color = '#789DBC';

            try {
                const response = await fetch(`/keranjang/update/${itemId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ jumlah: newQty })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    // Update subtotal di tabel
                    const row = group.closest('tr');
                    const subtotalCell = row.querySelector('td:nth-child(4)');
                    if (subtotalCell && data.subtotal) {
                        const formatter = new Intl.NumberFormat('id-ID');
                        subtotalCell.textContent = 'Rp ' + formatter.format(data.subtotal);
                    }

                    // Update ringkasan total dengan delay untuk DOM update
                    setTimeout(updateRingkasanPesanan, 100);
                    
                    status.textContent = '✓ Tersimpan';
                    status.style.color = '#7EBB98';
                    setTimeout(() => {
                        status.textContent = '';
                    }, 2000);
                } else {
                    status.textContent = '✗ Gagal: ' + (data.error || 'Unknown error');
                    status.style.color = '#FF6B6B';
                    setTimeout(() => {
                        status.textContent = '';
                    }, 3000);
                }
            } catch (error) {
                console.error('Error:', error);
                status.textContent = '✗ Error Network';
                status.style.color = '#FF6B6B';
                setTimeout(() => {
                    status.textContent = '';
                }, 2000);
            }
        }

        // Tombol minus
        minusBtn.addEventListener('click', (e) => {
            e.preventDefault();
            let newQty = parseInt(input.value) - 1;
            updateQty(newQty);
        });

        // Tombol plus
        plusBtn.addEventListener('click', (e) => {
            e.preventDefault();
            let newQty = parseInt(input.value) + 1;
            updateQty(newQty);
        });

        // Direct input change
        input.addEventListener('change', () => {
            let newQty = parseInt(input.value) || 1;
            updateQty(newQty);
        });
    });

    // Function untuk update ringkasan pesanan
    function updateRingkasanPesanan() {
        let totalSubtotal = 0;

        document.querySelectorAll('tbody tr').forEach(row => {
            const subtotalText = row.querySelector('td:nth-child(4)').textContent;
            const subtotal = parseInt(subtotalText.replace(/[^0-9]/g, '')) || 0;
            totalSubtotal += subtotal;
        });

        const formatter = new Intl.NumberFormat('id-ID');
        const formattedSubtotal = 'Rp ' + formatter.format(totalSubtotal);
        
        // Find ringkasan container (h2 with "Ringkasan Pesanan")
        const ringkasanHeading = document.querySelector('h2');
        if (!ringkasanHeading || !ringkasanHeading.textContent.includes('Ringkasan')) {
            console.warn('Ringkasan heading not found');
            return;
        }
        
        const ringkasanContainer = ringkasanHeading.parentElement;
        if (!ringkasanContainer) return;
        
        // Find all flex divs in ringkasan
        const flexDivs = ringkasanContainer.querySelectorAll('div[style*="display: flex"][style*="justify-content: space-between"]');
        
        // Update subtotal (first flex div) dan total (second flex div)
        if (flexDivs.length >= 3) {
            // flexDivs[0] = Subtotal
            const subtotalSpans = flexDivs[0].querySelectorAll('span');
            if (subtotalSpans.length >= 2) {
                subtotalSpans[1].textContent = formattedSubtotal;
            }
            
            // flexDivs[2] = Total (yang punya border-top)
            const totalSpans = flexDivs[2].querySelectorAll('span');
            if (totalSpans.length >= 2) {
                totalSpans[1].textContent = formattedSubtotal;
            }
        }
    }
});
</script>

<style>
input[type=number]::-webkit-outer-spin-button,
input[type=number]::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
@media (max-width: 900px) {
    div[style*="grid-template-columns: 1fr 340px"] { grid-template-columns: 1fr !important; }
}
</style>

@endsection