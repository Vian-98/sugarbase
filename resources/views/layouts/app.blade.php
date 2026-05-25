<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SugarBase') - E-Commerce</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --primary: #789DBC;
            --secondary: #C9E9D2;
            --success: #7EBB98;
            --danger: #D98999;
            --warning: #E7C89E;
            --dark: #2B2B2B;
            --light: #FEF9F2;
            --border: rgba(120,157,188,0.15);
            --gradient-brand: linear-gradient(135deg, #789DBC 0%, #C9E9D2 100%);
            --gradient-soft: linear-gradient(135deg, #FEF9F2 0%, #FFE3E3 40%, #C9E9D2 100%);
            --bg-light: #FEF9F2;
            --card-bg: rgba(255,255,255,0.72);
            --border-accent: rgba(120,157,188,0.15);
            --highlight: #FFE3E3;
            --surface: rgba(255,255,255,0.72);
            --surface-strong: rgba(255,255,255,0.84);
            --surface-muted: rgba(255,255,255,0.56);
            --nav-bg: rgba(255,255,255,0.65);
            --nav-bg-scrolled: rgba(255,255,255,0.82);
            --nav-shadow: 0 2px 12px rgba(120,157,188,0.12);
            --nav-shadow-scrolled: 0 10px 30px rgba(120,157,188,0.14);
            --app-bg: linear-gradient(135deg, #FEF9F2 0%, #FFE3E3 40%, #C9E9D2 100%);
            --text-secondary: #6B7280;
        }

        html[data-theme='dark'] {
            --primary: #789DBC;
            --secondary: #C9E9D2;
            --success: #9ED0B0;
            --danger: #E8BFC6;
            --warning: #E7C89E;
            --dark: #F9FAFB;
            --light: #111827;
            --border: rgba(255,255,255,0.08);
            --bg-light: #111827;
            --card-bg: rgba(17,24,39,0.72);
            --border-accent: rgba(255,255,255,0.08);
            --highlight: #E8BFC6;
            --surface: rgba(30,41,59,0.7);
            --surface-strong: rgba(17,24,39,0.75);
            --surface-muted: rgba(17,24,39,0.62);
            --nav-bg: rgba(17,24,39,0.65);
            --nav-bg-scrolled: rgba(17,24,39,0.82);
            --nav-shadow: 0 8px 28px rgba(0,0,0,0.22);
            --nav-shadow-scrolled: 0 10px 30px rgba(0,0,0,0.28);
            --app-bg: linear-gradient(135deg, #111827 0%, #1E293B 50%, #0F172A 100%);
            --gradient-brand: linear-gradient(135deg, #334155 0%, #0F172A 100%);
            --gradient-soft: linear-gradient(135deg, rgba(30,41,59,0.8) 0%, rgba(17,24,39,0.9) 100%);
            --text-secondary: #CBD5E1;
            color-scheme: dark;
        }
        
        body {
            font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Montserrat', sans-serif;
            background: var(--app-bg);
            color: var(--dark);
            transition:
                background 0.4s ease,
                color 0.4s ease,
                border-color 0.4s ease,
                box-shadow 0.4s ease;
        }
        
        /* ─── TOP NAVIGATION ─── */
        .top-nav {
            background: var(--nav-bg);
            backdrop-filter: blur(20px);
            box-shadow: var(--nav-shadow);
            padding: 12px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid var(--border);
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
            border: 1px solid var(--border-accent);
            border-radius: 24px;
            background: var(--surface);
            font-size: 0.9em;
            transition: all 0.3s ease;
            color: var(--dark);
        }

        .search-bar:focus {
            outline: none;
            border-color: rgba(120,157,188,0.45);
            box-shadow: 0 0 0 4px rgba(120,157,188,0.10);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-icon-btn {
            background: var(--surface-muted);
            border: 1px solid var(--border);
            font-size: 1.3em;
            cursor: pointer;
            position: relative;
            padding: 8px 12px;
            transition: all 0.3s ease;
            border-radius: 12px;
            color: var(--dark);
            backdrop-filter: blur(14px);
        }

        .nav-icon-btn:hover {
            transform: translateY(-1px) scale(1.02);
            background: var(--surface-strong);
        }

        .badge {
            position: absolute;
            top: 0;
            right: 0;
            background: #D98999;
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
            background: rgba(17,24,39,0.88);
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
            background: var(--gradient-brand);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(120,157,188,0.18);
        }

        .avatar:hover {
            transform: scale(1.1);
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background: var(--surface-strong);
            border: 1px solid var(--border);
            border-radius: 8px;
            box-shadow: 0 18px 40px rgba(120,157,188,0.12);
            min-width: 180px;
            z-index: 1000;
            margin-top: 8px;
            backdrop-filter: blur(20px);
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
            background: rgba(120,157,188,0.08);
        }

        .dropdown-menu form button {
            color: #9B3A4A;
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
            background: var(--nav-bg);
            border-top: 1px solid var(--border);
            padding: 8px 0;
            z-index: 99;
            backdrop-filter: blur(20px);
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
            color: var(--text-secondary);
            font-size: 0.8em;
            transition: color 0.3s ease;
        }

        .bottom-nav-items a:hover,
        .bottom-nav-items a.active {
            color: var(--primary);
        }

        .theme-toggle-btn {
            width: 42px;
            height: 42px;
            border-radius: 999px;
            border: 1px solid var(--border);
            background: var(--surface-muted);
            color: var(--dark);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            backdrop-filter: blur(14px);
            transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
            box-shadow: 0 8px 18px rgba(120,157,188,0.12);
            flex-shrink: 0;
        }

        .theme-toggle-btn:hover {
            transform: translateY(-1px);
            background: var(--surface-strong);
            box-shadow: 0 10px 22px rgba(120,157,188,0.16);
        }

        .theme-toggle-btn i {
            font-size: 0.9em;
        }

        .theme-toggle-label {
            display: none;
            font-size: 0.82em;
            font-weight: 600;
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

            .theme-toggle-label {
                display: none;
            }
        }
        
        /* ─── PAGINATION ─── */
        .pagination {
            display: flex;
            list-style: none;
            gap: 8px;
            padding: 0;
            margin: 0;
            flex-wrap: wrap;
            justify-content: center;
        }

        .page-item .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            height: 38px;
            padding: 0 12px;
            background: var(--surface-strong);
            color: var(--text-secondary);
            border: 1px solid var(--border);
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9em;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .page-item .page-link:hover {
            background: var(--surface-muted);
            color: var(--primary);
            border-color: var(--primary);
            transform: translateY(-1px);
        }

        .page-item.active .page-link {
            background: var(--gradient-brand);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 12px rgba(120,157,188,0.25);
        }

        .page-item.disabled .page-link {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
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
            <button class="theme-toggle-btn" type="button" data-theme-toggle aria-label="Toggle dark mode">
                <i class="fas fa-moon"></i>
                <span class="theme-toggle-label">Dark</span>
            </button>

            <!-- Notification Bell -->
            <button class="nav-icon-btn" id="notifBtn" onclick="window.location.href='/notifikasi'">
                🔔
                @if(($unreadCount ?? 0) > 0)
                    <span class="badge" id="notifBadge">{{ $unreadCount }}</span>
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
        (function () {
            const storageKey = 'theme';
            const root = document.documentElement;

            const preferredTheme = () => {
                const savedTheme = localStorage.getItem(storageKey);
                if (savedTheme === 'light' || savedTheme === 'dark') return savedTheme;
                return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            };

            const syncButtons = (theme) => {
                document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
                    const icon = button.querySelector('i');
                    const label = button.querySelector('.theme-toggle-label');
                    if (icon) icon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
                    if (label) label.textContent = theme === 'dark' ? 'Light' : 'Dark';
                    button.setAttribute('aria-pressed', theme === 'dark' ? 'true' : 'false');
                });
            };

            const applyTheme = (theme, persist = false) => {
                root.setAttribute('data-theme', theme);
                root.style.colorScheme = theme;
                syncButtons(theme);
                if (persist) localStorage.setItem(storageKey, theme);
            };

            applyTheme(preferredTheme());

            document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
                button.addEventListener('click', () => {
                    const currentTheme = root.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
                    applyTheme(currentTheme === 'dark' ? 'light' : 'dark', true);
                });
            });

            const darkMatcher = window.matchMedia('(prefers-color-scheme: dark)');
            if (darkMatcher.addEventListener) {
                darkMatcher.addEventListener('change', (event) => {
                    if (!localStorage.getItem(storageKey)) {
                        applyTheme(event.matches ? 'dark' : 'light');
                    }
                });
            }
        })();

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

    @yield('scripts')

</body>
</html>
