@extends('layouts.admin')

@section('breadcrumb', 'Admin › Pesanan › Detail')

@section('content')

<!-- HEADER -->
<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
    <div>
        <h1 style="font-size: 1.6em; color: #1f2937; margin: 0; font-weight: 700;">📋 Detail Pesanan #{{ str_pad($pesanan->id_pesanan, 6, '0', STR_PAD_LEFT) }}</h1>
    </div>
    <a href="/admin/pesanan" style="padding: 10px 18px; background: #f3f4f6; color: #374151; border-radius: 8px; text-decoration: none; font-size: 0.85em; font-weight: 600; border: 1px solid #e5e7eb; transition: all 0.2s;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">← Kembali</a>
</div>

<div style="display: grid; grid-template-columns: 1fr 380px; gap: 24px; align-items: start;">

    <!-- MAIN CONTENT -->
    <div>
        <!-- ORDER INFO CARD -->
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 20px;">
            <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb; background: #f9fafb;">
                <h3 style="margin: 0; font-size: 0.95em; font-weight: 700; color: #1f2937;">ℹ️ Informasi Pesanan</h3>
            </div>
            <div style="padding: 24px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 20px;">
                    <div>
                        <small style="display: block; font-size: 0.75em; color: #9ca3af; font-weight: 600; margin-bottom: 6px;">ID Pesanan</small>
                        <p style="margin: 0; font-size: 1.1em; font-weight: 700; color: #667eea;">#{{ str_pad($pesanan->id_pesanan, 6, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div>
                        <small style="display: block; font-size: 0.75em; color: #9ca3af; font-weight: 600; margin-bottom: 6px;">Tanggal Pesanan</small>
                        <p style="margin: 0; font-size: 0.95em; color: #374151; font-weight: 600;">{{ $pesanan->tanggal_pesan->format('d M Y · H:i') }}</p>
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                    <div>
                        <small style="display: block; font-size: 0.75em; color: #9ca3af; font-weight: 600; margin-bottom: 6px;">Nama Pelanggan</small>
                        <p style="margin: 0; font-size: 0.95em; color: #374151; font-weight: 600;">{{ $pesanan->user->name }}</p>
                        <small style="color: #9ca3af; font-size: 0.8em;">{{ $pesanan->user->email }}</small>
                    </div>
                    <div>
                        <small style="display: block; font-size: 0.75em; color: #9ca3af; font-weight: 600; margin-bottom: 6px;">Status Pesanan</small>
                        @php
                            $statusColors = [
                                'pending'    => ['bg' => '#fffbeb', 'text' => '#d97706', 'emoji' => '⏳'],
                                'diproses'   => ['bg' => '#eff6ff', 'text' => '#2563eb', 'emoji' => '🔄'],
                                'dikirim'    => ['bg' => '#f0fdf4', 'text' => '#16a34a', 'emoji' => '🚚'],
                                'selesai'    => ['bg' => '#f0fdf4', 'text' => '#15803d', 'emoji' => '✅'],
                                'dibatalkan' => ['bg' => '#fef2f2', 'text' => '#dc2626', 'emoji' => '❌'],
                            ];
                            $sc = $statusColors[$pesanan->status_pesanan] ?? ['bg' => '#f3f4f6', 'text' => '#6b7280', 'emoji' => '❓'];
                        @endphp
                        <span style="padding: 6px 12px; border-radius: 20px; font-size: 0.85em; font-weight: 600;
                                     background: {{ $sc['bg'] }}; color: {{ $sc['text'] }};">
                            {{ $sc['emoji'] }} {{ ucfirst($pesanan->status_pesanan) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ITEMS TABLE -->
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden; margin-bottom: 20px;">
            <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb; background: #f9fafb;">
                <h3 style="margin: 0; font-size: 0.95em; font-weight: 700; color: #1f2937;">📦 Item Pesanan</h3>
            </div>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.9em;">
                    <thead>
                        <tr style="background: #f9fafb; color: #6b7280; text-transform: uppercase; font-size: 0.8em; letter-spacing: 0.4px;">
                            <th style="padding: 13px 20px; text-align: left; font-weight: 600;">Produk</th>
                            <th style="padding: 13px 12px; text-align: center; font-weight: 600;">Qty</th>
                            <th style="padding: 13px 12px; text-align: right; font-weight: 600;">Harga</th>
                            <th style="padding: 13px 20px; text-align: right; font-weight: 600;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesanan->items as $item)
                        <tr style="border-top: 1px solid #e5e7eb; transition: background 0.15s;"
                            onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='white'">
                            <td style="padding: 14px 20px;">
                                <p style="margin: 0; font-weight: 600; color: #374151;">{{ $item->produk->nama_produk }}</p>
                                <small style="color: #9ca3af;">ID: {{ $item->produk->id_produk }}</small>
                            </td>
                            <td style="padding: 14px 12px; text-align: center; color: #374151; font-weight: 600;">
                                {{ $item->jumlah_pesanan }}x
                            </td>
                            <td style="padding: 14px 12px; text-align: right; color: #374151;">
                                Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                            </td>
                            <td style="padding: 14px 20px; text-align: right; font-weight: 700; color: #667eea;">
                                Rp {{ number_format($item->subtotal_pesanan, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TRACKING HISTORY -->
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
            <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb; background: #f9fafb;">
                <h3 style="margin: 0; font-size: 0.95em; font-weight: 700; color: #1f2937;">📜 Riwayat Tracking</h3>
            </div>
            <div style="padding: 20px 24px;">
                @forelse($pesanan->tracking as $track)
                <div style="margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid #f3f4f6;">
                    <div style="display: flex; align-items: flex-start; gap: 12px;">
                        <div style="width: 10px; height: 10px; border-radius: 50%; background: #667eea; margin-top: 4px; flex-shrink: 0;"></div>
                        <div style="flex: 1;">
                            <p style="margin: 0 0 4px; font-weight: 600; color: #1f2937; font-size: 0.95em;">{{ $track->status }}</p>
                            <small style="display: block; color: #9ca3af; margin-bottom: 4px;">📅 {{ $track->waktu_update->format('d M Y') }} · ⏰ {{ $track->waktu_update->format('H:i') }}</small>
                            <p style="margin: 0; color: #555; font-size: 0.9em; line-height: 1.5;">{{ $track->keterangan ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <p style="margin: 0; text-align: center; color: #9ca3af; padding: 20px 0;">Belum ada tracking</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- SIDEBAR -->
    <div style="display: flex; flex-direction: column; gap: 20px;">

        <!-- SUMMARY CARD -->
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
            <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb; background: linear-gradient(135deg, #f8f6ff, #ede9fe);">
                <h3 style="margin: 0; font-size: 0.95em; font-weight: 700; color: #667eea;">💰 Ringkasan</h3>
            </div>
            <div style="padding: 20px 24px;">
                <div style="margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid #f3f4f6;">
                    <small style="display: block; font-size: 0.75em; color: #9ca3af; font-weight: 600; margin-bottom: 6px;">Total Harga</small>
                    <h4 style="margin: 0; font-size: 1.5em; font-weight: 700; color: #667eea;">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</h4>
                </div>
                <div>
                    <small style="display: block; font-size: 0.75em; color: #9ca3af; font-weight: 600; margin-bottom: 6px;">Status Pembayaran</small>
                    @php
                        $bayarColor = [
                            'lunas'    => ['bg' => '#f0fdf4', 'text' => '#16a34a'],
                            'gagal'    => ['bg' => '#fef2f2', 'text' => '#dc2626'],
                            'menunggu' => ['bg' => '#fffbeb', 'text' => '#d97706'],
                        ];
                        $bp = $pesanan->pembayaran->status_pembayaran ?? 'menunggu';
                        $bc = $bayarColor[$bp] ?? ['bg' => '#f3f4f6', 'text' => '#6b7280'];
                    @endphp
                    <span style="padding: 6px 12px; border-radius: 20px; font-size: 0.85em; font-weight: 600;
                                 background: {{ $bc['bg'] }}; color: {{ $bc['text'] }};">
                        {{ ucfirst($bp) }}
                    </span>
                    @if($bp !== 'lunas' && $pesanan->pembayaran)
                    <form action="/admin/pembayaran/{{ $pesanan->pembayaran->id_pembayaran }}/konfirmasi" method="POST" style="margin-top: 10px;">
                        @csrf
                        <button type="submit" onclick="return confirm('Konfirmasi pembayaran ini?')"
                            style="width: 100%; padding: 8px 12px; background: #667eea; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 0.85em; font-weight: 600; transition: all 0.2s;"
                            onmouseover="this.style.background='#764ba2'" onmouseout="this.style.background='#667eea'">
                            ✔ Konfirmasi Pembayaran
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- PAYMENT METHOD CARD -->
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
            <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb; background: #f9fafb;">
                <h3 style="margin: 0; font-size: 0.95em; font-weight: 700; color: #1f2937;">💳 Metode Pembayaran</h3>
            </div>
            <div style="padding: 20px 24px;">
                <p style="margin: 0 0 12px; color: #374151; font-weight: 600; font-size: 0.95em;">{{ ucfirst($pesanan->pembayaran->metode_pembayaran ?? '-') }}</p>
                <small style="color: #9ca3af;">Nomor Referensi: {{ $pesanan->pembayaran->no_referensi ?? 'N/A' }}</small>
            </div>
        </div>

        <!-- UPDATE STATUS CARD -->
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
            <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb; background: #f9fafb;">
                <h3 style="margin: 0; font-size: 0.95em; font-weight: 700; color: #1f2937;">🔄 Update Status</h3>
            </div>
            <div style="padding: 20px 24px;">
                <form method="POST" action="/admin/pesanan/{{ $pesanan->id_pesanan }}/status">
                    @csrf
                    <div style="margin-bottom: 12px;">
                        <label style="display: block; font-size: 0.85em; color: #374151; font-weight: 600; margin-bottom: 6px;">Status Pesanan</label>
                        <select name="status" style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; background: white; color: #374151; font-size: 0.9em; cursor: pointer;">
                            @foreach(['pending','diproses','dikirim','selesai','dibatalkan'] as $s)
                            <option value="{{ $s }}" {{ $pesanan->status_pesanan === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" style="width: 100%; padding: 8px 12px; background: #667eea; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 0.85em; font-weight: 600; transition: all 0.2s;"
                        onmouseover="this.style.background='#764ba2'" onmouseout="this.style.background='#667eea'">
                        ✔ Update Status
                    </button>
                </form>
            </div>
        </div>

        <!-- ADD TRACKING CARD -->
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
            <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb; background: #f9fafb;">
                <h3 style="margin: 0; font-size: 0.95em; font-weight: 700; color: #1f2937;">➕ Tambah Tracking</h3>
            </div>
            <div style="padding: 20px 24px;">
                <form method="POST" action="/admin/pesanan/{{ $pesanan->id_pesanan }}/tracking">
                    @csrf
                    <div style="margin-bottom: 12px;">
                        <label style="display: block; font-size: 0.85em; color: #374151; font-weight: 600; margin-bottom: 6px;">Status</label>
                        <select name="status" style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; background: white; color: #374151; font-size: 0.9em; cursor: pointer;" required>
                            <option value="">Pilih Status</option>
                            <option value="Pesanan Diterima">Pesanan Diterima</option>
                            <option value="Pembayaran Dikonfirmasi">Pembayaran Dikonfirmasi</option>
                            <option value="Sedang Diproses">Sedang Diproses</option>
                            <option value="Dalam Pengiriman">Dalam Pengiriman</option>
                            <option value="Pesanan Selesai">Pesanan Selesai</option>
                            <option value="Pesanan Dibatalkan">Pesanan Dibatalkan</option>
                        </select>
                    </div>
                    <div style="margin-bottom: 12px;">
                        <label style="display: block; font-size: 0.85em; color: #374151; font-weight: 600; margin-bottom: 6px;">Keterangan</label>
                        <textarea name="keterangan" style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px; background: white; color: #374151; font-size: 0.9em; font-family: inherit; resize: vertical;" rows="3" placeholder="Tambahkan catatan..."></textarea>
                    </div>
                    <button type="submit" style="width: 100%; padding: 8px 12px; background: #667eea; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 0.85em; font-weight: 600; transition: all 0.2s;"
                        onmouseover="this.style.background='#764ba2'" onmouseout="this.style.background='#667eea'">
                        💾 Simpan Tracking
                    </button>
                </form>
            </div>
        </div>

    </div>

</div>

<style>
    @media (max-width: 768px) {
        div[style*="grid-template-columns: 1fr 380px"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>

@endsection
