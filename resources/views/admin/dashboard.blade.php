@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page_title')
    <div class="container">
        <h1 class="hero-title">Dashboard</h1>
        <p class="hero-sub">Selamat datang di Admin Panel SugarBase</p>
    </div>
@endsection

@section('content')
    <div class="container">
    <!-- STAT CARDS GRID (single row) -->
    <div class="stat-row">
        
        <!-- Revenue Today Card -->
        <div class="stat-card">
            <div class="stat-card-icon stat-icon-green">
                <i class="fas fa-dollar-sign icon-lg text-green"></i>
            </div>
            <div class="stat-card-label">Revenue Hari Ini</div>
            <div class="stat-card-value stat-value-green">
                @if(isset($revenueToday))
                    Rp {{ number_format($revenueToday, 0, ',', '.') }}
                @else
                    -
                @endif
            </div>
        </div>

        <!-- Total Revenue Card -->
        <div class="stat-card">
            <div class="stat-card-icon stat-icon-indigo">
                <i class="fas fa-chart-pie icon-lg text-indigo"></i>
            </div>
            <div class="stat-card-label">Total Revenue</div>
            <div class="stat-card-value stat-value-indigo">
                @if(isset($revenue))
                    Rp {{ number_format($revenue, 0, ',', '.') }}
                @else
                    -
                @endif
            </div>
        </div>
        
        <!-- Active Products Card -->
        <div class="stat-card">
            <div class="stat-card-icon stat-icon-yellow">
                <i class="fas fa-box icon-lg text-yellow"></i>
            </div>
            <div class="stat-card-label">Produk Aktif</div>
            <div class="stat-card-value stat-value-yellow">{{ $produkAktif ?? 0 }}</div>
        </div>

        <!-- Total Customers Card -->
        <div class="stat-card">
            <div class="stat-card-icon stat-icon-blue">
                <i class="fas fa-users icon-lg text-blue"></i>
            </div>
            <div class="stat-card-label">Total Pelanggan</div>
            <div class="stat-card-value stat-value-blue">{{ $totalPelanggan ?? 0 }}</div>
        </div>

        <!-- Total Orders Card -->
        <div class="stat-card">
            <div class="stat-card-icon stat-icon-pink">
                <i class="fas fa-shopping-cart icon-lg text-pink"></i>
            </div>
            <div class="stat-card-label">Total Pesanan</div>
            <div class="stat-card-value stat-value-pink">{{ $totalPesanan ?? 0 }}</div>
        </div>

        <!-- Total Categories Card -->
        <div class="stat-card">
            <div class="stat-card-icon stat-icon-purple">
                <i class="fas fa-tag icon-lg text-purple"></i>
            </div>
            <div class="stat-card-label">Total Kategori</div>
            <div class="stat-card-value stat-value-purple">{{ $totalKategori ?? 0 }}</div>
        </div>

    </div>

    <!-- CHART SECTION -->
    <div class="admin-card mb-4">
        <div class="admin-card-header">
            <h2>
                <i class="fas fa-chart-line icon-spaced text-indigo"></i>Trend Pesanan 7 Hari Terakhir
            </h2>
        </div>
        <div class="admin-card-body">
            <canvas id="orderChart" height="80" class="chart-canvas"></canvas>
        </div>
    </div>

    <!-- QUICK ACTIONS SECTION -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h2>
                <i class="fas fa-lightning-bolt icon-spaced text-yellow"></i>Quick Actions
            </h2>
        </div>
            <div class="admin-card-body">
            <div class="quick-actions">
                <a href="{{ route('admin.produk.index') }}" class="btn btn-primary">
                    <i class="fas fa-box"></i>Kelola Produk
                </a>
                <a href="{{ route('admin.kategori.index') }}" class="btn btn-primary btn-gradient-purple">
                    <i class="fas fa-tag"></i>Kelola Kategori
                </a>
                <a href="{{ route('admin.pesanan.index') }}" class="btn btn-primary btn-gradient-indigo">
                    <i class="fas fa-shopping-cart"></i>Kelola Pesanan
                </a>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                    borderColor: '#789DBC',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 5,
                    pointBackgroundColor: '#789DBC',
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
