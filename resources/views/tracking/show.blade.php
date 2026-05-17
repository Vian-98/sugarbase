@extends('layouts.app')

@section('title', 'Tracking Pesanan')

@section('content')

<!-- STEP INDICATOR -->
@php
    $isBayarSelesai = ($pesanan->pembayaran->status_pembayaran ?? '') === 'lunas';
    $isSelesai = $pesanan->status_pesanan === 'selesai';
    
    // Pembayaran Step
    if ($isBayarSelesai) {
        $payBg = 'var(--success)';
        $payText = '✓';
        $payColor = 'var(--success)';
        $line1 = 'var(--success)';
    } else {
        $payBg = 'var(--gradient-brand)';
        $payText = '2';
        $payColor = 'var(--primary)';
        $line1 = 'var(--border)';
    }

    // Tracking Step
    if ($isSelesai) {
        $trackBg = 'var(--success)';
        $trackText = '✓';
        $trackColor = 'var(--success)';
        $line2 = 'var(--success)';
    } elseif ($isBayarSelesai) {
        $trackBg = 'var(--gradient-brand)';
        $trackText = '3';
        $trackColor = 'var(--primary)';
        $line2 = 'var(--primary)';
    } else {
        $trackBg = 'var(--surface-muted)';
        $trackText = '3';
        $trackColor = 'var(--text-secondary)';
        $line2 = 'var(--border)';
    }
@endphp
<div style="display: flex; align-items: center; margin-bottom: 32px; gap: 0;">
    <div style="display: flex; align-items: center; gap: 8px;">
        <div style="width: 32px; height: 32px; background: var(--success); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.85em; font-weight: 700;">✓</div>
        <span style="font-size: 0.85em; font-weight: 600; color: var(--success);">Pesanan</span>
    </div>
    <div style="flex: 1; height: 2px; background: {{ $line1 }}; margin: 0 12px; transition: 0.3s;"></div>
    <div style="display: flex; align-items: center; gap: 8px;">
        <div style="width: 32px; height: 32px; background: {{ $payBg }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.85em; font-weight: 700; transition: 0.3s;">{{ $payText }}</div>
        <span style="font-size: 0.85em; font-weight: 600; color: {{ $payColor }}; transition: 0.3s;">Pembayaran</span>
    </div>
    <div style="flex: 1; height: 2px; background: {{ $line2 }}; margin: 0 12px; transition: 0.3s;"></div>
    <div style="display: flex; align-items: center; gap: 8px;">
        <div style="width: 32px; height: 32px; background: {{ $trackBg }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: {{ $trackBg === 'var(--surface-muted)' ? 'var(--text-secondary)' : 'white' }}; font-size: 0.85em; font-weight: 700; transition: 0.3s;">{{ $trackText }}</div>
        <span style="font-size: 0.85em; font-weight: 600; color: {{ $trackColor }}; transition: 0.3s;">Tracking</span>
    </div>
</div>

<!-- HEADER -->
<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px;">
    <h1 style="font-size: 1.8em; color: var(--dark); margin: 0; font-weight: 700;">📍 Tracking Pesanan #{{ str_pad($pesanan->id_pesanan, 6, '0', STR_PAD_LEFT) }}</h1>
    <a href="/pesanan/saya" style="display: inline-block; background: var(--surface-muted); color: var(--text-secondary); padding: 10px 20px; border-radius: 8px; text-decoration: none; font-size: 0.85em; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.background='var(--surface-strong)'" onmouseout="this.style.background='var(--surface-muted)'">← Kembali</a>
</div>

