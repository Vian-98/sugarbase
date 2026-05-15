@extends('layouts.app')

@section('title', 'Tracking Pesanan')

@section('content')

<!-- STEP INDICATOR -->
<div style="display: flex; align-items: center; margin-bottom: 32px; gap: 0;">
    <div style="display: flex; align-items: center; gap: 8px;">
        <div style="width: 32px; height: 32px; background: #22c55e; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.85em; font-weight: 700;">✓</div>
        <span style="font-size: 0.85em; font-weight: 600; color: #22c55e;">Pesanan</span>
    </div>
    <div style="flex: 1; height: 2px; background: #22c55e; margin: 0 12px;"></div>
    <div style="display: flex; align-items: center; gap: 8px;">
        <div style="width: 32px; height: 32px; background: #22c55e; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.85em; font-weight: 700;">✓</div>
        <span style="font-size: 0.85em; font-weight: 600; color: #22c55e;">Pembayaran</span>
    </div>
    <div style="flex: 1; height: 2px; background: #667eea; margin: 0 12px;"></div>
    <div style="display: flex; align-items: center; gap: 8px;">
        <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.85em; font-weight: 700;">4</div>
        <span style="font-size: 0.85em; font-weight: 600; color: #667eea;">Tracking</span>
    </div>
</div>

<!-- HEADER -->
<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 28px;">
    <h1 style="font-size: 1.8em; color: #1f2937; margin: 0; font-weight: 700;">📍 Tracking Pesanan #{{ str_pad($pesanan->id_pesanan, 6, '0', STR_PAD_LEFT) }}</h1>
    <a href="/pesanan/saya" style="display: inline-block; background: #f3f4f6; color: #374151; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-size: 0.85em; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">← Kembali</a>
</div>

