@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $pesanan->id_pesanan)

@section('content')

<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px; flex-wrap: wrap; gap: 16px;">
    <div style="display: flex; align-items: center; gap: 12px;">
        <a href="/pesanan/saya" style="color: var(--text-secondary); text-decoration: none; font-size: 1.2em; transition: color 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--text-secondary)'">←</a>
        <h1 style="font-size: 1.8em; color: var(--dark); margin: 0; font-weight: 700;">Detail Pesanan #{{ $pesanan->id_pesanan }}</h1>
    </div>
    
    @php
    $statusColors = [
        'pending'    => ['bg' => 'rgba(231,200,158,0.15)', 'text' => 'var(--dark)', 'border' => 'var(--warning)', 'emoji' => '⏳'],
        'diproses'   => ['bg' => 'rgba(120,157,188,0.15)', 'text' => 'var(--dark)', 'border' => 'var(--primary)', 'emoji' => '🔄'],
        'dikirim'    => ['bg' => 'rgba(126,187,152,0.15)', 'text' => 'var(--dark)', 'border' => 'var(--success)', 'emoji' => '🚚'],
        'selesai'    => ['bg' => 'rgba(126,187,152,0.15)', 'text' => 'var(--dark)', 'border' => 'var(--success)', 'emoji' => '✅'],
        'dibatalkan' => ['bg' => 'rgba(217,137,153,0.15)', 'text' => 'var(--danger)', 'border' => 'var(--danger)', 'emoji' => '❌'],
    ];
    $sc = $statusColors[$pesanan->status_pesanan] ?? ['bg' => 'var(--surface-muted)', 'text' => 'var(--dark)', 'border' => 'var(--border)', 'emoji' => '📋'];
    @endphp

    <span style="padding: 6px 16px; border-radius: 20px; font-size: 0.9em; font-weight: 700;
                  background: {{ $sc['bg'] }}; color: {{ $sc['text'] }}; border: 1px solid {{ $sc['border'] }};">
        {{ $sc['emoji'] }} {{ ucfirst($pesanan->status_pesanan) }}
    </span>
</div>

