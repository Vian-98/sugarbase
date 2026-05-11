@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')

@section('page_title')
    <h1>📋 Manajemen Pesanan</h1>
    <p>Kelola pesanan masuk dan pantau status pengiriman secara efisien.</p>
@endsection

@section('content')
<div class="container-fluid p-0">
    
    {{-- Top Stats Area --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <div style="background: white; padding: 25px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border-left: 5px solid #ef4444;">
            <p style="color: #94a3b8; font-size: 0.85rem; font-weight: 600; text-transform: uppercase; margin-bottom: 8px;">Revenue Hari Ini</p>
            <h3 style="color: #1e293b; font-size: 1.6rem; font-weight: 700; margin: 0;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
        </div>
        <!-- Tambahkan stat lain di sini jika perlu -->
    </div>

    {{-- Table Container --}}
    <div style="background: white; border-radius: 16px; box-shadow: 0 4px 25px rgba(0,0,0,0.05); overflow: hidden;">
        
        {{-- Header & Filter --}}
        <div style="padding: 20px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
            <div style="display: flex; gap: 8px;">
                @foreach(['Semua','pending','diproses','dikirim','selesai','dibatalkan'] as $tab)
                    <a href="?status={{ $tab }}" 
                       style="text-decoration: none; padding: 8px 16px; border-radius: 10px; font-size: 0.9rem; transition: all 0.2s; 
                       {{ request('status', 'Semua') === $tab ? 'background: #667eea; color: white; box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);' : 'color: #64748b; background: #f8fafc;' }}">
                        {{ ucfirst($tab) }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0" style="min-width: 1000px;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th style="padding: 18px 24px; color: #64748b; font-weight: 600; font-size: 0.85rem; border: none;">PESANAN</th>
                        <th style="padding: 18px 24px; color: #64748b; font-weight: 600; font-size: 0.85rem; border: none;">PELANGGAN</th>
                        <th style="padding: 18px 24px; color: #64748b; font-weight: 600; font-size: 0.85rem; border: none;">TOTAL BAYAR</th>
                        <th style="padding: 18px 24px; color: #64748b; font-weight: 600; font-size: 0.85rem; border: none;">PEMBAYARAN</th>
                        <th style="padding: 18px 24px; color: #64748b; font-weight: 600; font-size: 0.85rem; border: none;">STATUS</th>
                        <th style="padding: 18px 24px; color: #64748b; font-weight: 600; font-size: 0.85rem; border: none; text-align: center;">AKSI</th>
                    </tr>
                </thead>
                <tbody style="border-top: 1px solid #f1f5f9;">
                    @forelse($pesanan as $p)
                    <tr style="transition: background 0.2s; cursor: default;">
                        {{-- ID Column (Dibuat lebih bergaya) --}}
                        <td style="padding: 18px 24px;">
                            <span style="display: block; font-weight: 700; color: #1e293b; margin-bottom: 2px;">#ORD-{{ str_pad($p->id_pesanan, 4, '0', STR_PAD_LEFT) }}</span>
                            <small style="color: #94a3b8;">{{ \Carbon\Carbon::parse($p->tanggal_pesan)->format('d M, H:i') }}</small>
                        </td>
                        
                        {{-- Pelanggan --}}
                        <td style="padding: 18px 24px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 35px; height: 35px; background: #e2e8f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; color: #64748b;">
                                    {{ strtoupper(substr($p->user->name ?? 'G', 0, 1)) }}
                                </div>
                                <div>
                                    <span style="display: block; font-weight: 600; color: #334155;">{{ $p->user->name ?? 'Guest' }}</span>
                                    <small style="color: #94a3b8;">{{ $p->user->email ?? 'no-email@mail.com' }}</small>
                                </div>
                            </div>
                        </td>

                        {{-- Harga --}}
                        <td style="padding: 18px 24px;">
                            <span style="font-weight: 700; color: #10b981;">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</span>
                        </td>

                        {{-- Status Bayar --}}
                        <td style="padding: 18px 24px;">
                            @php $sp = $p->pembayaran->status_pembayaran ?? 'menunggu' @endphp
                            <span style="padding: 6px 12px; border-radius: 8px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; 
                                {{ $sp === 'lunas' ? 'background: #ecfdf5; color: #10b981;' : ($sp === 'gagal' ? 'background: #fef2f2; color: #ef4444;' : 'background: #fffbeb; color: #f59e0b;') }}">
                                {{ $sp }}
                            </span>
                        </td>

                        {{-- Status Pesanan --}}
                        <td style="padding: 18px 24px;">
                            @php
                                $statusStyles = match($p->status_pesanan) {
                                    'pending'    => ['bg' => '#fef3c7', 'text' => '#d97706'],
                                    'diproses'   => ['bg' => '#dbeafe', 'text' => '#2563eb'],
                                    'dikirim'    => ['bg' => '#f3e8ff', 'text' => '#9333ea'],
                                    'selesai'    => ['bg' => '#d1fae5', 'text' => '#059669'],
                                    'dibatalkan' => ['bg' => '#fee2e2', 'text' => '#dc2626'],
                                    default      => ['bg' => '#f1f5f9', 'text' => '#475569'],
                                };
                            @endphp
                            <span style="padding: 6px 12px; border-radius: 8px; font-size: 0.8rem; font-weight: 600; background: {{ $statusStyles['bg'] }}; color: {{ $statusStyles['text'] }};">
                                {{ ucfirst($p->status_pesanan) }}
                            </span>
                        </td>

                        {{-- Action --}}
                        <td style="padding: 18px 24px; text-align: center;">
                            <form method="POST" action="/admin/pesanan/{{ $p->id_pesanan }}/status" class="d-flex gap-2 justify-content-center">
                                @csrf
                                <select name="status" style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 5px 10px; font-size: 0.85rem; color: #475569; outline: none;">
                                    @foreach(['pending','diproses','dikirim','selesai','dibatalkan'] as $s)
                                        <option value="{{ $s }}" {{ $p->status_pesanan === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" style="background: #667eea; color: white; border: none; padding: 6px 12px; border-radius: 8px; font-size: 0.85rem; font-weight: 600; transition: 0.3s;">
                                    Update
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding: 50px; text-align: center; color: #94a3b8;">
                            <div style="font-size: 40px; margin-bottom: 10px;">📦</div>
                            <p>Belum ada pesanan masuk.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    tr:hover { background-color: #f8fafc; }
    button:hover { background: #5a67d8 !important; transform: translateY(-1px); }
</style>
@endsection