<div style="display: grid; grid-template-columns: 1fr 360px; gap: 24px; align-items: start;">

    <!-- TIMELINE MAIN -->
    <div>
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
            <div style="padding: 24px;">
                <h3 style="margin: 0 0 24px; font-size: 1.1em; color: #1f2937; font-weight: 700;">Perjalanan Pesanan Anda</h3>
                
                <div class="timeline-container">
                    @php
                        $allStatuses = [
                            ['name' => 'Pesanan Diterima', 'icon' => '📦', 'color' => '#667eea'],
                            ['name' => 'Pembayaran Dikonfirmasi', 'icon' => '✓', 'color' => '#764ba2'],
                            ['name' => 'Sedang Diproses', 'icon' => '👨‍🍳', 'color' => '#f093fb'],
                            ['name' => 'Dalam Pengiriman', 'icon' => '🚚', 'color' => '#4facfe'],
                            ['name' => 'Pesanan Selesai', 'icon' => '✅', 'color' => '#43e97b'],
                        ];
                    @endphp

                    @foreach($allStatuses as $i => $status)
                    @php
                        $tracking = $pesanan->tracking()->where('status', $status['name'])->first();
                        $completed = !is_null($tracking);
                    @endphp
                    <div class="timeline-item {{ $completed ? 'completed' : '' }}" style="display: flex; gap: 16px; margin-bottom: {{ $i === count($allStatuses) - 1 ? '0' : '28px' }}; opacity: {{ $completed ? '1' : '0.6' }}; transition: opacity 0.2s;">
                        <div style="display: flex; flex-direction: column; align-items: center; flex-shrink: 0;">
                            <div style="width: 48px; height: 48px; background: {{ $completed ? $status['color'] : '#f3f4f6' }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: {{ $completed ? 'white' : '#9ca3af' }}; font-size: 1.4rem; font-weight: 700; transition: all 0.3s;">
                                {{ $status['icon'] }}
                            </div>
                            @if($i < count($allStatuses) - 1)
                            <div style="width: 2px; height: 48px; background: {{ $completed ? 'linear-gradient(180deg, ' . $status['color'] . ', #e5e7eb)' : '#e5e7eb' }}; margin: 8px 0;"></div>
                            @endif
                        </div>
                        
                        <div style="flex: 1; padding-top: 6px;">
                            <h5 style="margin: 0 0 8px; font-weight: 700; color: {{ $completed ? '#1f2937' : '#9ca3af' }}; font-size: 0.95em;">{{ $status['name'] }}</h5>
                            @if($tracking)
                            <p style="margin: 0 0 6px; font-size: 0.8em; color: #6b7280;">📅 {{ $tracking->waktu_update->format('d M Y') }} · ⏰ {{ $tracking->waktu_update->format('H:i') }}</p>
                            <p style="margin: 0; font-size: 0.9em; color: #374151; line-height: 1.5;">{{ $tracking->keterangan }}</p>
                            @else
                            <p style="margin: 0; font-size: 0.85em; color: #9ca3af; font-style: italic;">Menunggu status berikutnya...</p>
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
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
            <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb; background: linear-gradient(135deg, #f8f6ff, #ede9fe);">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="font-size: 1.8em;">📊</span>
                    <div>
                        <h3 style="margin: 0; font-size: 0.95em; font-weight: 700; color: #667eea;">Status Saat Ini</h3>
                        <p style="margin: 2px 0 0; font-size: 0.8em; color: #9ca3af;">Progres pesanan</p>
                    </div>
                </div>
            </div>
            <div style="padding: 20px 24px;">
                @php
                    $status = $pesanan->status_pesanan;
                    $statusInfo = match($status) {
                        'pending' => ['label' => 'Menunggu Pembayaran', 'emoji' => '⏳', 'color' => '#d97706'],
                        'diproses' => ['label' => 'Sedang Diproses', 'emoji' => '🔄', 'color' => '#2563eb'],
                        'dikirim' => ['label' => 'Dalam Pengiriman', 'emoji' => '🚚', 'color' => '#16a34a'],
                        'selesai' => ['label' => 'Selesai', 'emoji' => '✅', 'color' => '#15803d'],
                        'dibatalkan' => ['label' => 'Dibatalkan', 'emoji' => '❌', 'color' => '#dc2626'],
                        default => ['label' => 'Unknown', 'emoji' => '❓', 'color' => '#6b7280']
                    };
                @endphp
                <div style="text-align: center; padding: 16px 0; border: 2px solid {{ $statusInfo['color'] }}; border-radius: 8px; background: rgba({{ $statusInfo['color'] }}, 0.05);">
                    <div style="font-size: 2.5em; margin-bottom: 8px;">{{ $statusInfo['emoji'] }}</div>
                    <p style="margin: 0; font-size: 0.95em; font-weight: 700; color: {{ $statusInfo['color'] }};">{{ $statusInfo['label'] }}</p>
                </div>
            </div>
        </div>

        <!-- DETAIL CARD -->
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
            <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb; background: #f9fafb;">
                <h3 style="margin: 0; font-size: 0.95em; font-weight: 700; color: #1f2937;">💰 Detail Pembayaran</h3>
            </div>
            <div style="padding: 20px 24px;">
                <div style="margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid #f3f4f6;">
                    <small style="display: block; font-size: 0.75em; color: #9ca3af; font-weight: 600; margin-bottom: 4px;">Total Harga</small>
                    <h4 style="margin: 0; font-size: 1.3em; font-weight: 700; color: #667eea;">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</h4>
                </div>
                <div style="margin-bottom: 12px;">
                    <small style="display: block; font-size: 0.75em; color: #9ca3af; font-weight: 600; margin-bottom: 4px;">Tanggal Pesanan</small>
                    <p style="margin: 0; font-size: 0.9em; color: #374151; font-weight: 500;">{{ $pesanan->tanggal_pesan->format('d M Y') }}</p>
                </div>
                <div>
                    <small style="display: block; font-size: 0.75em; color: #9ca3af; font-weight: 600; margin-bottom: 4px;">Metode Pembayaran</small>
                    <p style="margin: 0; font-size: 0.9em; color: #374151; font-weight: 500;">{{ ucfirst($pesanan->pembayaran->metode_pembayaran ?? '-') }}</p>
                </div>
            </div>
        </div>

        <!-- ITEMS CARD -->
        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
            <div style="padding: 20px 24px; border-bottom: 1px solid #e5e7eb; background: #f9fafb;">
                <h3 style="margin: 0; font-size: 0.95em; font-weight: 700; color: #1f2937;">📦 Item Pesanan <span style="background: #e5e7eb; color: #6b7280; padding: 2px 8px; border-radius: 6px; font-size: 0.8em; margin-left: 6px;">{{ count($pesanan->items) }}</span></h3>
            </div>
            <div style="padding: 16px 20px;">
                @foreach($pesanan->items as $item)
                <div style="padding: 12px; margin-bottom: 8px; background: #f9fafb; border-radius: 8px; border-left: 3px solid #667eea; transition: all 0.2s;" onmouseover="this.style.background='#f3f4f6'" onmouseout="this.style.background='#f9fafb'">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 8px;">
                        <div style="flex: 1;">
                            <p style="margin: 0 0 4px; font-size: 0.85em; font-weight: 600; color: #374151;">{{ $item->produk->nama_produk }}</p>
                            <small style="color: #9ca3af; font-size: 0.8em;">Qty: <span style="font-weight: 700; color: #667eea;">{{ $item->jumlah_pesanan }}x</span></small>
                        </div>
                        <div style="text-align: right; flex-shrink: 0;">
                            <small style="color: #9ca3af; display: block; font-size: 0.75em; margin-bottom: 2px;">Rp {{ number_format($item->subtotal_pesanan, 0, ',', '.') }}</small>
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
