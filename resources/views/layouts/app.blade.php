<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sugarbase</title>
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
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--light);
            color: var(--dark);
        }
        
        /* TOP NAVIGATION */
        .top-nav {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .nav-brand {
            font-size: 1.5em;
            font-weight: bold;
            color: var(--primary);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .nav-brand:hover {
            color: var(--secondary);
        }
        
        .nav-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5em;
            cursor: pointer;
            color: var(--primary);
        }
        
        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        /* SIDEBAR */
        .container {
            display: flex;
            min-height: calc(100vh - 60px);
        }
        
        .sidebar {
            width: 250px;
            background: white;
            border-right: 1px solid var(--border);
            overflow-y: auto;
            transition: transform 0.3s ease;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 20px 0;
        }
        
        .sidebar-menu li {
            margin: 0;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: var(--dark);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }
        
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: var(--light);
            color: var(--primary);
            border-left-color: var(--primary);
            padding-left: 17px;
        }
        
        .sidebar-menu a.active {
            font-weight: 600;
        }
        
        .sidebar-menu .icon {
            font-size: 1.2em;
            min-width: 24px;
        }
        
        /* MAIN CONTENT */
        .main-content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }
        
        .page-header {
            margin-bottom: 30px;
        }
        
        .page-header h1 {
            font-size: 2em;
            color: var(--dark);
            margin-bottom: 5px;
        }
        
        .page-header p {
            color: #6b7280;
        }
        
        /* TABLET & MOBILE */
        @media (max-width: 768px) {
            .nav-toggle {
                display: block;
            }
            
            .sidebar {
                position: fixed;
                left: 0;
                top: 60px;
                height: calc(100vh - 60px);
                width: 250px;
                z-index: 99;
                transform: translateX(-100%);
            }
            
            .sidebar.active {
                transform: translateX(0);
                box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            }
            
            .main-content {
                width: 100%;
            }
            
            .page-header h1 {
                font-size: 1.5em;
            }
            
            .nav-right {
                gap: 10px;
            }
        }
        
        @media (max-width: 480px) {
            .top-nav {
                padding: 12px 15px;
            }
            
            .nav-brand {
                font-size: 1.2em;
            }
            
            .main-content {
                padding: 15px;
            }
            
            .page-header h1 {
                font-size: 1.3em;
            }
        }
        
        /* CONTENT SECTIONS */
        .card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border: 1px solid var(--border);
            margin-bottom: 20px;
        }
        
        .card h2 {
            color: var(--primary);
            margin-bottom: 15px;
            font-size: 1.3em;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 0.95em;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
        }
        
        .btn-primary:hover {
            background: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        .btn-secondary {
            background: var(--light);
            color: var(--dark);
            border: 1px solid var(--border);
        }
        
        .btn-secondary:hover {
            background: var(--border);
        }
        
        .notification {
            position: relative;
            font-size: 1.4em;
            cursor: pointer;
            text-decoration: none;
        }

        .badge {
            position: absolute;
            top: -8px;
            right: -10px;
            background: red;
            color: white;
            border-radius: 50%;
            min-width: 18px;
            height: 18px;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2px;
        }
    </style>
</head>
<body>
    <!-- TOP NAVIGATION -->
    <div class="top-nav">
        <a href="/" class="nav-brand">🍬 Sugarbase</a>
        <div class="nav-right">

        <a href="/notifikasi" class="notification">
            🔔
            @if($unreadCount > 0)
                <span class="badge">{{ $unreadCount }}</span>
            @endif
        </a>

        <button class="nav-toggle" onclick="toggleSidebar()">☰</button>

        </div>
    </div>
    
    <!-- CONTAINER -->
    <div class="container">
        <!-- SIDEBAR -->
        <aside class="sidebar" id="sidebar">
            <ul class="sidebar-menu">
                <li>
                    <a href="/" class="@if(request()->is('/')) active @endif">
                        <span class="icon">📊</span>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="/produk" class="@if(request()->is('produk*')) active @endif">
                        <span class="icon">📦</span>
                        <span>Produk</span>
                    </a>
                </li>
                <li>
                    <a href="/kategori" class="@if(request()->is('kategori*')) active @endif">
                        <span class="icon">📂</span>
                        <span>Kategori</span>
                    </a>
                </li>
                <li>
                    <a href="/pesanan" class="@if(request()->is('pesanan*')) active @endif">
                        <span class="icon">🛒</span>
                        <span>Pesanan</span>
                    </a>
                </li>
                <li>
                    <a href="/pelanggan" class="@if(request()->is('pelanggan*')) active @endif">
                        <span class="icon">👥</span>
                        <span>Pelanggan</span>
                    </a>
                </li>
                <li>
                    <a href="/pembayaran" class="@if(request()->is('pembayaran*')) active @endif">
                        <span class="icon">💳</span>
                        <span>Pembayaran</span>
                    </a>
                </li>
            </ul>
        </aside>
        
        <!-- MAIN CONTENT -->
        <main class="main-content">
            @yield('content')
        </main>
    </div>
    
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }
        
        // Close sidebar saat klik di area lain (mobile)
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.nav-toggle');
            
            if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
                if (window.innerWidth <= 768) {
                    sidebar.classList.remove('active');
                }
            }
        });
        
        // Update active menu on page load
        document.addEventListener('DOMContentLoaded', function() {
            const links = document.querySelectorAll('.sidebar-menu a');
            links.forEach(link => {
                if (link.href === window.location.href) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>
