@extends('layouts.admin')

@section('breadcrumb', 'Admin › Manajemen Pelanggan › Detail')

@section('content')

<!-- HEADER WITH BACK BUTTON -->
<div style="display: flex; align-items: center; gap: 16px; margin-bottom: 24px;">
    <a href="{{ route('admin.pelanggan.index') }}" style="display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; background: var(--surface-strong); border: 1px solid var(--border); border-radius: 8px; color: var(--text-secondary); text-decoration: none; font-size: 1.2em;" title="Kembali">
        ←
    </a>
    <div>
        <h1 style="font-size: 1.6em; color: var(--dark); margin: 0; font-weight: 700;">👤 {{ $pelanggan->name }}</h1>
        <p style="color: var(--text-secondary); margin: 4px 0 0 0;">ID Pelanggan: #{{ str_pad($pelanggan->id, 5, '0', STR_PAD_LEFT) }}</p>
    </div>
</div>

<!-- TWO COLUMN LAYOUT -->
<div style="display: grid; grid-template-columns: 1fr 380px; gap: 20px;">
    
    <!-- MAIN CONTENT -->
    <div>
        <!-- INFORMASI PELANGGAN CARD -->
        <div style="background: var(--surface-strong); border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 24px; margin-bottom: 20px;">
            <h2 style="font-size: 0.95em; color: var(--dark); margin: 0 0 16px 0; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">📋 Informasi Pelanggan</h2>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label style="display: block; font-size: 0.75em; color: var(--text-secondary); text-transform: uppercase; font-weight: 600; margin-bottom: 6px; letter-spacing: 0.4px;">Nama Lengkap</label>
                    <p style="margin: 0; color: var(--dark); font-weight: 600;">{{ $pelanggan->name }}</p>
                </div>
                <div>
                    <label style="display: block; font-size: 0.75em; color: var(--text-secondary); text-transform: uppercase; font-weight: 600; margin-bottom: 6px; letter-spacing: 0.4px;">Email</label>
                    <p style="margin: 0; color: var(--dark); font-weight: 600;">
                        <a href="mailto:{{ $pelanggan->email }}" style="color: var(--primary); text-decoration: none;">{{ $pelanggan->email }}</a>
                    </p>
                </div>
                <div>
                    <label style="display: block; font-size: 0.75em; color: var(--text-secondary); text-transform: uppercase; font-weight: 600; margin-bottom: 6px; letter-spacing: 0.4px;">Nomor Telepon</label>
                    <p style="margin: 0; color: var(--dark); font-weight: 600;">{{ $pelanggan->phone ?? '-' }}</p>
                </div>
                <div>
                    <label style="display: block; font-size: 0.75em; color: var(--text-secondary); text-transform: uppercase; font-weight: 600; margin-bottom: 6px; letter-spacing: 0.4px;">Alamat</label>
                    <p style="margin: 0; color: var(--dark); font-weight: 600;">{{ $pelanggan->alamat ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- RIWAYAT PESANAN CARD -->
        <div style="background: var(--surface-strong); border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 24px;">
            <h2 style="font-size: 0.95em; color: var(--dark); margin: 0 0 16px 0; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">📦 Riwayat Pesanan</h2>
            
            @if($pesanan->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.85em;">
                    <thead>
                        <tr style="background: var(--gradient-soft); color: var(--text-secondary); text-transform: uppercase; font-size: 0.75em; letter-spacing: 0.4px;">
                            <th style="padding: 12px 12px; text-align: left; font-weight: 600;">ID Pesanan</th>
                            <th style="padding: 12px 12px; text-align: center; font-weight: 600;">Items</th>
                            <th style="padding: 12px 12px; text-align: right; font-weight: 600;">Total</th>
                            <th style="padding: 12px 12px; text-align: center; font-weight: 600;">Status</th>
                            <th style="padding: 12px 12px; text-align: center; font-weight: 600;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesanan as $p)
                        <tr style="border-top: 1px solid var(--border);">
                            <td style="padding: 12px 12px; font-weight: 700; color: #789DBC;">#{{ str_pad($p->id_pesanan, 5, '0', STR_PAD_LEFT) }}</td>
                            <td style="padding: 12px 12px; text-align: center; color: var(--text-secondary);">
                                {{ $p->items->count() }} item
                            </td>
                            <td style="padding: 12px 12px; text-align: right; font-weight: 700; color: var(--dark);">
                                Rp {{ number_format($p->total_harga, 0, ',', '.') }}
                            </td>
                            <td style="padding: 12px 12px; text-align: center;">
                                @php
                                    $statusColor = match($p->status_pesanan) {
                                        'pending' => '#fee2e2',
                                        'dikirim' => '#fef08a',
                                        'selesai' => '#dcfce7',
                                        default => '#f3f4f6'
                                    };
                                    $statusTextColor = match($p->status_pesanan) {
                                        'pending' => '#991b1b',
                                        'dikirim' => '#854d0e',
                                        'selesai' => '#3A7A5A',
                                        default => '#6b7280'
                                    };
                                @endphp
                                <span style="padding: 4px 10px; background: {{ $statusColor }}; color: {{ $statusTextColor }}; border-radius: 20px; font-size: 0.75em; font-weight: 600; text-transform: capitalize;">
                                    {{ ucfirst($p->status_pesanan) }}
                                </span>
                            </td>
                            <td style="padding: 12px 12px; text-align: center;">
                                <a href="{{ route('admin.pesanan.show', $p->id_pesanan) }}" style="padding: 4px 10px; background: rgba(120,157,188,0.15); color: var(--primary); border-radius: 6px; text-decoration: none; font-size: 0.75em; font-weight: 600;">Lihat</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div style="padding: 40px 20px; text-align: center; color: var(--text-secondary);">
                <div style="font-size: 2.5em; margin-bottom: 10px;">📭</div>
                Pelanggan ini belum memiliki pesanan.
            </div>
            @endif
        </div>
    </div>

    <!-- SIDEBAR -->
    <div>
        <!-- RINGKASAN CARD -->
        <div style="background: var(--surface-strong); border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 20px;">
            <h3 style="font-size: 0.9em; color: var(--dark); margin: 0 0 16px 0; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">📊 Ringkasan</h3>
            
            <div style="background: var(--gradient-soft); border-radius: 8px; padding: 12px; margin-bottom: 16px;">
                <p style="margin: 0; font-size: 0.75em; color: var(--text-secondary); text-transform: uppercase; font-weight: 600; margin-bottom: 6px; letter-spacing: 0.3px;">Total Pesanan</p>
                <p style="margin: 0; font-size: 1.8em; color: #789DBC; font-weight: 700;">{{ $pesanan->count() }}</p>
            </div>

            <div style="background: var(--gradient-soft); border-radius: 8px; padding: 12px; margin-bottom: 16px;">
                <p style="margin: 0; font-size: 0.75em; color: var(--text-secondary); text-transform: uppercase; font-weight: 600; margin-bottom: 6px; letter-spacing: 0.3px;">Total Pengeluaran</p>
                <p style="margin: 0; font-size: 1.5em; color: #7EBB98; font-weight: 700;">
                    Rp {{ number_format($pesanan->sum('total_harga'), 0, ',', '.') }}
                </p>
            </div>

            <div style="background: var(--gradient-soft); border-radius: 8px; padding: 12px;">
                <p style="margin: 0; font-size: 0.75em; color: var(--text-secondary); text-transform: uppercase; font-weight: 600; margin-bottom: 6px; letter-spacing: 0.3px;">Bergabung Sejak</p>
                <p style="margin: 0; font-size: 0.95em; color: var(--dark); font-weight: 600;">
                    {{ $pelanggan->created_at->format('d M Y') }}
                </p>
            </div>
        </div>
    </div>

</div>

@endsection
