@extends('layouts.app') {{-- Pastikan layout ini tidak memiliki sidebar --}}

@section('title', 'Notifikasi')

@section('content')
<div style="max-width: 1000px; margin: 50px auto; padding: 0 25px; font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;">

    {{-- Header Section --}}
    <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 40px;">
        <div>
            <h1 style="font-size: 2.2rem; font-weight: 850; color: #0f172a; margin: 0; letter-spacing: -0.04em;">
                Notifikasi
            </h1>
            <p style="color: #64748b; margin-top: 8px; font-size: 1.1rem; font-weight: 400;">
                Kelola pesan sistem dan aktivitas transaksi Anda.
            </p>
        </div>

        @if($notifikasi->where('status_baca', 'belum')->count() > 0)
            <div style="margin: 0;">
                <button id="markAllBtn" data-url="{{ route('notifikasi.readAll') }}" type="button"
                    style="background: #ffffff; color: #475569; border: 1px solid #e2e8f0; padding: 12px 24px; border-radius: 14px; cursor: pointer; font-weight: 600; font-size: 0.9rem; transition: all 0.2s; display: flex; align-items: center; gap: 10px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);"
                    onmouseover="this.style.background='#f8fafc'; this.style.borderColor='#cbd5e1'" 
                    onmouseout="this.style.background='#ffffff'; this.style.borderColor='#e2e8f0'">
                    <span>Mark all as read</span>
                </button>
            </div>
        @endif
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
        <div style="background: #f0fdf4; color: #166534; padding: 16px 20px; border-radius: 16px; margin-bottom: 30px; border: 1px solid #bbf7d0; display: flex; align-items: center; gap: 12px; font-weight: 500;">
            <span style="background: #22c55e; color: white; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem;">✓</span>
            {{ session('success') }}
        </div>
    @endif

    {{-- Notification List --}}
    <div style="display: flex; flex-direction: column; gap: 14px;">
        @forelse($notifikasi as $item)
            @php 
                $isUnread = $item->status_baca == 'belum';
                $judul = strtolower($item->judul);
                
                // Logika Penentuan Ikon & Warna Berdasarkan Kategori
                if (str_contains($judul, 'pesanan') || str_contains($judul, 'bayar')) {
                    $icon = '📦'; $bgColor = '#eff6ff'; $iconColor = '#3b82f6'; // Biru (Transaksi)
                } elseif (str_contains($judul, 'promo') || str_contains($judul, 'diskon')) {
                    $icon = '🎉'; $bgColor = '#fef2f2'; $iconColor = '#ef4444'; // Merah (Promo)
                } elseif (str_contains($judul, 'akun') || str_contains($judul, 'password')) {
                    $icon = '👤'; $bgColor = '#f0fdf4'; $iconColor = '#22c55e'; // Hijau (Akun)
                } else {
                    $icon = '🔔'; $bgColor = '#f5f3ff'; $iconColor = '#8b5cf6'; // Ungu (Umum)
                }
            @endphp
            
            <div style="
                background: {{ $isUnread ? '#ffffff' : '#f8fafc' }};
                border: 1px solid {{ $isUnread ? '#e2e8f0' : '#f1f5f9' }};
                border-radius: 20px;
                padding: 24px;
                display: flex;
                gap: 20px;
                align-items: center;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: {{ $isUnread ? '0 10px 25px -5px rgba(0,0,0,0.05)' : 'none' }};
                position: relative;
            "
            onmouseover="this.style.borderColor='#cbd5e1'; this.style.transform='translateX(4px)';"
            onmouseout="this.style.borderColor='{{ $isUnread ? '#e2e8f0' : '#f1f5f9' }}'; this.style.transform='translateX(0)';">

                {{-- Indikator Titik (Floating) --}}
                @if($isUnread)
                    <div style="position: absolute; left: -6px; top: 50%; transform: translateY(-50%); width: 12px; height: 12px; background: #8b5cf6; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 10px rgba(139, 92, 246, 0.4);"></div>
                @endif

                {{-- Ikon Dinamis --}}
                <div style="
                    width: 60px; height: 60px; border-radius: 18px; 
                    background: {{ $isUnread ? $bgColor : '#f1f5f9' }}; 
                    display: flex; align-items: center; justify-content: center; font-size: 1.6rem; flex-shrink: 0;
                    transition: all 0.3s;
                ">
                    {{ $icon }}
                </div>

                <div style="flex: 1;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px;">
                        <h3 style="margin: 0; font-size: 1.15rem; color: {{ $isUnread ? '#1e293b' : '#64748b' }}; font-weight: {{ $isUnread ? '750' : '600' }};">
                            {{ $item->judul }}
                        </h3>
                        <span style="font-size: 0.8rem; color: #94a3b8; font-weight: 500; letter-spacing: 0.02em;">
                            {{ strtoupper(\Carbon\Carbon::parse($item->waktu_kirim)->diffForHumans()) }}
                        </span>
                    </div>

                    <p style="margin: 0; line-height: 1.5; color: {{ $isUnread ? '#475569' : '#94a3b8' }}; font-size: 0.95rem; max-width: 90%;">
                        {{ $item->pesan }}
                    </p>
                </div>

                {{-- Tombol Aksi --}}
                @if($isUnread)
                    <button class="mark-read-btn" data-url="{{ route('notifikasi.read', $item->id_notifikasi) }}" data-id="{{ $item->id_notifikasi }}" type="button" style="
                        background: transparent; color: #8b5cf6; border: 2px solid #f5f3ff; 
                        width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
                        cursor: pointer; transition: all 0.2s; font-size: 1.1rem;
                    " title="Tandai sudah dibaca"
                    onmouseover="this.style.background='#8b5cf6'; this.style.color='white'; this.style.borderColor='#8b5cf6';" 
                    onmouseout="this.style.background='transparent'; this.style.color='#8b5cf6'; this.style.borderColor='#f5f3ff';">
                        ✓
                    </button>
                @endif
            </div>
        @empty
            <div style="text-align: center; padding: 120px 0;">
                <div style="font-size: 5rem; margin-bottom: 25px; filter: grayscale(1) opacity(0.3);">🏜️</div>
                <h2 style="font-weight: 800; color: #1e293b; margin-bottom: 8px;">Semua sudah beres!</h2>
                <p style="color: #64748b; font-size: 1.1rem;">Tidak ada notifikasi baru yang memerlukan perhatian Anda.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

    @section('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        function updateBadge(delta) {
            const badge = document.getElementById('notifBadge');
            if (!badge) return;
            let val = parseInt(badge.textContent || '0', 10);
            val = Math.max(0, val - delta);
            if (val === 0) {
                badge.remove();
            } else {
                badge.textContent = val;
            }
        }

        document.querySelectorAll('.mark-read-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const url = this.dataset.url;
                fetch(url, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                }).then(res => {
                    if (!res.ok) throw new Error('Network error');
                    return res.json().catch(() => ({}));
                }).then(data => {
                    // update UI
                    const card = btn.closest('div[style]');
                    if (card) {
                        card.style.background = '#f8fafc';
                        card.style.borderColor = '#f1f5f9';
                    }
                    const dot = card && card.querySelector('div[style*="position: absolute"]');
                    if (dot) dot.remove();
                    btn.remove();
                    updateBadge(1);
                }).catch(err => console.error(err));
            });
        });

        const markAll = document.getElementById('markAllBtn');
        if (markAll) {
            markAll.addEventListener('click', function () {
                const url = this.dataset.url;
                fetch(url, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                }).then(res => {
                    if (!res.ok) throw new Error('Network error');
                    return res.json().catch(() => ({}));
                }).then(data => {
                    document.querySelectorAll('.mark-read-btn').forEach(b => b.remove());
                    document.querySelectorAll('div[style*="position: absolute"]').forEach(d => d.remove());
                    const badge = document.getElementById('notifBadge'); if (badge) badge.remove();
                }).catch(err => console.error(err));
            });
        }
    });
    </script>
    @endsection