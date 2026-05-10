<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin SugarBase</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --success: #22c55e;
            --danger: #ef4444;
            --warning: #f59e0b;
            --dark: #1f2937;
            --light: #f3f4f6;
            --border: #e5e7eb;
            --bg-light: #fbfbfb;
            --card-bg: #e8f9ff;
            --border-accent: #c4d9ff;
            --highlight: #c5baff;
        }

        html, body {
            height: 100%;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--light);
            color: var(--dark);
            display: flex;
            flex-direction: column;
        }

        /* ─── LAYOUT GRID ─── */
        .admin-container {
            display: grid;
            grid-template-columns: 250px 1fr;
            grid-template-rows: 70px 1fr;
            min-height: 100vh;
            gap: 0;
        }

        /* ─── SIDEBAR ─── */
        .sidebar {
            grid-column: 1;
            grid-row: 1 / 3;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 20px 15px;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-logo h2 {
            font-size: 1.3em;
            font-weight: bold;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 8px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 0.95em;
        }

        .sidebar-menu a:hover {
            background: rgba(255, 255, 255, 0.15);
            color: white;
        }

        .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.25);
            color: white;
            font-weight: 600;
            border-left: 3px solid white;
            padding-left: 12px;
        }

        .sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            margin: 20px 0 15px 0;
        }

        /* ─── HEADER ─── */
        .admin-header {
            grid-column: 2;
            grid-row: 1;
            background: white;
            border-bottom: 1px solid var(--border);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .breadcrumb {
            font-size: 0.9em;
            color: #666;
        }

        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .admin-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            cursor: pointer;
            font-size: 0.9em;
        }

        /* ─── MAIN CONTENT ─── */
        .admin-content {
            grid-column: 2;
            grid-row: 2;
            padding: 30px;
            overflow-y: auto;
        }

        .page-title {
            margin-bottom: 20px;
        }

        .page-title h1 {
            font-size: 2em;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .page-title p {
            color: #666;
            font-size: 0.95em;
        }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 768px) {
            .admin-container {
                grid-template-columns: 1fr;
                grid-template-rows: 70px auto 1fr;
            }

            .sidebar {
                grid-column: 1;
                grid-row: 2;
                position: relative;
                height: auto;
                border-bottom: 1px solid var(--border);
            }

            .admin-header {
                grid-column: 1;
                grid-row: 1;
            }

            .admin-content {
                grid-column: 1;
                grid-row: 3;
                padding: 20px 15px;
            }

            .sidebar-menu {
                display: flex;
                gap: 10px;
                flex-wrap: wrap;
            }

            .sidebar-menu li {
                margin-bottom: 0;
            }
        }

        /* ─── UTILITY ─── */
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid;
        }

        .alert-success {
            background: #ecfdf5;
            border-left-color: var(--success);
            color: #065f46;
        }

        .alert-danger {
            background: #fef2f2;
            border-left-color: var(--danger);
            color: #7f1d1d;
        }

        .alert-warning {
            background: #fffbeb;
            border-left-color: var(--warning);
            color: #78350f;
        }
    </style>
</head>
<body>

    <div class="admin-container">
        
        <!-- ─── SIDEBAR ─── -->
        <aside class="sidebar">
            <div class="sidebar-logo">
                <span style="font-size: 1.5em;">🍰</span>
                <h2>SugarBase</h2>
            </div>

            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        📊 Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.produk.index') }}" 
                       class="{{ request()->routeIs('admin.produk.*') ? 'active' : '' }}">
                        🎁 Produk
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.kategori.index') }}" 
                       class="{{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                        📂 Kategori
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.pesanan.index') }}" 
                       class="{{ request()->routeIs('admin.pesanan.*') ? 'active' : '' }}">
                        📦 Pesanan
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.pelanggan.index') }}" 
                       class="{{ request()->routeIs('admin.pelanggan.*') ? 'active' : '' }}">
                        👥 Pelanggan
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.pembayaran.index') }}" 
                       class="{{ request()->routeIs('admin.pembayaran.*') ? 'active' : '' }}">
                        💳 Pembayaran
                    </a>
                </li>

                <div class="sidebar-divider"></div>

                <li>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: none; border: none; width: 100%; text-align: left;">
                            <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                                🚪 Logout
                            </a>
                        </button>
                    </form>
                </li>
            </ul>
        </aside>

        <!-- ─── HEADER ─── -->
        <header class="admin-header">
            <div class="header-left">
                <div class="breadcrumb">
                    @yield('breadcrumb', 'Dashboard')
                </div>
            </div>

            <div class="header-right">
                <div class="admin-avatar" title="{{ auth()->user()->name }}">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div style="font-size: 0.9em;">
                    <strong>{{ auth()->user()->name }}</strong><br>
                    <small style="color: #999;">{{ ucfirst(auth()->user()->role) }}</small>
                </div>
            </div>
        </header>

        <!-- ─── CONTENT ─── -->
        <main class="admin-content">
            
            <!-- Alerts -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Error!</strong>
                    <ul style="margin-top: 8px; margin-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    ✓ {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    ✗ {{ session('error') }}
                </div>
            @endif

            @if (session('warning'))
                <div class="alert alert-warning">
                    ⚠ {{ session('warning') }}
                </div>
            @endif

            <!-- Page Title -->
            <div class="page-title">
                @yield('page_title')
            </div>

            <!-- Content -->
            @yield('content')

        </main>

    </div>

</body>
</html>
