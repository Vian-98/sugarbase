@extends('layouts.app')

@section('title', 'Pembayaran #' . $pesanan->id_pesanan)

@section('content')

<!-- STEP INDICATOR -->
<div style="display: flex; align-items: center; margin-bottom: 32px; gap: 0;">
    <div style="display: flex; align-items: center; gap: 8px;">
        <div style="width: 32px; height: 32px; background: var(--success); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.85em; font-weight: 700;">✓</div>
        <span style="font-size: 0.85em; font-weight: 600; color: var(--success);">Keranjang</span>
    </div>
    <div style="flex: 1; height: 2px; background: var(--success); margin: 0 12px;"></div>
    <div style="display: flex; align-items: center; gap: 8px;">
        <div style="width: 32px; height: 32px; background: #22c55e; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.85em; font-weight: 700;">✓</div>
        <span style="font-size: 0.85em; font-weight: 600; color: #22c55e;">Konfirmasi</span>
    </div>
    <div style="flex: 1; height: 2px; background: #22c55e; margin: 0 12px;"></div>
    <div style="display: flex; align-items: center; gap: 8px;">
        <div style="width: 32px; height: 32px; background: #22c55e; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.85em; font-weight: 700;">3</div>
        <span style="font-size: 0.85em; font-weight: 600; color: #22c55e;">Pembayaran</span>
    </div>
</div>

<!-- FLASH MESSAGES -->
@if(session('success'))
<div style="background: rgba(126,187,152,0.15); border: 1px solid #86efac; color: var(--dark); font-weight: 600; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px;">
    ✅ {{ session('success') }}
</div>
@endif