<div style="display: grid; grid-template-columns: 1fr 340px; gap: 24px; align-items: start;">
    
    <!-- KIRI: Daftar Produk -->
    <div style="background: var(--surface-strong); border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
        <div style="padding: 18px 24px; border-bottom: 1px solid var(--border); background: var(--surface-muted);">
            <h2 style="margin: 0; font-size: 1.1em; font-weight: 700; color: var(--dark);">📦 Daftar Produk</h2>
        </div>
        
        <div>
            @foreach($pesanan->items as $pi)
            <div style="display: flex; align-items: center; gap: 16px; padding: 16px 24px; border-bottom: 1px solid var(--border);">
                <div style="width: 60px; height: 60px; background: var(--surface-muted); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.8em; flex-shrink: 0; overflow: hidden;">
                    @if(!empty($pi->produk->foto))
                        <img src="{{ asset('storage/' . $pi->produk->foto) }}" alt="{{ $pi->produk->nama_produk ?? 'Produk' }}" style="width:60px; height:60px; object-fit:cover; display:block;">
                    @else
                        <div style="font-size:1.6em;">🍰</div>
                    @endif
                </div>
                <div style="flex: 1;">
                    <p style="margin: 0; font-size: 1em; font-weight: 700; color: var(--dark);">{{ $pi->produk->nama_produk ?? 'Produk' }}</p>
                    <p style="margin: 4px 0 0; font-size: 0.85em; color: var(--text-secondary);">Rp {{ number_format($pi->harga_satuan_pesanan, 0, ',', '.') }}</p>
                </div>
                <div style="text-align: right;">
                    <p style="margin: 0; font-size: 0.9em; font-weight: 600; color: var(--text-secondary);">{{ $pi->jumlah_pesanan }}x</p>
                    <p style="margin: 4px 0 0; font-weight: 700; color: var(--primary); font-size: 1.05em; white-space: nowrap;">
                        Rp {{ number_format($pi->subtotal_pesanan, 0, ',', '.') }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
        
        <div style="padding: 20px 24px; background: var(--surface-muted); text-align: right;">
            <p style="margin: 0; font-size: 0.9em; color: var(--text-secondary); margin-bottom: 4px;">Total Pesanan</p>
            <p style="margin: 0; font-size: 1.4em; font-weight: 700; color: var(--dark);">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- KANAN: Info Pembayaran & Pengiriman -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        
        <!-- Info Pembayaran -->
        <div style="background: var(--surface-strong); border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 20px;">
            <h3 style="margin: 0 0 16px; font-size: 1.1em; font-weight: 700; color: var(--dark); border-bottom: 1px solid var(--border); padding-bottom: 12px;">💳 Informasi Pembayaran</h3>
            
            <div style="display: flex; justify-content: space-between; font-size: 0.9em; margin-bottom: 10px; color: var(--text-secondary);">
                <span>Metode</span>
                <span style="font-weight: 700; color: var(--dark); text-transform: capitalize;">{{ $pesanan->pembayaran->metode_pembayaran ?? '-' }}</span>
            </div>
            
            <div style="display: flex; justify-content: space-between; font-size: 0.9em; margin-bottom: 10px; color: var(--text-secondary);">
                <span>Status</span>
                @php $sp = $pesanan->pembayaran->status_pembayaran ?? 'menunggu'; @endphp
                @if($sp === 'lunas')
                    <span style="font-weight: 700; color: var(--success);">✔ Lunas</span>
                @else
                    <span style="font-weight: 700; color: var(--dark);">⏳ Menunggu Pembayaran</span>
                @endif
            </div>

            <div style="display: flex; justify-content: space-between; font-size: 0.9em; margin-bottom: 10px; color: var(--text-secondary);">
                <span>Tanggal Pembayaran</span>
                <span style="font-weight: 600; color: var(--dark);">
                    {{ $pesanan->pembayaran && $pesanan->pembayaran->tanggal_pembayaran ? \Carbon\Carbon::parse($pesanan->pembayaran->tanggal_pembayaran)->format('d M Y, H:i') : '-' }}
                </span>
            </div>
            
            @if($pesanan->status_pesanan === 'pending' && $sp !== 'lunas')
            <div style="margin-top: 24px;">
                <a href="/pembayaran/{{ $pesanan->id_pesanan }}" style="display: block; width: 100%; text-align: center; padding: 12px; background: var(--gradient-brand); color: white; border-radius: 8px; font-size: 0.95em; font-weight: 700; text-decoration: none; box-shadow: 0 4px 12px rgba(120, 157, 188, 0.4);">
                    Selesaikan Pembayaran Sekarang
                </a>
            </div>
            @endif
        </div>

        <!-- Info Pemesan -->
        <div style="background: var(--surface-strong); border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 20px;">
            <h3 style="margin: 0 0 16px; font-size: 1.1em; font-weight: 700; color: var(--dark); border-bottom: 1px solid var(--border); padding-bottom: 12px;">📍 Info Pemesan</h3>
            
            <div style="margin-bottom: 10px;">
                <span style="font-size: 0.8em; color: var(--text-secondary); display: block; margin-bottom: 2px;">Nama</span>
                <span style="font-weight: 600; color: var(--dark); font-size: 0.95em;">{{ $pesanan->user->name ?? '-' }}</span>
            </div>
            
            <div style="margin-bottom: 10px;">
                <span style="font-size: 0.8em; color: var(--text-secondary); display: block; margin-bottom: 2px;">No. HP</span>
                <span style="font-weight: 600; color: var(--dark); font-size: 0.95em;">{{ $pesanan->user->phone ?? '-' }}</span>
            </div>

            <div style="margin-bottom: 10px;">
                <span style="font-size: 0.8em; color: var(--text-secondary); display: block; margin-bottom: 2px;">Alamat Pengiriman</span>
                <span style="font-weight: 600; color: var(--dark); font-size: 0.95em; line-height: 1.4; display: block;">
                    {{ $pesanan->user->alamat ?? 'Belum mengatur alamat.' }}
                </span>
            </div>
        </div>

    </div>
</div>

<style>
@media (max-width: 900px) {
    div[style*="grid-template-columns: 1fr 340px"] { grid-template-columns: 1fr !important; }
}
</style>

@endsection