<div style="display: grid; grid-template-columns: 1fr 360px; gap: 24px; align-items: start;">

    <!-- TIMELINE MAIN -->
    <div>
        <div style="background: var(--surface-strong); border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
            <div style="padding: 24px;">
                <h3 style="margin: 0 0 24px; font-size: 1.1em; color: var(--dark); font-weight: 700;">Perjalanan Pesanan Anda</h3>
                
                <div class="timeline-container">
                    @php
                        $allStatuses = [
                            ['name' => 'Pesanan Diterima', 'icon' => '📦', 'color' => 'var(--primary)'],
                            ['name' => 'Pembayaran Dikonfirmasi', 'icon' => '✓', 'color' => 'var(--success)'],
                            ['name' => 'Sedang Diproses', 'icon' => '👨‍🍳', 'color' => 'var(--warning)'],
                            ['name' => 'Dalam Pengiriman', 'icon' => '🚚', 'color' => 'var(--primary)'],
                            ['name' => 'Pesanan Selesai', 'icon' => '✅', 'color' => 'var(--success)'],
                        ];
                    @endphp

                    @foreach($allStatuses as $i => $status)
                    @php
                        $tracking = $pesanan->tracking()->where('status', $status['name'])->first();
                        $completed = !is_null($tracking);
                    @endphp
                    <div class="timeline-item {{ $completed ? 'completed' : '' }}" style="display: flex; gap: 16px; margin-bottom: {{ $i === count($allStatuses) - 1 ? '0' : '28px' }}; opacity: {{ $completed ? '1' : '0.6' }}; transition: opacity 0.2s;">
                        <div style="display: flex; flex-direction: column; align-items: center; flex-shrink: 0;">
                            <div style="width: 48px; height: 48px; background: {{ $completed ? $status['color'] : 'var(--surface-muted)' }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: {{ $completed ? 'white' : 'var(--text-secondary)' }}; font-size: 1.4rem; font-weight: 700; transition: all 0.3s;">
                                {{ $status['icon'] }}
                            </div>
                            @if($i < count($allStatuses) - 1)
                            <div style="width: 2px; height: 48px; background: {{ $completed ? 'linear-gradient(180deg, ' . $status['color'] . ', var(--border))' : 'var(--border)' }}; margin: 8px 0;"></div>
                            @endif
                        </div>
                        
                        <div style="flex: 1; padding-top: 6px;">
                            <h5 style="margin: 0 0 8px; font-weight: 700; color: {{ $completed ? 'var(--dark)' : 'var(--text-secondary)' }}; font-size: 0.95em;">{{ $status['name'] }}</h5>
                            @if($tracking)
                            <p style="margin: 0 0 6px; font-size: 0.8em; color: var(--text-secondary);">📅 {{ $tracking->waktu_update->format('d M Y') }} · ⏰ {{ $tracking->waktu_update->format('H:i') }}</p>
                            <p style="margin: 0; font-size: 0.9em; color: var(--text-secondary); line-height: 1.5;">{{ $tracking->keterangan }}</p>
                            @else
                            <p style="margin: 0; font-size: 0.85em; color: var(--text-secondary); font-style: italic;">Menunggu status berikutnya...</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- SIDEBAR -->
    <div style="display: flex; flex-direction: column; gap: 20px;">
        
        <!-- STATUS CARD -->
        <div style="background: var(--surface-strong); border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
            <div style="padding: 20px 24px; border-bottom: 1px solid var(--border); background: var(--gradient-soft);">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="font-size: 1.8em;">📊</span>
                    <div>
                        <h3 style="margin: 0; font-size: 0.95em; font-weight: 700; color: var(--primary);">Status Saat Ini</h3>
                        <p style="margin: 2px 0 0; font-size: 0.8em; color: var(--text-secondary);">Progres pesanan</p>
                    </div>
                </div>
            </div>
            <div style="padding: 20px 24px;">
                @php
                    $status = $pesanan->status_pesanan;
                    $statusInfo = match($status) {
                        'pending' => ['label' => 'Menunggu Pembayaran', 'emoji' => '⏳', 'color' => 'var(--warning)', 'bg' => 'rgba(231,200,158,0.15)'],
                        'diproses' => ['label' => 'Sedang Diproses', 'emoji' => '🔄', 'color' => 'var(--primary)', 'bg' => 'rgba(120,157,188,0.15)'],
                        'dikirim' => ['label' => 'Dalam Pengiriman', 'emoji' => '🚚', 'color' => 'var(--success)', 'bg' => 'rgba(126,187,152,0.15)'],
                        'selesai' => ['label' => 'Selesai', 'emoji' => '✅', 'color' => 'var(--success)', 'bg' => 'rgba(126,187,152,0.15)'],
                        'dibatalkan' => ['label' => 'Dibatalkan', 'emoji' => '❌', 'color' => 'var(--danger)', 'bg' => 'rgba(217,137,153,0.15)'],
                        default => ['label' => 'Unknown', 'emoji' => '❓', 'color' => 'var(--text-secondary)', 'bg' => 'var(--surface-muted)']
                    };
                @endphp
                <div style="text-align: center; padding: 16px 0; border: 1px solid var(--border); border-radius: 8px; background: {{ $statusInfo['bg'] }};">
                    <div style="font-size: 2.5em; margin-bottom: 8px;">{{ $statusInfo['emoji'] }}</div>
                    <p style="margin: 0; font-size: 0.95em; font-weight: 700; color: {{ $statusInfo['color'] }};">{{ $statusInfo['label'] }}</p>
                </div>
            </div>
        </div>

        <!-- DETAIL CARD -->
        <div style="background: var(--surface-strong); border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
            <div style="padding: 20px 24px; border-bottom: 1px solid var(--border); background: var(--gradient-soft);">
                <h3 style="margin: 0; font-size: 0.95em; font-weight: 700; color: var(--dark);">💰 Detail Pembayaran</h3>
            </div>
            <div style="padding: 20px 24px;">
                <div style="margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid var(--border);">
                    <small style="display: block; font-size: 0.75em; color: var(--text-secondary); font-weight: 600; margin-bottom: 4px;">Total Harga</small>
                    <h4 style="margin: 0; font-size: 1.3em; font-weight: 700; color: var(--primary);">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</h4>
                </div>
                <div style="margin-bottom: 12px;">
                    <small style="display: block; font-size: 0.75em; color: var(--text-secondary); font-weight: 600; margin-bottom: 4px;">Tanggal Pesanan</small>
                    <p style="margin: 0; font-size: 0.9em; color: var(--text-secondary); font-weight: 500;">{{ $pesanan->tanggal_pesan->format('d M Y') }}</p>
                </div>
                <div>
                    <small style="display: block; font-size: 0.75em; color: var(--text-secondary); font-weight: 600; margin-bottom: 4px;">Metode Pembayaran</small>
                    <p style="margin: 0; font-size: 0.9em; color: var(--text-secondary); font-weight: 500;">{{ ucfirst($pesanan->pembayaran->metode_pembayaran ?? '-') }}</p>
                </div>
            </div>
        </div>

        <!-- ITEMS CARD -->
        <div style="background: var(--surface-strong); border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
            <div style="padding: 20px 24px; border-bottom: 1px solid var(--border); background: var(--gradient-soft);">
                <h3 style="margin: 0; font-size: 0.95em; font-weight: 700; color: var(--dark);">📦 Item Pesanan <span style="background: var(--surface-muted); color: var(--text-secondary); padding: 2px 8px; border-radius: 6px; font-size: 0.8em; margin-left: 6px;">{{ count($pesanan->items) }}</span></h3>
            </div>
            <div style="padding: 16px 20px;">
                @foreach($pesanan->items as $item)
                <div style="padding: 12px; margin-bottom: 8px; background: var(--gradient-soft); border-radius: 8px; border-left: 3px solid var(--primary); transition: all 0.2s;" onmouseover="this.style.background='var(--surface-muted)'" onmouseout="this.style.background='var(--gradient-soft)'">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 8px;">
                        <div style="flex: 1;">
                            <p style="margin: 0 0 4px; font-size: 0.85em; font-weight: 600; color: var(--text-secondary);">{{ $item->produk->nama_produk }}</p>
                            <small style="color: var(--text-secondary); font-size: 0.8em;">Qty: <span style="font-weight: 700; color: #789DBC;">{{ $item->jumlah_pesanan }}x</span></small>
                        </div>
                        <div style="text-align: right; flex-shrink: 0;">
                            <small style="color: var(--text-secondary); display: block; font-size: 0.75em; margin-bottom: 2px;">Rp {{ number_format($item->subtotal_pesanan, 0, ',', '.') }}</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

</div>

<style>
    .timeline-container {
        position: relative;
    }

    .timeline-item {
        animation: fadeInUp 0.5s ease-out forwards;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .timeline-item:hover {
        opacity: 1 !important;
    }

    @media (max-width: 768px) {
        div[style*="grid-template-columns: 1fr 360px"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<script>
    // Auto-refresh setiap 30 detik
    setTimeout(function() {
        location.reload();
    }, 30000);
</script>
@endsection
