<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SugarBase') - E-Commerce</title>
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
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg-light);
            color: var(--dark);
        }
        
        /* ─── TOP NAVIGATION ─── */
        .top-nav {
            background: white;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .nav-brand {
            font-size: 1.3em;
            font-weight: bold;
            color: var(--dark);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .nav-brand:hover {
            opacity: 0.8;
        }
        
        .nav-center {
            flex: 1;
            display: flex;
            justify-content: center;
            margin: 0 20px;
        }

        .search-bar {
            width: 300px;
            padding: 10px 16px;
            border: 2px solid var(--border-accent);
            border-radius: 24px;
            background: var(--card-bg);
            font-size: 0.9em;
            transition: all 0.3s ease;
        }

        .search-bar:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 8px rgba(102, 126, 234, 0.2);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-icon-btn {
            background: none;
            border: none;
            font-size: 1.3em;
            cursor: pointer;
            position: relative;
            padding: 8px;
            transition: all 0.3s ease;
        }

        .nav-icon-btn:hover {
            transform: scale(1.1);
        }

        .badge {
            position: absolute;
            top: 0;
            right: 0;
            background: var(--danger);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75em;
            font-weight: bold;
        }

        .admin-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #111827;
            color: white;
            border-radius: 999px;
            padding: 4px 8px;
            font-size: 0.7em;
            font-weight: 700;
            margin-left: 8px;
        }

        .avatar-dropdown {
            position: relative;
        }

        .avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .avatar:hover {
            transform: scale(1.1);
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid var(--border);
            border-radius: 8px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            min-width: 180px;
            z-index: 1000;
            margin-top: 8px;
        }

        .dropdown-menu.active {
            display: block;
        }

        .dropdown-menu a,
        .dropdown-menu form button {
            display: block;
            width: 100%;
            padding: 12px 16px;
            text-decoration: none;
            color: var(--dark);
            text-align: left;
            border: none;
            background: none;
            cursor: pointer;
            font-size: 0.9em;
            transition: background 0.2s ease;
        }

        .dropdown-menu a:hover,
        .dropdown-menu form button:hover {
            background: var(--light);
        }

        .dropdown-menu form button {
            color: var(--danger);
        }

        /* ─── CONTENT AREA ─── */
        .main-content {
            padding: 20px 0;
            min-height: calc(100vh - 70px - 80px);
            padding-bottom: 100px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* ─── BOTTOM NAVIGATION (MOBILE) ─── */
        .bottom-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            border-top: 1px solid var(--border);
            padding: 8px 0;
            z-index: 99;
        }

        .bottom-nav-items {
            display: flex;
            justify-content: space-around;
            list-style: none;
        }

        .bottom-nav-items a {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            padding: 10px;
            text-decoration: none;
            color: #999;
            font-size: 0.8em;
            transition: color 0.3s ease;
        }

        .bottom-nav-items a:hover,
        .bottom-nav-items a.active {
            color: var(--primary);
        }

        .nav-icon {
            font-size: 1.5em;
        }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 768px) {
            .top-nav {
                gap: 10px;
            }

            .nav-center {
                display: none;
            }

            .search-bar {
                width: 40px;
                padding: 8px;
                border: none;
            }

            .main-content {
                padding-bottom: 120px;
            }

            .bottom-nav {
                display: block;
            }
        }

        @media (max-width: 480px) {
            .nav-brand {
                font-size: 1em;
            }

            .nav-right {
                gap: 10px;
            }
        }
    </style>
</head>
<body>

    <!-- TOP NAVIGATION -->
    <nav class="top-nav">
        <a href="/" class="nav-brand">
            <span style="font-size: 1.2em;">🍰</span>
            SugarBase
        </a>

        <div class="nav-center">
            <input type="text" class="search-bar" placeholder="Cari produk..." id="searchInput">
        </div>

        <div class="nav-right">
            <!-- Notification Bell -->
            <button class="nav-icon-btn" id="notifBtn" onclick="window.location.href='/notifikasi'">
                🔔
                @if(($unreadCount ?? 0) > 0)
                    <span class="badge" id="notifBadge">{{ $unreadCount }}</span>
                @endif
                @if(auth()->check() && (auth()->user()->role ?? null) === 'admin')
                    <span class="admin-badge" id="adminNotifTotal">{{ $adminNotifTotal ?? 0 }} total</span>
                @endif
            </button>

            <!-- Cart -->
            <button class="nav-icon-btn" onclick="window.location.href='/keranjang'">
                🛒
            </button>

            <!-- Avatar Dropdown -->
            <div class="avatar-dropdown">
                <div class="avatar" id="avatarBtn">
                    {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                </div>
                <div class="dropdown-menu" id="avatarMenu">
                    <a href="/profil">👤 Profil</a>
                    <a href="/pesanan/saya">📦 Pesanan Saya</a>
                    <a href="/riwayat">📋 Riwayat</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">🚪 Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- BOTTOM NAVIGATION (MOBILE) -->
    <nav class="bottom-nav">
        <ul class="bottom-nav-items">
            <li><a href="/" class="nav-link {{ request()->is('/') || request()->is('beranda') ? 'active' : '' }}">
                <span class="nav-icon">🏠</span>
                <span>Beranda</span>
            </a></li>
            <li><a href="/katalog" class="nav-link {{ request()->is('katalog*') ? 'active' : '' }}">
                <span class="nav-icon">🍰</span>
                <span>Katalog</span>
            </a></li>
            <li><a href="/keranjang" class="nav-link {{ request()->is('keranjang*') ? 'active' : '' }}">
                <span class="nav-icon">🛒</span>
                <span>Keranjang</span>
            </a></li>
            <li><a href="/pesanan/saya" class="nav-link {{ request()->is('pesanan*') ? 'active' : '' }}">
                <span class="nav-icon">📦</span>
                <span>Pesanan</span>
            </a></li>
            <li><a href="/profil" class="nav-link {{ request()->is('profil*') ? 'active' : '' }}">
                <span class="nav-icon">👤</span>
                <span>Profil</span>
            </a></li>
        </ul>
    </nav>

    <script>
        // Avatar Dropdown Toggle
        document.getElementById('avatarBtn').addEventListener('click', function() {
            document.getElementById('avatarMenu').classList.toggle('active');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const avatar = document.getElementById('avatarBtn');
            const menu = document.getElementById('avatarMenu');
            if (!avatar.contains(event.target) && !menu.contains(event.target)) {
                menu.classList.remove('active');
            }
        });

        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                const q = this.value;
                if (q.trim()) {
                    window.location.href = '/katalog?q=' + encodeURIComponent(q);
                }
            }
        });
    </script>

</body>
</html>
