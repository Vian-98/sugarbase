@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')

<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px;">
    <h1 style="font-size: 1.8em; color: var(--dark); margin: 0; font-weight: 700;">📦 Pesanan Saya</h1>
    <a href="/katalog" style="display: inline-block; background: linear-gradient(135deg, #789DBC 0%, #9FBCCD 100%); color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-size: 0.85em; font-weight: 600;">+ Belanja Lagi</a>
</div>

<!-- FLASH MESSAGES -->
@if(session('success'))
<div style="background: rgba(126,187,152,0.15); border: 1px solid #86efac; color: var(--success); padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">
    ✅ {{ session('success') }}
</div>
@endif

<!-- FILTER TAB STATUS -->
@php
$statuses = ['semua' => 'Semua', 'pending' => 'Pending', 'diproses' => 'Diproses', 'dikirim' => 'Dikirim', 'selesai' => 'Selesai', 'dibatalkan' => 'Dibatalkan'];
$aktif = request('status', 'semua');
@endphp

<div style="display: flex; gap: 8px; margin-bottom: 24px; flex-wrap: wrap;">
    @foreach($statuses as $key => $label)
    <a href="/pesanan/saya?status={{ $key }}"
        style="padding: 8px 18px; border-radius: 20px; text-decoration: none; font-size: 0.85em; font-weight: 600; transition: all 0.2s;
               background: {{ $aktif === $key ? 'linear-gradient(135deg, #789DBC, #9FBCCD)' : 'var(--surface-muted)' }};
               color: {{ $aktif === $key ? 'white' : 'var(--text-secondary)' }};">
        {{ $label }}
        @if($aktif === $key && isset($totalPerStatus[$key]))
            <span style="background: rgba(255,255,255,0.3); padding: 1px 7px; border-radius: 10px; font-size: 0.85em; margin-left: 4px;">{{ $totalPerStatus[$key] }}</span>
        @endif
    </a>
    @endforeach
</div>

<!-- LIST PESANAN -->
@if($pesanan->count() === 0)
<div style="background: var(--surface-strong); border-radius: 12px; padding: 80px 40px; text-align: center; border: 1px solid var(--border); box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
    <div style="font-size: 5em; margin-bottom: 20px;">📭</div>
    <h2 style="color: var(--text-secondary); font-size: 1.3em; margin-bottom: 10px;">Belum ada pesanan</h2>
    <p style="color: var(--text-secondary); margin-bottom: 24px;">Yuk, mulai belanja dessert favoritmu!</p>
    <a href="/katalog" style="display: inline-block; background: linear-gradient(135deg, #789DBC 0%, #9FBCCD 100%); color: white; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-weight: 600;">
        Belanja Sekarang →
    </a>
</div>
@else