<div style="display: grid; grid-template-columns: 1fr 320px; gap: 24px; align-items: start;">

    <!-- KIRI: Instruksi Pembayaran -->
    <div>

        @php $metode = $pesanan->pembayaran->metode_pembayaran ?? 'transfer'; @endphp

        {{-- ============================================ --}}
        {{-- TRANSFER BANK --}}
        {{-- ============================================ --}}
        @if($metode === 'transfer')
        <div style="background: var(--surface-strong); border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
            <div style="padding: 20px 24px; border-bottom: 1px solid var(--border); background: var(--surface-muted);">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="font-size: 2em;">🏦</span>
                    <div>
                        <h2 style="margin: 0; font-size: 1.1em; font-weight: 700; color: var(--dark);">Transfer Bank</h2>
                        <p style="margin: 2px 0 0; font-size: 0.85em; color: var(--dark); opacity: 0.85;">Selesaikan pembayaran sebelum 24 jam</p>
                    </div>
                </div>
            </div>

            <div style="padding: 24px;">
                <!-- Rekening Tujuan -->
                <p style="font-size: 0.9em; font-weight: 600; color: var(--text-secondary); margin: 0 0 16px;">Pilih rekening tujuan transfer:</p>

                @php
                $rekenings = [
                    ['bank' => 'BCA', 'no' => '1234567890', 'nama' => 'SugarBase Indonesia', 'warna' => '#0064b0', 'logo' => '🔵'],
                    ['bank' => 'Mandiri', 'no' => '1100009876543', 'nama' => 'SugarBase Indonesia', 'warna' => '#003d79', 'logo' => '🟡'],
                    ['bank' => 'BRI', 'no' => '00890001234567', 'nama' => 'SugarBase Indonesia', 'warna' => '#003087', 'logo' => '🟦'],
                ]
                @endphp

                <div style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 24px;">
                    @foreach($rekenings as $rek)
                    <div style="border: 1px solid var(--border); border-radius: 10px; padding: 16px; display: flex; align-items: center; justify-content: space-between; gap: 16px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <span style="font-size: 1.8em;">{{ $rek['logo'] }}</span>
                            <div>
                                <p style="margin: 0; font-weight: 700; color: var(--dark); font-size: 0.95em;">{{ $rek['bank'] }}</p>
                                <p style="margin: 4px 0 0; font-family: monospace; font-size: 1.05em; color: var(--text-secondary); letter-spacing: 1px;" id="rek-{{ $rek['bank'] }}">{{ $rek['no'] }}</p>
                                <p style="margin: 2px 0 0; font-size: 0.8em; color: var(--text-secondary);">a/n {{ $rek['nama'] }}</p>
                            </div>
                        </div>
                        <button onclick="copyRek('{{ $rek['no'] }}', this)"
                            style="padding: 7px 14px; background: var(--surface-muted); border: 1px solid var(--border); border-radius: 6px; cursor: pointer; font-size: 0.8em; color: var(--dark); font-weight: 600; white-space: nowrap;">
                            📋 Salin
                        </button>
                    </div>
                    @endforeach
                </div>

                <!-- Jumlah Transfer -->
                <div style="background: rgba(126,187,152,0.15); border: 1px solid #86efac; border-radius: 10px; padding: 16px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <p style="margin: 0; font-size: 0.85em; color: var(--text-secondary);">Jumlah yang harus ditransfer</p>
                        <p style="margin: 6px 0 0; font-size: 1.4em; font-weight: 700; color: var(--success);">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                    </div>
                    <button onclick="copyRek('{{ $pesanan->total_harga }}', this)"
                        style="padding: 7px 14px; background: rgba(126,187,152,0.15); border: 1px solid #86efac; border-radius: 6px; cursor: pointer; font-size: 0.8em; color: var(--success); font-weight: 600; white-space: nowrap;">
                        📋 Salin
                    </button>
                </div>

                <!-- Instruksi -->
                <div style="background: rgba(231,200,158,0.15); border: 1px solid #fcd34d; border-radius: 10px; padding: 16px; margin-bottom: 24px;">
                    <p style="margin: 0 0 10px; font-weight: 700; color: var(--dark); font-size: 0.9em;">⚠️ Perhatian:</p>
                    <ol style="margin: 0; padding-left: 18px; font-size: 0.85em; color: var(--dark); line-height: 1.8; font-weight: 500;">
                        <li>Transfer sesuai nominal tepat (termasuk angka unik jika ada)</li>
                        <li>Simpan bukti transfer kamu</li>
                        <li>Klik tombol konfirmasi setelah transfer selesai</li>
                        <li>Pesanan diproses setelah pembayaran diverifikasi</li>
                    </ol>
                </div>

                <form action="/pembayaran/{{ $pesanan->id_pesanan }}/konfirmasi" method="POST">
                    @csrf
                    <button type="submit"
                        style="width: 100%; padding: 14px; background: linear-gradient(135deg, #789DBC 0%, #688CAD 100%); color: white; border: none; border-radius: 8px; font-size: 1.05em; font-weight: 700; cursor: pointer; box-shadow: 0 4px 12px rgba(120, 157, 188, 0.4);">
                        ✅ Saya Sudah Transfer
                    </button>
                </form>
            </div>
        </div>


        {{-- ============================================ --}}
        {{-- COD --}}
        {{-- ============================================ --}}
        @elseif($metode === 'cod')
        <div style="background: var(--surface-strong); border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
            <div style="padding: 20px 24px; border-bottom: 1px solid var(--border); background: var(--surface-muted);">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="font-size: 2em;">🚚</span>
                    <div>
                        <h2 style="margin: 0; font-size: 1.1em; font-weight: 700; color: var(--dark);">COD — Bayar di Tempat</h2>
                        <p style="margin: 2px 0 0; font-size: 0.85em; color: var(--dark); opacity: 0.85;">Tidak perlu bayar sekarang!</p>
                    </div>
                </div>
            </div>

            <div style="padding: 24px; text-align: center;">
                <div style="font-size: 5em; margin: 20px 0;">🛵</div>
                <h3 style="font-size: 1.3em; color: var(--dark); margin: 0 0 12px;">Pesanan Sedang Diproses!</h3>
                <p style="color: var(--text-secondary); font-size: 0.95em; line-height: 1.7; margin-bottom: 24px;">
                    Pesananmu sedang dipersiapkan. Kurir kami akan segera mengantar ke alamatmu.<br>
                    <strong>Siapkan uang tunai</strong> sebesar <strong style="color: #789DBC;">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong> saat barang tiba.
                </p>

                <div style="background: rgba(126,187,152,0.15); border: 1px solid #86efac; border-radius: 10px; padding: 20px; margin-bottom: 24px; text-align: left;">
                    <p style="margin: 0 0 8px; font-weight: 600; color: var(--success); font-size: 0.9em;">📋 Yang perlu kamu lakukan:</p>
                    <ul style="margin: 0; padding-left: 18px; font-size: 0.85em; color: var(--text-secondary); line-height: 2;">
                        <li>Pastikan ada di rumah saat kurir datang</li>
                        <li>Siapkan uang pas jika memungkinkan</li>
                        <li>Cek kondisi produk sebelum membayar</li>
                        <li>Simpan struk pembayaran dari kurir</li>
                    </ul>
                </div>

                <a href="/pesanan/saya"
                    style="display: inline-block; padding: 13px 32px; background: linear-gradient(135deg, #789DBC 0%, #688CAD 100%); color: white; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 1em; box-shadow: 0 4px 12px rgba(120, 157, 188, 0.4);">
                    📦 Pantau Status Pesanan
                </a>
            </div>
        </div>


        {{-- ============================================ --}}
        {{-- E-WALLET / QRIS --}}
        {{-- ============================================ --}}
        @else
        <div style="background: var(--surface-strong); border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 2px 10px rgba(0,0,0,0.05); overflow: hidden;">
            <div style="padding: 20px 24px; border-bottom: 1px solid var(--border); background: var(--surface-muted);">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="font-size: 2em;">📱</span>
                    <div>
                        <h2 style="margin: 0; font-size: 1.1em; font-weight: 700; color: var(--dark);">E-Wallet / QRIS</h2>
                        <p style="margin: 2px 0 0; font-size: 0.85em; color: var(--dark); opacity: 0.85;">Scan & bayar dalam hitungan detik</p>
                    </div>
                </div>
            </div>

            <div style="padding: 24px;">

                <!-- Tab E-Wallet Pilihan -->
                <div style="display: flex; gap: 8px; margin-bottom: 24px; flex-wrap: wrap;">
                    @foreach([['id'=>'qris','label'=>'QRIS','emoji'=>'⬛'],['id'=>'gopay','label'=>'GoPay','emoji'=>'💚'],['id'=>'ovo','label'=>'OVO','emoji'=>'💜'],['id'=>'dana','label'=>'DANA','emoji'=>'💙']] as $ew)
                    <button onclick="pilihEwallet('{{ $ew['id'] }}')" id="tab-{{ $ew['id'] }}"
                        style="padding: 8px 16px; border: 1px solid rgba(120,157,188,0.15); border-radius: 8px; cursor: pointer; font-size: 0.85em; font-weight: 600; background: var(--surface-strong); color: var(--text-secondary); transition: all 0.2s; display: flex; align-items: center; gap: 6px;">
                        {{ $ew['emoji'] }} {{ $ew['label'] }}
                    </button>
                    @endforeach
                </div>

                <!-- QRIS QR Code -->
                <div id="panel-qris" class="ewallet-panel" style="text-align: center;">
                    <p style="font-size: 0.9em; color: var(--text-secondary); margin-bottom: 16px;">Scan QR Code di bawah menggunakan aplikasi apapun yang mendukung QRIS</p>

                    <!-- QR Code Visual -->
                    <div style="display: inline-block; padding: 20px; background: var(--surface-strong); border: 3px solid #1f2937; border-radius: 12px; margin-bottom: 16px; position: relative;">
                        <!-- SVG QRIS Simulasi -->
                        <svg width="200" height="200" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                            <!-- Outer corners -->
                            <rect x="10" y="10" width="50" height="50" rx="4" fill="none" stroke="#1f2937" stroke-width="8"/>
                            <rect x="18" y="18" width="34" height="34" fill="#1f2937" rx="2"/>
                            <rect x="140" y="10" width="50" height="50" rx="4" fill="none" stroke="#1f2937" stroke-width="8"/>
                            <rect x="148" y="18" width="34" height="34" fill="#1f2937" rx="2"/>
                            <rect x="10" y="140" width="50" height="50" rx="4" fill="none" stroke="#1f2937" stroke-width="8"/>
                            <rect x="18" y="148" width="34" height="34" fill="#1f2937" rx="2"/>
                            <!-- Data modules (random-ish pattern) -->
                            <rect x="72" y="10" width="8" height="8" fill="#1f2937"/><rect x="82" y="10" width="8" height="8" fill="#1f2937"/><rect x="100" y="10" width="8" height="8" fill="#1f2937"/>
                            <rect x="120" y="10" width="8" height="8" fill="#1f2937"/><rect x="72" y="20" width="8" height="8" fill="#1f2937"/>
                            <rect x="92" y="20" width="8" height="8" fill="#1f2937"/><rect x="110" y="20" width="8" height="8" fill="#1f2937"/>
                            <rect x="130" y="20" width="8" height="8" fill="#1f2937"/><rect x="72" y="30" width="8" height="8" fill="#1f2937"/>
                            <rect x="82" y="30" width="8" height="8" fill="#1f2937"/><rect x="102" y="30" width="8" height="8" fill="#1f2937"/>
                            <rect x="120" y="30" width="8" height="8" fill="#1f2937"/><rect x="72" y="50" width="8" height="8" fill="#1f2937"/>
                            <rect x="92" y="50" width="8" height="8" fill="#1f2937"/><rect x="72" y="60" width="8" height="8" fill="#1f2937"/>
                            <rect x="82" y="60" width="8" height="8" fill="#1f2937"/><rect x="100" y="60" width="8" height="8" fill="#1f2937"/>
                            <rect x="120" y="60" width="8" height="8" fill="#1f2937"/><rect x="130" y="60" width="8" height="8" fill="#1f2937"/>
                            <rect x="10" y="72" width="8" height="8" fill="#1f2937"/><rect x="30" y="72" width="8" height="8" fill="#1f2937"/>
                            <rect x="50" y="72" width="8" height="8" fill="#1f2937"/><rect x="70" y="72" width="8" height="8" fill="#1f2937"/>
                            <rect x="90" y="72" width="8" height="8" fill="#1f2937"/><rect x="110" y="72" width="8" height="8" fill="#1f2937"/>
                            <rect x="140" y="72" width="8" height="8" fill="#1f2937"/><rect x="160" y="72" width="8" height="8" fill="#1f2937"/>
                            <rect x="180" y="72" width="8" height="8" fill="#1f2937"/><rect x="10" y="82" width="8" height="8" fill="#1f2937"/>
                            <rect x="40" y="82" width="8" height="8" fill="#1f2937"/><rect x="60" y="82" width="8" height="8" fill="#1f2937"/>
                            <rect x="80" y="82" width="8" height="8" fill="#1f2937"/><rect x="100" y="82" width="8" height="8" fill="#1f2937"/>
                            <rect x="130" y="82" width="8" height="8" fill="#1f2937"/><rect x="150" y="82" width="8" height="8" fill="#1f2937"/>
                            <rect x="170" y="82" width="8" height="8" fill="#1f2937"/><rect x="10" y="92" width="8" height="8" fill="#1f2937"/>
                            <rect x="20" y="92" width="8" height="8" fill="#1f2937"/><rect x="50" y="92" width="8" height="8" fill="#1f2937"/>
                            <rect x="70" y="92" width="8" height="8" fill="#1f2937"/><rect x="90" y="92" width="8" height="8" fill="#1f2937"/>
                            <rect x="120" y="92" width="8" height="8" fill="#1f2937"/><rect x="140" y="92" width="8" height="8" fill="#1f2937"/>
                            <rect x="160" y="92" width="8" height="8" fill="#1f2937"/><rect x="180" y="92" width="8" height="8" fill="#1f2937"/>
                            <!-- Center logo area -->
                            <rect x="85" y="85" width="30" height="30" rx="4" fill="white" stroke="#e5e7eb" stroke-width="1"/>
                            <text x="100" y="106" text-anchor="middle" font-size="18">🍰</text>
                            <!-- More data -->
                            <rect x="10" y="110" width="8" height="8" fill="#1f2937"/><rect x="30" y="110" width="8" height="8" fill="#1f2937"/>
                            <rect x="60" y="110" width="8" height="8" fill="#1f2937"/><rect x="80" y="110" width="8" height="8" fill="#1f2937"/>
                            <rect x="130" y="110" width="8" height="8" fill="#1f2937"/><rect x="150" y="110" width="8" height="8" fill="#1f2937"/>
                            <rect x="170" y="110" width="8" height="8" fill="#1f2937"/><rect x="10" y="120" width="8" height="8" fill="#1f2937"/>
                            <rect x="40" y="120" width="8" height="8" fill="#1f2937"/><rect x="70" y="120" width="8" height="8" fill="#1f2937"/>
                            <rect x="100" y="120" width="8" height="8" fill="#1f2937"/><rect x="120" y="120" width="8" height="8" fill="#1f2937"/>
                            <rect x="140" y="120" width="8" height="8" fill="#1f2937"/><rect x="180" y="120" width="8" height="8" fill="#1f2937"/>
                            <rect x="72" y="140" width="8" height="8" fill="#1f2937"/><rect x="82" y="140" width="8" height="8" fill="#1f2937"/>
                            <rect x="100" y="140" width="8" height="8" fill="#1f2937"/><rect x="120" y="140" width="8" height="8" fill="#1f2937"/>
                            <rect x="72" y="150" width="8" height="8" fill="#1f2937"/><rect x="92" y="150" width="8" height="8" fill="#1f2937"/>
                            <rect x="110" y="150" width="8" height="8" fill="#1f2937"/><rect x="130" y="150" width="8" height="8" fill="#1f2937"/>
                            <rect x="72" y="160" width="8" height="8" fill="#1f2937"/><rect x="100" y="160" width="8" height="8" fill="#1f2937"/>
                            <rect x="120" y="160" width="8" height="8" fill="#1f2937"/><rect x="72" y="170" width="8" height="8" fill="#1f2937"/>
                            <rect x="82" y="170" width="8" height="8" fill="#1f2937"/><rect x="110" y="170" width="8" height="8" fill="#1f2937"/>
                            <rect x="130" y="170" width="8" height="8" fill="#1f2937"/><rect x="72" y="180" width="8" height="8" fill="#1f2937"/>
                            <rect x="100" y="180" width="8" height="8" fill="#1f2937"/><rect x="120" y="180" width="8" height="8" fill="#1f2937"/>
                        </svg>
                        <!-- QRIS label -->
                        <div style="position: absolute; bottom: -1px; left: 50%; transform: translateX(-50%); background: #ef4444; color: white; padding: 2px 10px; border-radius: 0 0 6px 6px; font-size: 0.7em; font-weight: 700; letter-spacing: 2px; white-space: nowrap;">QRIS</div>
                    </div>

                    <div style="background: rgba(217,137,153,0.15); border: 1px solid #e9d5ff; border-radius: 10px; padding: 16px; margin-bottom: 20px; display: inline-block; min-width: 260px;">
                        <p style="margin: 0 0 4px; font-size: 0.8em; color: var(--text-secondary);">Total Pembayaran</p>
                        <p style="margin: 0; font-size: 1.5em; font-weight: 700; color: #6b21a8;">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                        <p style="margin: 6px 0 0; font-size: 0.75em; color: var(--text-secondary);">a/n SugarBase Indonesia</p>
                    </div>

                    <p style="font-size: 0.8em; color: var(--text-secondary); margin-bottom: 20px;">
                        Buka aplikasi e-wallet atau bank kamu → Pilih Scan QR / QRIS → Scan kode di atas → Konfirmasi
                    </p>
                </div>

                <!-- GoPay Panel -->
                <div id="panel-gopay" class="ewallet-panel" style="display: none; text-align: center;">
                    <div style="font-size: 4em; margin: 20px 0 12px;">💚</div>
                    <h3 style="font-size: 1.1em; color: var(--dark); margin: 0 0 8px;">GoPay</h3>
                    <p style="color: var(--text-secondary); font-size: 0.9em; margin-bottom: 16px;">Nomor GoPay tujuan:</p>
                    <div style="background: rgba(126,187,152,0.15); border: 1px solid #86efac; border-radius: 10px; padding: 16px; display: inline-block; margin-bottom: 20px;">
                        <p style="margin: 0; font-family: monospace; font-size: 1.4em; font-weight: 700; color: var(--success); letter-spacing: 2px;">0812-3456-7890</p>
                        <p style="margin: 6px 0 0; font-size: 0.8em; color: var(--text-secondary);">a/n SugarBase</p>
                    </div>
                    <p style="font-size: 1.2em; font-weight: 700; color: #789DBC; margin-bottom: 20px;">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                </div>

                <!-- OVO Panel -->
                <div id="panel-ovo" class="ewallet-panel" style="display: none; text-align: center;">
                    <div style="font-size: 4em; margin: 20px 0 12px;">💜</div>
                    <h3 style="font-size: 1.1em; color: var(--dark); margin: 0 0 8px;">OVO</h3>
                    <p style="color: var(--text-secondary); font-size: 0.9em; margin-bottom: 16px;">Nomor OVO tujuan:</p>
                    <div style="background: rgba(217,137,153,0.15); border: 1px solid #e9d5ff; border-radius: 10px; padding: 16px; display: inline-block; margin-bottom: 20px;">
                        <p style="margin: 0; font-family: monospace; font-size: 1.4em; font-weight: 700; color: var(--danger); letter-spacing: 2px;">0813-9876-5432</p>
                        <p style="margin: 6px 0 0; font-size: 0.8em; color: var(--text-secondary);">a/n SugarBase</p>
                    </div>
                    <p style="font-size: 1.2em; font-weight: 700; color: #789DBC; margin-bottom: 20px;">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                </div>

                <!-- DANA Panel -->
                <div id="panel-dana" class="ewallet-panel" style="display: none; text-align: center;">
                    <div style="font-size: 4em; margin: 20px 0 12px;">💙</div>
                    <h3 style="font-size: 1.1em; color: var(--dark); margin: 0 0 8px;">DANA</h3>
                    <p style="color: var(--text-secondary); font-size: 0.9em; margin-bottom: 16px;">Nomor DANA tujuan:</p>
                    <div style="background: rgba(120,157,188,0.15); border: 1px solid #bfdbfe; border-radius: 10px; padding: 16px; display: inline-block; margin-bottom: 20px;">
                        <p style="margin: 0; font-family: monospace; font-size: 1.4em; font-weight: 700; color: var(--primary); letter-spacing: 2px;">0821-1122-3344</p>
                        <p style="margin: 6px 0 0; font-size: 0.8em; color: var(--text-secondary);">a/n SugarBase</p>
                    </div>
                    <p style="font-size: 1.2em; font-weight: 700; color: #789DBC; margin-bottom: 20px;">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                </div>

                <!-- Tombol Konfirmasi -->
                <form action="/pembayaran/{{ $pesanan->id_pesanan }}/konfirmasi" method="POST" style="margin-top: 4px;">
                    @csrf
                    <button type="submit"
                        style="width: 100%; padding: 14px; background: linear-gradient(135deg, #789DBC 0%, #688CAD 100%); color: white; border: none; border-radius: 8px; font-size: 1.05em; font-weight: 700; cursor: pointer; box-shadow: 0 4px 12px rgba(120, 157, 188, 0.4);">
                        ✅ Konfirmasi Pembayaran
                    </button>
                </form>
            </div>
        </div>
        @endif

    </div>

    <!-- KANAN: Detail Pesanan -->
    <div style="position: sticky; top: 20px; display: flex; flex-direction: column; gap: 16px;">

        <!-- Info Pesanan -->
        <div style="background: var(--surface-strong); border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 20px;">
            <h3 style="margin: 0 0 16px; font-size: 1.1em; font-weight: 700; color: var(--dark); border-bottom: 1px solid var(--border); padding-bottom: 12px;">📄 Detail Pesanan</h3>

            <div style="display: flex; justify-content: space-between; font-size: 0.85em; margin-bottom: 8px; color: var(--text-secondary);">
                <span>No. Pesanan</span>
                <span style="font-weight: 600; color: var(--dark);">#{{ $pesanan->id_pesanan }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 0.85em; margin-bottom: 8px; color: var(--text-secondary);">
                <span>Tanggal</span>
                <span style="font-weight: 600; color: var(--dark);">{{ \Carbon\Carbon::parse($pesanan->tanggal_pesan)->format('d M Y') }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 0.85em; margin-bottom: 8px; color: var(--text-secondary);">
                <span>Status</span>
                <span style="background: rgba(231,200,158,0.15); color: var(--dark); padding: 2px 10px; border-radius: 20px; font-size: 0.9em; font-weight: 700; border: 1px solid #fcd34d;">
                    {{ ucfirst($pesanan->status_pesanan) }}
                </span>
            </div>
            <div style="display: flex; justify-content: space-between; font-size: 0.85em; margin-bottom: 8px; color: var(--text-secondary);">
                <span>Metode</span>
                <span style="font-weight: 600; color: var(--dark); text-transform: capitalize;">{{ $metode }}</span>
            </div>

            <div style="border-top: 1px solid var(--border); padding-top: 12px; margin-top: 4px; display: flex; justify-content: space-between; font-size: 1em; font-weight: 700; color: var(--dark);">
                <span>Total</span>
                <span style="color: #789DBC;">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Status Pembayaran -->
        <div style="background: var(--surface-strong); border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 20px;">
            <h3 style="margin: 0 0 14px; font-size: 1.1em; font-weight: 700; color: var(--dark);">Status Pembayaran</h3>
            @php $sp = $pesanan->pembayaran->status_pembayaran ?? 'menunggu'; @endphp
            @if($sp === 'lunas')
            <div style="display: flex; align-items: center; gap: 10px; padding: 12px; background: rgba(126,187,152,0.15); border-radius: 8px; border: 1px solid #86efac;">
                <span style="font-size: 1.5em;">✅</span>
                <div>
                    <p style="margin: 0; font-weight: 600; color: var(--success); font-size: 0.9em;">Lunas</p>
                    <p style="margin: 2px 0 0; font-size: 0.78em; color: var(--text-secondary);">Pembayaran terkonfirmasi</p>
                </div>
            </div>
            @else
            <div style="display: flex; align-items: center; gap: 10px; padding: 12px; background: rgba(231,200,158,0.15); border-radius: 8px; border: 1px solid #fcd34d;">
                <span style="font-size: 1.5em;">⏳</span>
                <div>
                    <p style="margin: 0; font-weight: 700; color: var(--dark); font-size: 0.9em;">Menunggu Pembayaran</p>
                    <p style="margin: 2px 0 0; font-size: 0.78em; color: var(--dark); font-weight: 500;">Selesaikan pembayaranmu</p>
                </div>
            </div>
            @endif
        </div>

        <a href="/pesanan/saya"
            style="display: block; padding: 12px; background: var(--surface-muted); color: var(--dark); text-align: center; border-radius: 8px; text-decoration: none; font-size: 0.95em; font-weight: 600; border: 1px solid var(--border);">
            📦 Lihat Semua Pesanan
        </a>
    </div>

</div>

<script>
function copyRek(text, btn) {
    const onSuccess = () => {
        const orig = btn.textContent;
        btn.textContent = '✅ Disalin!';
        btn.style.color = '#16a34a';
        setTimeout(() => { btn.textContent = orig; btn.style.color = ''; }, 2000);
    };

    if (!navigator.clipboard) {
        // Fallback untuk non-HTTPS (seperti IP address lokal)
        const textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.position = "fixed";
        textArea.style.top = "0";
        textArea.style.left = "0";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            if (document.execCommand('copy')) onSuccess();
        } catch (err) {
            console.error('Gagal menyalin', err);
        }
        document.body.removeChild(textArea);
        return;
    }

    navigator.clipboard.writeText(text).then(onSuccess);
}

function pilihEwallet(id) {
    document.querySelectorAll('.ewallet-panel').forEach(p => p.style.display = 'none');
    document.getElementById('panel-' + id).style.display = 'block';
    document.querySelectorAll('[id^="tab-"]').forEach(t => {
        t.style.borderColor = 'var(--border)';
        t.style.background = 'var(--surface-strong)';
        t.style.color = 'var(--text-secondary)';
    });
    const tab = document.getElementById('tab-' + id);
    tab.style.borderColor = '#789DBC';
    tab.style.background = 'rgba(120,157,188,0.15)';
    tab.style.color = 'var(--primary)';
}

// Default: pilih QRIS (hanya jika fungsi ada dan elemen tersedia)
if (typeof pilihEwallet === 'function' && document.getElementById('panel-qris')) {
    pilihEwallet('qris');
}
</script>

<style>
@media (max-width: 900px) {
    div[style*="grid-template-columns: 1fr 320px"] { grid-template-columns: 1fr !important; }
}
</style>

@endsection