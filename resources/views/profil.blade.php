@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')

<section>
    <div style="display:flex;gap:24px;align-items:flex-start;">
        <div style="flex:1;">
            <div style="background: var(--surface-strong);padding:20px;border-radius:12px;border:1px solid var(--border);box-shadow:0 6px 18px rgba(99,102,241,0.06);">
                <div style="display:flex;gap:16px;align-items:center;margin-bottom:12px;">
                    <div style="width:72px;height:72px;border-radius:12px;background:linear-gradient(135deg,var(--primary),var(--secondary));display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:1.2em;">{{ substr($user->name ?? 'U',0,1) }}</div>
                    <div>
                        <h2 style="margin:0;font-size:1.2em;">{{ $user->name ?? 'Pengguna' }}</h2>
                        <div style="color: var(--text-secondary);font-size:0.95em;">{{ $user->email }}</div>
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:8px;">
                    <div>
                        <div style="color: var(--text-secondary);font-size:0.85em;">No. Telepon</div>
                        <div style="font-weight:600">{{ $user->phone ?? '-' }}</div>
                    </div>
                    <div>
                        <div style="color: var(--text-secondary);font-size:0.85em;">Terdaftar</div>
                        <div style="font-weight:600">{{ optional($user->created_at)->format('d M Y') ?? '-' }}</div>
                    </div>
                </div>

                <div style="margin-top:12px;">
                    <div style="color: var(--text-secondary);font-size:0.85em;">Alamat</div>
                    <div style="font-weight:600">{{ $user->alamat ?? '-' }}</div>
                </div>

                <div style="margin-top:16px;display:flex;gap:10px;">
                    <a href="{{ route('profil.edit') }}" style="background:var(--primary);color:white;padding:10px 14px;border-radius:8px;text-decoration:none;">✏️ Edit Profil</a>
                    <a href="{{ route('pesanan.saya') }}" style="background:var(--light);color:var(--dark);padding:10px 14px;border-radius:8px;text-decoration:none;">📋 Riwayat Pesanan</a>
                </div>
            </div>
        </div>

        <div style="width:320px;">
            <div style="background: var(--surface-strong);padding:16px;border-radius:12px;border:1px solid var(--border);">
                <h3 style="margin:0 0 8px 0;font-size:1em;">Preferensi & Info</h3>
                <p style="color: var(--text-secondary);font-size:0.95em;">Kelola data kontakmu, lihat notifikasi, dan periksa status pesanan dari panel ini.</p>
                <ul style="margin-top:8px;list-style:none;padding:0;color: var(--text-secondary);font-size:0.95em;">
                    <li>🔔 Notifikasi: {{ $unreadCount ?? 0 }}</li>
                    <li>🛒 Keranjang: <a href="/keranjang">Lihat keranjang</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

@endsection
