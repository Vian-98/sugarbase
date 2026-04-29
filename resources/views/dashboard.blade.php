@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="page-header">
    <h1>📊 Dashboard</h1>
    <p>Selamat datang di Sugarbase - E-Commerce Management System</p>
</div>

<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:20px; margin-bottom:30px;">

    <div class="card" style="text-align:center; border:2px solid var(--primary);">
        <div style="font-size:2.5em; margin-bottom:10px;">🛒</div>
        <h3 style="color:var(--primary); font-size:1.6em;">
            {{ $totalPesanan }}
        </h3>
        <p style="color:#6b7280;">Total Pesanan</p>
    </div>

    <div class="card" style="text-align:center; border:2px solid var(--success);">
        <div style="font-size:2.5em; margin-bottom:10px;">💰</div>
        <h3 style="color:var(--success); font-size:1.6em;">
            Rp {{ number_format($revenue,0,',','.') }}
        </h3>
        <p style="color:#6b7280;">Revenue</p>
    </div>

    <div class="card" style="text-align:center; border:2px solid var(--warning);">
        <div style="font-size:2.5em; margin-bottom:10px;">📦</div>
        <h3 style="color:var(--warning); font-size:1.6em;">
            {{ $produkAktif }}
        </h3>
        <p style="color:#6b7280;">Produk Aktif</p>
    </div>

    <div class="card" style="text-align:center; border:2px solid #3b82f6;">
        <div style="font-size:2.5em; margin-bottom:10px;">👥</div>
        <h3 style="color:#3b82f6; font-size:1.6em;">
            {{ $totalPelanggan }}
        </h3>
        <p style="color:#6b7280;">Pelanggan</p>
    </div>

</div>

<div class="card" style="margin-bottom:30px;">
    <h2 style="margin-bottom:20px;">📈 Tren Pesanan 7 Hari Terakhir</h2>
    <canvas id="orderChart" height="100"></canvas>
</div>

<div class="card">
    <h2>🚀 Quick Access</h2>
    <p style="margin-bottom:15px; color:#6b7280;">
        Gunakan menu sidebar untuk mengelola data sistem.
    </p>

    <a href="/produk" class="btn btn-primary">Lihat Produk →</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('orderChart');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($chartLabels),
        datasets: [{
            label: 'Jumlah Pesanan',
            data: @json($chartData),
            tension: 0.3,
            fill: false
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true
            }
        }
    }
});
</script>

@endsection