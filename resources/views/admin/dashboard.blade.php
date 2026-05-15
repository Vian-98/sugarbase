@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page_title')
    <h1>📊 Dashboard Admin</h1>
    <p>Selamat datang di Sugarbase - Admin Panel</p>
@endsection

@section('content')
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
        
        {{-- Revenue Today --}}
        <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #22c55e;">
            <div style="font-size: 2.5em; margin-bottom: 10px;">💰</div>
            <h3 style="color: #22c55e; font-size: 1.4em; margin: 10px 0; font-weight: 700;">
                @if(isset($revenueToday))
                    Rp {{ number_format($revenueToday, 0, ',', '.') }}
                @else
                    <span style="color: red; font-size: 0.8em;">ERROR: \$revenueToday not set</span>
                @endif
            </h3>
            <p style="color: #6b7280; margin: 0; font-size: 0.9em;">Revenue Hari Ini</p>
        </div>

        {{-- Total Revenue --}}
        <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #667eea;">
            <div style="font-size: 2.5em; margin-bottom: 10px;">📊</div>
            <h3 style="color: #667eea; font-size: 1.4em; margin: 10px 0; font-weight: 700;">
                @if(isset($revenue))
                    Rp {{ number_format($revenue, 0, ',', '.') }}
                @else
                    <span style="color: red; font-size: 0.8em;">ERROR: \$revenue not set</span>
                @endif
            </h3>
            <p style="color: #6b7280; margin: 0; font-size: 0.9em;">Total Revenue</p>
        </div>
        
        {{-- Produk Aktif --}}
        <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #f59e0b;">
            <div style="font-size: 2.5em; margin-bottom: 10px;">📦</div>
            <h3 style="color: #f59e0b; font-size: 1.8em; margin: 10px 0;">{{ $produkAktif }}</h3>
            <p style="color: #6b7280; margin: 0; font-size: 0.9em;">Produk Aktif</p>
        </div>

        {{-- Total Pelanggan --}}
        <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #3b82f6;">
            <div style="font-size: 2.5em; margin-bottom: 10px;">👥</div>
            <h3 style="color: #3b82f6; font-size: 1.8em; margin: 10px 0;">{{ $totalPelanggan }}</h3>
            <p style="color: #6b7280; margin: 0; font-size: 0.9em;">Total Pelanggan</p>
        </div>

        {{-- Total Pesanan --}}
        <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #ec4899;">
            <div style="font-size: 2.5em; margin-bottom: 10px;">🛒</div>
            <h3 style="color: #ec4899; font-size: 1.8em; margin: 10px 0;">{{ $totalPesanan }}</h3>
            <p style="color: #6b7280; margin: 0; font-size: 0.9em;">Total Pesanan</p>
        </div>

        {{-- Total Kategori --}}
        <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #8b5cf6;">
            <div style="font-size: 2.5em; margin-bottom: 10px;">📂</div>
            <h3 style="color: #8b5cf6; font-size: 1.8em; margin: 10px 0;">{{ $totalKategori }}</h3>
            <p style="color: #6b7280; margin: 0; font-size: 0.9em;">Total Kategori</p>
        </div>

    </div>

    <!-- REVENUE TREND CHART -->
    <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 30px;">
        <h2 style="margin: 0 0 20px 0; color: #1f2937;">📈 Trend Pesanan 7 Hari Terakhir</h2>
        <canvas id="orderChart" height="80"></canvas>
    </div>

    <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-top: 20px;">
        <h2 style="margin-bottom: 15px;">📈 Quick Actions</h2>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('admin.produk.index') }}" 
               style="background: #667eea; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; display: inline-block;">
                Kelola Produk
            </a>
            <a href="{{ route('admin.kategori.index') }}" 
               style="background: #764ba2; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; display: inline-block;">
                Kelola Kategori
            </a>
            <a href="{{ route('admin.pesanan.index') }}" 
               style="background: #8b5cf6; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; display: inline-block;">
                Kelola Pesanan
            </a>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- DEBUG SECTION -->
<div style="background: #f3f4f6; padding: 20px; border-radius: 8px; margin-top: 30px; font-family: monospace; font-size: 0.85em; border: 1px solid #d1d5db;">
    <h3 style="margin-top: 0;">🔍 DEBUG INFO</h3>
    <p><strong>Revenue Today:</strong> {{ isset($revenueToday) ? 'Rp ' . number_format($revenueToday, 0, ',', '.') : 'NOT SET' }}</p>
    <p><strong>Total Revenue:</strong> {{ isset($revenue) ? 'Rp ' . number_format($revenue, 0, ',', '.') : 'NOT SET' }}</p>
    <p><strong>Total Pesanan:</strong> {{ isset($totalPesanan) ? $totalPesanan : 'NOT SET' }}</p>
    <p><strong>Produk Aktif:</strong> {{ isset($produkAktif) ? $produkAktif : 'NOT SET' }}</p>
    <p><strong>Total Pelanggan:</strong> {{ isset($totalPelanggan) ? $totalPelanggan : 'NOT SET' }}</p>
    <p><strong>Chart Labels Count:</strong> {{ isset($chartLabels) ? count($chartLabels) : 'NOT SET' }}</p>
</div>

<script>
    const ctx = document.getElementById('orderChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Jumlah Pesanan',
                    data: @json($chartData),
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 5,
                    pointBackgroundColor: '#667eea',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }
</script>

@endsection