<div style="display: flex; flex-direction: column; gap: 16px;">
    @foreach($pesanan as $item)
    @php
    $statusColors = [
        'pending'    => ['bg' => 'rgba(231,200,158,0.15)', 'text' => 'var(--warning)', 'border' => 'var(--border)', 'emoji' => '⏳'],
        'diproses'   => ['bg' => 'rgba(120,157,188,0.15)', 'text' => 'var(--primary)', 'border' => 'var(--border)', 'emoji' => '🔄'],
        'dikirim'    => ['bg' => 'rgba(126,187,152,0.15)', 'text' => 'var(--success)', 'border' => 'var(--border)', 'emoji' => '🚚'],
        'selesai'    => ['bg' => 'rgba(126,187,152,0.15)', 'text' => 'var(--success)', 'border' => 'var(--border)', 'emoji' => '✅'],
        'dibatalkan' => ['bg' => 'rgba(217,137,153,0.15)', 'text' => 'var(--danger)', 'border' => 'var(--border)', 'emoji' => '❌'],
    ];
    $sc = $statusColors[$item->status_pesanan] ?? ['bg' => 'var(--surface-muted)', 'text' => 'var(--text-secondary)', 'border' => 'var(--border)', 'emoji' => '📋'];
    @endphp

    <div style="background: var(--surface-strong); border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 2px 8px rgba(0,0,0,0.05); overflow: hidden; transition: box-shadow 0.2s;"
         onmouseover="this.style.boxShadow='0 4px 20px rgba(102,126,234,0.12)'" onmouseout="this.style.boxShadow='0 2px 8px rgba(0,0,0,0.05)'">

        <!-- Header Pesanan -->
        <div style="padding: 14px 20px; background: var(--gradient-soft); border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
            <div style="display: flex; align-items: center; gap: 14px;">
                <span style="font-weight: 700; color: var(--text-secondary); font-size: 0.9em;">Pesanan #{{ $item->id_pesanan }}</span>
                <span style="font-size: 0.8em; color: var(--text-secondary);">{{ \Carbon\Carbon::parse($item->tanggal_pesan)->format('d M Y') }}</span>
            </div>
            <span style="padding: 4px 14px; border-radius: 20px; font-size: 0.8em; font-weight: 600;
                          background: {{ $sc['bg'] }}; color: {{ $sc['text'] }}; border: 1px solid {{ $sc['border'] }};">
                {{ $sc['emoji'] }} {{ ucfirst($item->status_pesanan) }}
            </span>
        </div>

        <!-- Item Produk -->
        <div style="padding: 16px 20px; border-bottom: 1px solid var(--border);">
            @foreach($item->items->take(3) as $pi)
            <div style="display: flex; align-items: center; gap: 12px; {{ !$loop->last ? 'margin-bottom: 12px;' : '' }}">
                <div style="width: 48px; height: 48px; background: var(--surface-muted); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.6em; flex-shrink: 0; overflow: hidden;">
                    @if(!empty($pi->produk->foto))
                        <img src="{{ asset('storage/' . $pi->produk->foto) }}" alt="{{ $pi->produk->nama_produk ?? 'Produk' }}" style="width:48px; height:48px; object-fit:cover; display:block;">
                    @else
                        <div style="font-size:1.6em;">🍰</div>
                    @endif
                </div>
                <div style="flex: 1;">
                    <p style="margin: 0; font-size: 0.9em; font-weight: 600; color: var(--dark);">{{ $pi->produk->nama_produk ?? 'Produk' }}</p>
                    <p style="margin: 3px 0 0; font-size: 0.8em; color: var(--text-secondary);">{{ $pi->jumlah_pesanan }} × Rp {{ number_format($pi->harga_satuan_pesanan, 0, ',', '.') }}</p>
                </div>
                <div style="font-weight: 600; color: var(--text-secondary); font-size: 0.9em; white-space: nowrap;">
                    Rp {{ number_format($pi->subtotal_pesanan, 0, ',', '.') }}
                </div>
            </div>
            @endforeach

            @if($item->items->count() > 3)
            <p style="margin: 10px 0 0; font-size: 0.8em; color: var(--text-secondary); font-style: italic;">
                +{{ $item->items->count() - 3 }} produk lainnya
            </p>
            @endif
        </div>

        <!-- Footer Pesanan -->
        <div style="padding: 14px 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
            <div style="display: flex; align-items: center; gap: 16px;">
                @php $mp = $item->pembayaran->metode_pembayaran ?? '-'; @endphp
                <span style="font-size: 0.8em; color: var(--text-secondary);">
                    💳 {{ ucfirst($mp) }}
                </span>
                @if($item->pembayaran && $item->pembayaran->status_pembayaran === 'lunas')
                <span style="font-size: 0.8em; color: var(--success); font-weight: 600;">✔ Lunas</span>
                @elseif($item->status_pesanan === 'pending')
                <a href="/pembayaran/{{ $item->id_pesanan }}" style="font-size: 0.8em; color: var(--danger); font-weight: 600; text-decoration: none;">⚠ Bayar Sekarang</a>
                @endif
            </div>

            <div style="display: flex; align-items: center; gap: 14px;">
                <span style="font-weight: 700; color: #789DBC; font-size: 1em;">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</span>
                <a href="/pesanan/{{ $item->id_pesanan }}"
                    style="padding: 8px 16px; background: var(--surface-muted); color: var(--text-secondary); border-radius: 8px; text-decoration: none; font-size: 0.85em; font-weight: 600; border: 1px solid var(--border); transition: all 0.2s;"
                    onmouseover="this.style.background='#789DBC'; this.style.color='white'"
                    onmouseout="this.style.background='var(--surface-muted)'; this.style.color='var(--text-secondary)'">
                    Lihat Detail →
                </a>
            </div>
        </div>

    </div>
    @endforeach
</div>

<!-- PAGINATION -->
@if(method_exists($pesanan, 'links'))
<div style="margin-top: 28px; display: flex; justify-content: center;">
    {{ $pesanan->appends(request()->query())->links() }}
</div>
@endif

@endif

@endsection