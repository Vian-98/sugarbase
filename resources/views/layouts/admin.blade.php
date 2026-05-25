<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin SugarBase</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
            --accent: #FFE3E3;
            --bg: #FEF9F2;
            --surface: rgba(255,255,255,0.72);
            --surface-strong: rgba(255,255,255,0.84);
            --surface-muted: rgba(255,255,255,0.56);
            --border: rgba(120,157,188,0.15);
            --border-soft: rgba(120,157,188,0.10);
            --dark: #2B2B2B;
            --light: #FEF9F2;
            --text-secondary: #6B7280;
            --glass-bg: rgba(255,255,255,0.72);
            --muted: #6B7280;
            --card-radius: 18px;
            --container-max: 1200px;
            --app-bg: linear-gradient(135deg, #FEF9F2 0%, #FFE3E3 40%, #C9E9D2 100%);
            --navbar-bg: rgba(255,255,255,0.65);
            --navbar-bg-scrolled: rgba(255,255,255,0.82);
            --navbar-shadow: 0 2px 12px rgba(120,157,188,0.12);
            --navbar-shadow-scrolled: 0 10px 30px rgba(120,157,188,0.14);
            --card-shadow: 0 8px 30px rgba(120,157,188,0.08);
            --card-shadow-hover: 0 18px 50px rgba(120,157,188,0.12);
            --button-shadow: 0 8px 20px rgba(120,157,188,0.25);
            --button-shadow-hover: 0 8px 20px rgba(120,157,188,0.25);
            color-scheme: light;
        }

        html[data-theme='dark'] {
            --primary: #789DBC;
            --secondary: #C9E9D2;
            --accent: #E8BFC6;
            --bg: #111827;
            --surface: rgba(30,41,59,0.7);
            --surface-strong: rgba(17,24,39,0.75);
            --surface-muted: rgba(17,24,39,0.62);
            --border: rgba(255,255,255,0.08);
            --border-soft: rgba(255,255,255,0.06);
            --dark: #F9FAFB;
            --light: #111827;
            --text-secondary: #CBD5E1;
            --glass-bg: rgba(30,41,59,0.7);
            --muted: #CBD5E1;
            --app-bg: linear-gradient(135deg, #111827 0%, #1E293B 50%, #0F172A 100%);
            --navbar-bg: rgba(17,24,39,0.65);
            --navbar-bg-scrolled: rgba(17,24,39,0.82);
            --navbar-shadow: 0 8px 28px rgba(0,0,0,0.22);
            --navbar-shadow-scrolled: 0 10px 30px rgba(0,0,0,0.28);
            --card-shadow: 0 8px 30px rgba(0,0,0,0.25);
            --card-shadow-hover: 0 18px 50px rgba(0,0,0,0.35);
            --button-shadow: 0 8px 20px rgba(120,157,188,0.20);
            --button-shadow-hover: 0 8px 20px rgba(120,157,188,0.28);
            color-scheme: dark;
        }

        html, body {
            height: 100%;
            scroll-behavior: smooth;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        body {
            font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Montserrat', sans-serif;
            background: var(--app-bg);
            color: var(--dark);
            display: flex;
            flex-direction: column;
            line-height: 1.5;
            transition:
                background 0.4s ease,
                color 0.4s ease,
                border-color 0.4s ease,
                box-shadow 0.4s ease;
        }

        /* ═════════════════════════════════════════════════════════════
           MAIN LAYOUT
        ═════════════════════════════════════════════════════════════ */
        .admin-container {
            display: grid;
            grid-template-columns: 1fr;
            grid-template-rows: auto 1fr;
            min-height: 100vh;
            gap: 0;
        }

        /* ═════════════════════════════════════════════════════════════
           NAVBAR LIQUID GLASS - ULTRA MODERN
        ═════════════════════════════════════════════════════════════ */
        .admin-header {
            grid-column: 1;
            grid-row: 1;
            position: sticky;
            top: 0;
            z-index: 1000;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: clamp(12px, 2.5vw, 40px);
            
            /* Liquid Glass Effect */
            background: var(--navbar-bg);
            backdrop-filter: blur(20px) saturate(150%) brightness(1.02);
            border-bottom: 1px solid var(--border);
            box-shadow: var(--navbar-shadow);
            
            transition: transform 0.35s cubic-bezier(0.2,0.8,0.2,1), background 0.35s ease, box-shadow 0.35s ease;
        }

        /* Scroll State - Navbar becomes more solid */
        body.navbar-scrolled .admin-header {
            background: var(--navbar-bg-scrolled);
            backdrop-filter: blur(26px) saturate(155%) brightness(1.02);
            box-shadow: var(--navbar-shadow-scrolled);
            border-bottom: 1px solid var(--border);
            transform: translateY(-4px) scale(0.9985);
        }

        /* ─── NAVBAR LOGO ─── */
        .navbar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            flex-shrink: 0;
        }

        .navbar-logo-text {
            font-size: 1.0625em;
            font-weight: 700;
            letter-spacing: -0.6px;
            color: var(--dark);
        }

        .navbar-logo:hover {
            transform: scale(1.02);
            opacity: 0.8;
        }

        /* ─── CENTER NAVIGATION ─── */
        .navbar-center {
            display: flex;
            align-items: center;
            gap: 8px;
            flex: 1;
            justify-content: center;
            margin: 0 36px;
        }

        .navbar-menu {
            display: flex;
            align-items: center;
            gap: 4px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .navbar-menu li {
            position: relative;
        }

        .navbar-menu a {
            display: flex;
            align-items: center;
            padding: 8px 18px;
            text-decoration: none;
            color: var(--dark);
            font-weight: 500;
            font-size: 0.9375em;
            letter-spacing: -0.3px;
            border-radius: 8px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            white-space: nowrap;
        }

        /* Hover Effect */
        .navbar-menu a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
                background: rgba(120,157,188,0.10);
            border-radius: 8px;
            transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: -1;
        }

        .navbar-menu a:hover::before {
            left: 0;
        }

        .navbar-menu a:hover {
            color: var(--primary);
            transform: translateY(-2px);
        }

        /* Active State */
        .navbar-menu a.active {
            color: var(--dark);
            background: linear-gradient(135deg, #789DBC 0%, #C9E9D2 100%);
            box-shadow: 0 6px 20px rgba(120, 157, 188, 0.24);
            transform: translateY(-3px);
        }

        .navbar-menu a.active::before {
            display: none;
        }

        /* ─── RIGHT ACTIONS ─── */
        .navbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-shrink: 0;
        }

        /* Icon Button Style */
        .navbar-icon-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: var(--surface-muted);
            color: var(--dark);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1em;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(14px);
        }

        .navbar-icon-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(120, 157, 188, 0.15);
            transform: translate(-50%, -50%);
            transition: width 0.4s, height 0.4s;
        }

        .navbar-icon-btn:hover::before {
            width: 40px;
            height: 40px;
        }

        .navbar-icon-btn:hover {
            color: var(--primary);
            background: var(--surface-strong);
            transform: scale(1.08);
        }

        .navbar-icon-btn:active {
            transform: scale(0.95);
        }

        /* Search Button */
        .search-btn {
            position: relative;
        }

        .theme-toggle-btn {
            gap: 8px;
            min-width: 88px;
            padding: 0 14px;
            border-radius: 999px;
        }

        .theme-toggle-btn i {
            font-size: 0.95em;
        }

        .theme-toggle-label {
            font-size: 0.82em;
            font-weight: 600;
        }

        .navbar-search-form {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 220px;
            max-width: 320px;
            flex: 1 1 260px;
        }

        .navbar-search-form input {
            width: 100%;
            border: 1px solid var(--border);
            background: var(--surface-strong);
            border-radius: 999px;
            padding: 10px 16px;
            color: var(--dark);
            font-size: 0.92em;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .navbar-search-form input::placeholder {
            color: var(--muted);
        }

        .navbar-search-form input:focus {
            border-color: rgba(120,157,188,0.45);
            box-shadow: 0 0 0 4px rgba(120,157,188,0.10);
            background: var(--surface-strong);
        }

        .navbar-search-submit {
            width: 40px;
            height: 40px;
            border-radius: 999px;
            border: none;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 18px rgba(120,157,188,0.18);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            flex-shrink: 0;
        }

        .navbar-search-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 22px rgba(120,157,188,0.24);
        }

        /* Profile Avatar */
        .profile-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            font-weight: 700;
            font-size: 0.95em;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(120,157,188,0.20);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            background-image: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        }

        .profile-avatar:hover {
            transform: scale(1.1) rotateZ(5deg);
            box-shadow: 0 8px 24px rgba(120,157,188,0.28);
        }

        .profile-avatar:active {
            transform: scale(0.95);
        }

        /* Hamburger Menu */
        .hamburger-menu {
            display: none;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: none;
            background: var(--surface-muted);
            color: var(--dark);
            border: 1px solid var(--border);
            cursor: pointer;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 5px;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hamburger-menu:hover {
            background: var(--surface-strong);
        }

        .hamburger-menu span {
            width: 20px;
            height: 2px;
            background: var(--dark);
            border-radius: 1px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hamburger-menu.active span:nth-child(1) {
            transform: rotate(45deg) translateY(12px);
        }

        .hamburger-menu.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger-menu.active span:nth-child(3) {
            transform: rotate(-45deg) translateY(-12px);
        }

        /* ─── SIDEBAR (MOBILE) ─── */
        .sidebar {
            display: none;
        }

        /* ─── MAIN CONTENT ─── */
        .admin-content {
            grid-column: 1;
            grid-row: 2;
            /* tighter flexible padding to reduce gap under navbar */
            padding: clamp(10px, 2.5vw, 32px);
            overflow-y: auto;
            background: transparent;
            min-height: calc(100vh - 64px);
        }

        /* centered container to control content width and rhythm */
        .container {
            max-width: var(--container-max);
            margin: 0 auto;
            padding: 0 20px;
        }
            .hero-title { font-size: 2.25em; font-weight: 700; letter-spacing: -1px; color: var(--dark); margin: 0 0 8px 0; }

            /* Ensure headings use consistent casing and rhythm */
            .hero-title, .page-header h1, .page-title h1 { text-transform: none; }

            .hero-sub { color: var(--muted); font-weight: 500; margin-top: 6px; }

        .page-title {
            margin-bottom: clamp(12px, 3vw, 32px);
        }

        .page-title h1 {
            font-size: 2.25em;
            font-weight: 700;
            letter-spacing: -1px;
            color: var(--dark);
            margin-bottom: 8px;
        }

        .page-title p {
            color: var(--text-secondary);
            font-size: 0.9375em;
            font-weight: 500;
        }

        /* ─── ALERTS ─── */
        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            border-left: 3px solid;
            font-size: 0.9375em;
            font-weight: 500;
            backdrop-filter: blur(10px);
        }

        .alert-success {
            background: rgba(201, 233, 210, 0.42);
            border-left-color: #7EBB98;
            color: #3A7A5A;
        }

        .alert-danger {
            background: rgba(255, 227, 227, 0.55);
            border-left-color: #D98999;
            color: var(--danger);
        }

        .alert-warning {
            background: rgba(254, 249, 242, 0.72);
            border-left-color: #E7C89E;
            color: #7A5B24;
        }

        /* ═════════════════════════════════════════════════════════════
           UNIFIED COMPONENTS STYLING
        ═════════════════════════════════════════════════════════════ */

        /* ─── PAGE HEADER ─── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 8px;
            margin-bottom: 28px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .page-header h1 {
            font-size: 1.75em;
            font-weight: 700;
            letter-spacing: -0.6px;
            color: var(--dark);
            margin: 0;
        }

        /* ─── CARDS ─── */
        .admin-card {
            background: var(--surface);
            border-radius: var(--card-radius);
            border: 1px solid var(--border);
            box-shadow: var(--card-shadow);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            backdrop-filter: blur(20px) saturate(150%);
        }

        .admin-card:hover {
            box-shadow: var(--card-shadow-hover);
            transform: translateY(-6px);
        }

        .admin-card-header { padding: 18px 20px; border-bottom: 1px solid var(--border-soft); }
        .admin-card-body { padding: 20px; }
        .admin-card-footer { padding: 12px 20px; background: rgba(255,255,255,0.20); border-top: 1px solid var(--border-soft); }

        /* Stat Cards */
        .stat-card {
            background: var(--surface);
            border-radius: 16px;
            border: 1px solid var(--border);
            padding: 18px;
            box-shadow: var(--card-shadow);
            transition: transform 0.35s cubic-bezier(.22,.9,.32,1), box-shadow 0.35s;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 10px;
        }

        .stat-card:hover { transform: translateY(-8px); box-shadow: var(--card-shadow-hover); }

        .stat-card-icon { font-size: 28px; margin-bottom: 6px; width: 54px; height: 54px; border-radius: 12px; display: grid; place-items: center; }

        .stat-card-label { font-size: 0.9em; color: var(--muted); font-weight: 600; }

        .stat-card-value { font-size: 1.35em; font-weight: 800; color: var(--dark); letter-spacing: -0.6px; }

        /* ─── BUTTONS ─── */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9375em;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            gap: 8px;
            font-family: inherit;
            letter-spacing: -0.3px;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn:active {
            transform: scale(0.95);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            box-shadow: var(--button-shadow);
        }

        .btn-primary:hover {
            box-shadow: var(--button-shadow-hover);
        }

        .btn-secondary {
            background: var(--surface-muted);
            color: var(--dark);
            border: 1px solid var(--border);
        }

        .btn-secondary:hover {
            background: var(--surface-strong);
        }

        .btn-danger {
            background: rgba(255, 227, 227, 0.64);
            color: #9B3A4A;
        }

        .btn-danger:hover {
            background: #D98999;
            color: white;
        }

        .btn-warning {
            background: rgba(254, 249, 242, 0.85);
            color: #7A5B24;
        }

        .btn-warning:hover {
            background: #E7C89E;
            color: #2B2B2B;
        }

        .btn-success {
            background: rgba(201, 233, 210, 0.72);
            color: #3A7A5A;
        }

        .btn-success:hover {
            background: #7EBB98;
            color: white;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 0.8125em;
        }

        /* ─── TABLES ─── */
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9375em;
        }

        .admin-table thead {
            background: rgba(255,255,255,0.24);
        }

        .admin-table thead tr {
            border-bottom: 1px solid var(--border-soft);
        }

        .admin-table thead th {
            padding: 14px 16px;
            text-align: left;
            font-weight: 600;
            color: var(--text-secondary);
            font-size: 0.8125em;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }

        .admin-table tbody tr {
            border-bottom: 1px solid var(--border-soft);
            transition: background 0.15s ease;
        }

        .admin-table tbody tr:hover {
            background: rgba(255,255,255,0.24);
        }

        .admin-table tbody td {
            padding: 14px 16px;
            color: var(--dark);
        }

        .admin-table-img {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
        }

        /* ─── BADGES ─── */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: 600;
            letter-spacing: -0.2px;
        }

        .badge-success {
            background: rgba(201, 233, 210, 0.72);
            color: #3F7A56;
        }

        html[data-theme='dark'] .badge-success {
            background: rgba(63, 122, 86, 0.35);
            color: #A8E6B8;
        }

        .badge-danger {
            background: rgba(255, 227, 227, 0.72);
            color: #9B3A4A;
        }

        html[data-theme='dark'] .badge-danger {
            background: rgba(155, 58, 74, 0.35);
            color: #FF9BB8;
        }

        .badge-warning {
            background: rgba(254, 249, 242, 0.9);
            color: #7A5B24;
        }

        html[data-theme='dark'] .badge-warning {
            background: rgba(122, 91, 36, 0.35);
            color: #FFD699;
        }

        .badge-info {
            background: rgba(120,157,188,0.16);
            color: var(--primary);
        }

        html[data-theme='dark'] .badge-info {
            background: rgba(120,157,188,0.25);
            color: #A8D5FF;
        }

        .badge-secondary {
            background: rgba(120,157,188,0.10);
            color: var(--text-secondary);
        }

        html[data-theme='dark'] .badge-secondary {
            background: rgba(120,157,188,0.20);
            color: #E2E8F0;
        }

        /* ─── FORMS ─── */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
            font-size: 0.9375em;
            letter-spacing: -0.2px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: 0.9375em;
            font-family: inherit;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            background: var(--surface-strong);
            color: var(--dark);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(120, 157, 188, 0.10);
        }

        .form-control::placeholder {
            color: var(--text-secondary);
        }

        /* ─── ACTION BUTTONS GROUP ─── */
        .action-buttons {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        /* ─── SPACING UTILITIES ─── */
        .mt-0 { margin-top: 0; }
        .mt-1 { margin-top: 4px; }
        .mt-2 { margin-top: 8px; }
        .mt-3 { margin-top: 12px; }
        .mt-4 { margin-top: 16px; }
        .mt-5 { margin-top: 24px; }
        .mt-6 { margin-top: 32px; }

        .mb-0 { margin-bottom: 0; }
        .mb-1 { margin-bottom: 4px; }
        .mb-2 { margin-bottom: 8px; }
        .mb-3 { margin-bottom: 12px; }
        .mb-4 { margin-bottom: 16px; }
        .mb-5 { margin-bottom: 24px; }
        .mb-6 { margin-bottom: 32px; }

        .gap-1 { gap: 4px; }
        .gap-2 { gap: 8px; }
        .gap-3 { gap: 12px; }
        .gap-4 { gap: 16px; }

        /* ═════════════════════════════════════════════════════════════
           RESPONSIVE DESIGN
        ═════════════════════════════════════════════════════════════ */
        @media (max-width: 1024px) {
            .admin-header {
                padding: 0 40px;
            }

            .navbar-center {
                margin: 0 32px;
            }

            .navbar-menu a {
                padding: 8px 14px;
                font-size: 0.875em;
            }

            .admin-content {
                /* allow clamp() to handle responsive padding; keep small override for clarity */
                padding: clamp(12px, 4vw, 40px);
            }

            .page-header h1 {
                font-size: 1.75em;
            }
        }

        @media (max-width: 768px) {
            .admin-container {
                grid-template-rows: 70px 1fr;
            }

            .admin-header {
                padding: 0 20px;
                gap: 16px;
            }

            .navbar-logo-text {
                font-size: 1em;
            }

            .navbar-center {
                display: none;
                position: absolute;
                top: 70px;
                left: 0;
                right: 0;
                flex-direction: column;
                background: rgba(250, 250, 250, 0.98);
                backdrop-filter: blur(20px) saturate(180%);
                border-bottom: 1px solid rgba(0, 0, 0, 0.04);
                padding: 16px 0;
                gap: 0;
                border-radius: 0;
                margin: 0;
                width: 100%;
                z-index: 999;
            }

            .navbar-center.active {
                display: flex;
            }

            .navbar-menu {
                flex-direction: column;
                width: 100%;
                gap: 0;
            }

            .navbar-menu a {
                width: 100%;
                padding: 14px 20px;
                border-radius: 0;
                font-size: 0.9375em;
            }

            .hamburger-menu {
                display: flex;
            }

            .admin-content {
                padding: clamp(12px, 6vw, 24px);
            }

            .navbar-right {
                gap: 12px;
            }

            .navbar-icon-btn {
                width: 36px;
                height: 36px;
                font-size: 0.9em;
            }

            .profile-avatar {
                width: 36px;
                height: 36px;
            }
        }

        @media (max-width: 480px) {
            .admin-header {
                padding: 0 16px;
            }

            .navbar-logo {
                gap: 8px;
            }

            .navbar-logo-icon {
                width: 28px;
                height: 28px;
                font-size: 0.75em;
            }

            .navbar-logo-text {
                font-size: 0.9375em;
            }

            .admin-content {
                padding: clamp(10px, 8vw, 16px);
            }

            .page-title h1 {
                font-size: 1.75em;
            }
        }

        /* ─── ANIMATIONS ─── */
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .navbar-center.active {
            animation: slideDown 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .admin-content {
            animation: fadeIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* ===== Additional utilities & page components (for Pesanan view) ===== */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }

        /* Single-row horizontal stat layout (use on dashboard when you want one-line cards) */
        .stat-row {
            display: flex;
            gap: 20px;
            align-items: stretch;
            overflow-x: auto;
            padding-bottom: 8px;
            -webkit-overflow-scrolling: touch;
        }

        .stat-row .stat-card {
            flex: 0 0 250px; /* fixed card width, no wrap */
            min-width: 220px;
        }

        .stat-card.primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            box-shadow: 0 8px 24px rgba(102,126,234,0.18);
        }
        .stat-card.primary .stat-card-label, .stat-card.primary .stat-card__label {
            color: rgba(255, 255, 255, 0.9);
        }

        /* Stat card icon and value helpers */
        .stat-card { padding: 16px; border-radius: 16px; background: var(--glass-bg); min-width: 220px; }
        .stat-card .stat-card-icon { width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; }
        .stat-card-label { font-size: 0.9em; color: var(--text-secondary); margin-top: 10px; }
        .stat-card-value { font-size: 1.4em; font-weight: 700; margin-top: 6px; }

        .stat-icon-green { background: linear-gradient(135deg, rgba(201,233,210,0.55) 0%, rgba(255,255,255,0.45) 100%); }
        .stat-icon-indigo { background: linear-gradient(135deg, rgba(120,157,188,0.18) 0%, rgba(201,233,210,0.18) 100%); }
        .stat-icon-yellow { background: linear-gradient(135deg, rgba(254,249,242,0.92) 0%, rgba(255,227,227,0.55) 100%); }
        .stat-icon-blue { background: linear-gradient(135deg, rgba(120,157,188,0.15) 0%, rgba(255,255,255,0.55) 100%); }
        .stat-icon-pink { background: linear-gradient(135deg, rgba(255,227,227,0.55) 0%, rgba(254,249,242,0.92) 100%); }
        .stat-icon-purple { background: linear-gradient(135deg, rgba(201,233,210,0.42) 0%, rgba(120,157,188,0.14) 100%); }

        .stat-value-green { color: #7EBB98; }
        .stat-value-indigo { color: var(--primary); }
        .stat-value-yellow { color: #7A5B24; }
        .stat-value-blue { color: #789DBC; }
        .stat-value-pink { color: #D98999; }
        .stat-value-purple { color: #C9E9D2; }

        /* Quick actions container */
        .quick-actions { display: flex; gap: 12px; flex-wrap: wrap; }
        .btn-gradient-blue { background: linear-gradient(135deg, #C9E9D2 0%, #FFE3E3 100%); color: #2B2B2B; }
        .btn-gradient-purple { background: linear-gradient(135deg, #789DBC 0%, #C9E9D2 100%); color: #2B2B2B; }
        .btn-gradient-indigo { background: linear-gradient(135deg, #789DBC 0%, #FFE3E3 100%); color: #2B2B2B; }

        /* Chart helpers */
        .chart-canvas { max-height: 400px; }
        /* Icon helpers */
        .icon-lg { font-size: 1.5em; }
        .icon-spaced { margin-right: 10px; }
        .text-green { color: #7EBB98; }
        .text-indigo { color: var(--primary); }
        .text-yellow { color: #7A5B24; }
        .text-blue { color: #789DBC; }
        .text-pink { color: #D98999; }
        .text-purple { color: #C9E9D2; }
        .text-dark { color: var(--dark); }
        .empty-icon { font-size: 2.5em; margin-bottom: 12px; opacity: 0.5; }
        .thumb-img { max-width: 100px; border-radius: 5px; }
        .timeline-row { display: flex; align-items: flex-start; gap: 12px; }
        .timeline-content { flex: 1; }
        .timeline-status { font-size: 0.95em; }
        .timeline-desc { color: var(--dark); font-size: 0.9em; line-height: 1.5; }
        .stack-20 { display: flex; flex-direction: column; gap: 20px; }
        .meta-text { color: var(--text-secondary); font-size: 0.95em; }
        .navbar-logo-icon { font-size: 1.2em; display: flex; align-items: center; justify-content: center; }
        .notify-dot { position: absolute; top: 6px; right: 4px; width: 8px; height: 8px; background: #ff6b6b; border-radius: 50%; }
        .profile-menu { display: none; position: absolute; top: 70px; right: 20px; background: var(--surface-strong); backdrop-filter: blur(20px); border-radius: 12px; border: 1px solid var(--border); box-shadow: 0 10px 40px rgba(0,0,0,0.08); padding: 12px 0; z-index: 999; min-width: 200px; }
        
        html[data-theme='dark'] .profile-menu {
            box-shadow: 0 10px 40px rgba(0,0,0,0.25);
        }
        
        .profile-menu.active { display: block; }
        .profile-menu-header { padding: 12px 20px; border-bottom: 1px solid var(--border); }
        .profile-name { font-weight: 600; color: var(--dark); }
        .profile-role { font-size: 0.8125em; color: var(--dark); font-weight: 500; }
        .profile-logout-btn { width: 100%; padding: 12px 20px; border: none; background: none; text-align: left; color: #9B3A4A; font-weight: 500; cursor: pointer; transition: all 0.2s ease; font-size: 0.9375em; }
        .error-list { margin-top: 8px; margin-left: 20px; }

        /* support both naming conventions used in templates */
        .stat-card__label, .stat-card-label { font-size: 0.875em; color: var(--text-secondary); font-weight: 500; }
        .stat-card__value, .stat-card-value { font-size: 1.5em; font-weight: 700; margin-top: 6px; }

        .filter-bar { padding: 12px 16px; display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }

        /* Flash / Alerts */
        .flash { padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 600; }
        .flash-success { background: rgba(201,233,210,0.45); border: 1px solid rgba(126,187,152,0.30); color: var(--dark); }
        .flash-danger { background: rgba(217,137,153,0.15); border: 1px solid #fca5a5; color: var(--dark); }
        .flash-warning { background: rgba(254, 249, 242, 0.9); border: 1px solid #fcd34d; color: var(--dark); }

        /* Filter chips used in Pesanan filter bar */
        .filter-chip { padding: 6px 14px; border-radius: 20px; text-decoration: none; font-size: 0.82em; font-weight: 600; transition: all 0.15s; background: var(--surface-muted); color: var(--text-secondary); display: inline-flex; align-items: center; }
        .filter-chip:hover { transform: translateY(-2px); }
        .filter-chip.active { background: linear-gradient(135deg, #789DBC, #C9E9D2); color: #2B2B2B; }

        /* Small helpers */
        .d-inline { display: inline; }
        .ml-1 { margin-left: 6px; }

        /* Text color utilities */
        .text-warning { color: #7A5B24; }
        .text-success { color: #7EBB98; }

        /* Timeline helpers */
        .timeline-item { margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid var(--border); }
        .timeline-dot { width: 10px; height: 10px; border-radius: 50%; background: var(--primary); margin-top: 4px; flex-shrink: 0; }
        .bb-light { border-bottom: 1px solid var(--border); }
        .mr-2 { margin-right: 8px; }
        .p-0 { padding: 0; }
        .col-50 { width: 50px; }
        .col-80 { width: 80px; }
        .col-100 { width: 100px; }
        .col-120 { width: 120px; }
        .truncate { max-width: 250px; text-overflow: ellipsis; overflow: hidden; white-space: nowrap; }
        .text-primary { color: var(--primary); }
        .empty-cell { text-align: center; padding: 40px 20px; color: var(--text-secondary); }

        .table-responsive { overflow-x: auto; }

        .font-strong { font-weight: 700; }
        .font-600 { font-weight: 600; }
        .font-700 { font-weight: 700; }
        .muted { color: var(--text-secondary); }

        .grid-2 { display: grid; grid-template-columns: 1fr 380px; gap: 24px; }
        .gap-24 { gap: 24px; }

        .mb-16 { margin-bottom: 16px; }
        .pb-16 { padding-bottom: 16px; }

        /* map card header/body helper names to admin-card ones */
        .card-header { padding: 16px 20px; background: rgba(0,0,0,0.02); font-weight: 700; }
        .card-body { padding: 16px 20px; }

        .empty-emoji { font-size: 3em; margin-bottom: 12px; }

        .btn-ghost { background: transparent; border: 1px solid var(--border); color: var(--dark); padding: 8px 14px; border-radius: 8px; }

        .d-flex { display: flex; }
        .justify-center { justify-content: center; }
        .w-100 { width: 100%; }

        .text-right { text-align: right; }
        .text-center { text-align: center; }

        .form-control-sm { padding: 6px 10px; font-size: 0.875em; border-radius: 8px; }

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
            background: var(--primary);
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

    <div class="admin-container">
        
        <!-- ═══ LIQUID GLASS NAVBAR ═══ -->
        <header class="admin-header">
            
            <!-- Logo -->
            <a href="{{ route('admin.dashboard') }}" class="navbar-logo">
                <span class="navbar-logo-icon">🍰</span>
                <span class="navbar-logo-text">SugarBase</span>
            </a>

            <!-- Center Navigation -->
            <nav class="navbar-center">
                <ul class="navbar-menu">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" 
                           class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-chart-line mr-2"></i>Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.produk.index') }}" 
                           class="{{ request()->routeIs('admin.produk.*') ? 'active' : '' }}">
                            <i class="fas fa-box mr-2"></i>Produk
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.kategori.index') }}" 
                           class="{{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                            <i class="fas fa-tag mr-2"></i>Kategori
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.pesanan.index') }}" 
                           class="{{ request()->routeIs('admin.pesanan.*') ? 'active' : '' }}">
                            <i class="fas fa-shopping-cart mr-2"></i>Pesanan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.pelanggan.index') }}" 
                           class="{{ request()->routeIs('admin.pelanggan.*') ? 'active' : '' }}">
                            <i class="fas fa-users mr-2"></i>Pelanggan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.pembayaran.index') }}" 
                           class="{{ request()->routeIs('admin.pembayaran.*') ? 'active' : '' }}">
                            <i class="fas fa-credit-card mr-2"></i>Pembayaran
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Right Actions -->
            <div class="navbar-right">
                <!-- Search -->
                <form class="navbar-search-form" action="{{ url()->current() }}" method="GET">
                    @foreach(request()->except('q') as $key => $value)
                        @if(is_array($value))
                            @foreach($value as $item)
                                <input type="hidden" name="{{ $key }}[]" value="{{ $item }}">
                            @endforeach
                        @else
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    <input
                        type="search"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Cari di halaman ini..."
                        aria-label="Cari di halaman admin saat ini"
                    >
                    <button class="navbar-search-submit" type="submit" title="Cari di halaman ini">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                <button class="navbar-icon-btn theme-toggle-btn" type="button" data-theme-toggle aria-label="Toggle dark mode">
                    <i class="fas fa-moon"></i>
                    <span class="theme-toggle-label">Dark</span>
                </button>

                <!-- Profile Avatar -->
                <button class="profile-avatar" title="{{ auth()->user()->name }}">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </button>

                <!-- Hamburger Menu (Mobile) -->
                <button class="hamburger-menu" title="Menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>

        </header>

                <!-- Profile Dropdown Menu (Optional) -->
        <div class="profile-menu">
            <div class="profile-menu-header">
                <div class="profile-name">{{ auth()->user()->name }}</div>
                <div class="profile-role">{{ ucfirst(auth()->user()->role) }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="profile-logout-btn">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </button>
            </form>
        </div>

        <!-- ─── MAIN CONTENT ─── -->
        <main class="admin-content">
            
            <!-- Alerts -->
            @if ($errors->any())
                <div class="flash flash-danger">
                    <strong><i class="fas fa-exclamation-circle mr-2"></i>Error!</strong>
                    <ul class="error-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="flash flash-success">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="flash flash-danger">
                    <i class="fas fa-times-circle mr-2"></i>{{ session('error') }}
                </div>
            @endif

            @if (session('warning'))
                <div class="flash flash-warning">
                    <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('warning') }}
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

    <!-- ═══ LIQUID GLASS NAVBAR JAVASCRIPT ═══ -->
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

        // Smooth scroll detection for navbar effect
        let lastScrollY = 0;
        const navbar = document.querySelector('.admin-header');
        const body = document.body;

        window.addEventListener('scroll', () => {
            lastScrollY = window.scrollY;
            
            if (lastScrollY > 20) {
                body.classList.add('navbar-scrolled');
            } else {
                body.classList.remove('navbar-scrolled');
            }
        }, { passive: true });

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            const navbar = document.querySelector('.navbar-center');
            const hamburger = document.querySelector('.hamburger-menu');
            const profileMenu = document.querySelector('.profile-menu');
            
            if (!e.target.closest('.navbar-center') && 
                !e.target.closest('.hamburger-menu') && 
                navbar.classList.contains('active')) {
                navbar.classList.remove('active');
                hamburger.classList.remove('active');
            }

            if (!e.target.closest('.profile-avatar') && 
                !e.target.closest('.profile-menu') && 
                profileMenu && profileMenu.classList.contains('active')) {
                profileMenu.classList.remove('active');
            }
        });

        // Profile menu toggle
        document.querySelector('.profile-avatar').addEventListener('click', function(e) {
            e.stopPropagation();
            const profileMenu = document.querySelector('.profile-menu');
            if (profileMenu) {
                profileMenu.classList.toggle('active');
            }
        });

        // Add smooth animations to menu items
        const menuItems = document.querySelectorAll('.navbar-menu a');
        menuItems.forEach(item => {
            item.addEventListener('click', function() {
                // Remove active class from all items
                menuItems.forEach(i => i.classList.remove('active'));
                // Add active class to clicked item
                this.classList.add('active');
            });
        });

        // Mobile hamburger: toggle menu + prevent background scroll
        const hamburger = document.querySelector('.hamburger-menu');
        const navbarCenter = document.querySelector('.navbar-center');
        
        hamburger.addEventListener('click', () => {
            navbarCenter.classList.toggle('active');
            hamburger.classList.toggle('active');
            if (navbarCenter.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = 'auto';
            }
        });
    </script>

</body>
</html>
