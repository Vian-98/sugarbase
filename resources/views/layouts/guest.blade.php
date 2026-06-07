<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SugarBase - Toko Dessert Premium')</title>
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
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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
        
        .nav-links {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        
        .nav-link {
            text-decoration: none;
            color: var(--text-secondary);
            font-weight: 600;
            transition: color 0.3s;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--primary);
        }
        
        .btn-guest {
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-block;
        }
        
        .btn-guest-primary {
            background: linear-gradient(135deg, #789DBC 0%, #9FBCCD 100%);
            color: white;
        }
        
        .btn-guest-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(120, 157, 188, 0.4);
            color: white;
        }
        
        .btn-guest-secondary {
            background: var(--surface-muted);
            color: var(--dark);
            border: 1px solid var(--border);
        }
        
        .btn-guest-secondary:hover {
            background: var(--primary);
            color: white;
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

        /* ─── CONTENT AREA ─── */
        .main-content {
            padding: 40px 0;
            flex-grow: 1;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 768px) {
            .top-nav {
                flex-direction: column;
                gap: 15px;
                padding: 15px;
            }

            .nav-center {
                width: 100%;
                margin: 0;
            }

            .search-bar {
                width: 100%;
            }
            
            .nav-right {
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
            }
        }
        
        /* ─── FOOTER ─── */
        .footer {
            background: var(--surface-strong);
            color: var(--dark);
            padding: 40px 20px;
            text-align: center;
            border-top: 1px solid var(--border);
            margin-top: auto;
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
        
        @yield('styles')
    </style>
</head>
<body>

    <!-- TOP NAVIGATION -->
    <nav class="top-nav">
        <a href="/" style="display: flex; align-items: center; gap: 8px; font-size: 1.4em; font-weight: 700; color: var(--dark); text-decoration: none;">
            SugarBase
        </a>

        <div class="nav-center">
            <form action="/guest/katalog" method="GET" style="width: 100%; display: flex; justify-content: center;">
                <input type="text" class="search-bar" name="search" placeholder="Cari produk..." value="{{ request('search') }}">
            </form>
        </div>

        <div class="nav-right">
            <div class="nav-links">
                <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Beranda</a>
                <a href="/guest/katalog" class="nav-link {{ request()->is('guest/katalog') ? 'active' : '' }}">Katalog</a>
            </div>
            
            <button class="theme-toggle-btn" type="button" data-theme-toggle aria-label="Toggle dark mode">
                <i class="fas fa-moon"></i>
            </button>

            <a href="/login" class="btn-guest btn-guest-primary">Masuk</a>
            <a href="/register" class="btn-guest btn-guest-secondary">Daftar</a>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <h3>SugarBase</h3>
        <p style="margin-top: 10px; opacity: 0.8;">Toko Dessert Premium dengan Berbagai Pilihan Produk Terbaik</p>
        <p style="margin-top: 20px; opacity: 0.6; font-size: 0.9em;">© 2026 SugarBase. All rights reserved.</p>
    </footer>

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
                    if (icon) icon.className = theme === 'dark' ? 'fas fa-sun' : 'fas fa-moon';
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
    </script>

    @yield('scripts')

</body>
</html>
