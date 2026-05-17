<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk – SugarBase</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        :root {
            --primary:         #6366f1;
            --primary-hover:   #4f46e5;
            --glass-bg:        rgba(255,255,255,0.72);
            --glass-border:    rgba(255,255,255,0.55);
            --input-bg:        rgba(255,255,255,0.62);
            --input-border:    rgba(0,0,0,0.07);
            --text-primary:    #1a1a2e;
            --text-secondary:  #6b6b80;
            --text-muted:      #9898a8;
            --radius-card:     28px;
            --radius-input:    14px;
            --shadow-card:
                0 20px 60px rgba(0,0,0,0.10),
                0 8px  20px rgba(0,0,0,0.06),
                inset 0 1px 0 rgba(255,255,255,0.90);
            --shadow-btn:
                0 8px 24px rgba(99,102,241,0.35),
                0 2px  8px rgba(99,102,241,0.20);
        }

        /* ── BODY / BACKGROUND ── */
        html, body {
            height: 100%;
            font-family: 'Outfit', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background: #f0eff8;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow: hidden;
            position: relative;
        }

        /* ── MESH ORBS ── */
        .bg-mesh {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
        }

        .orb-1 {
            width: 520px; height: 520px;
            background: radial-gradient(circle, rgba(139,92,246,0.28) 0%, transparent 70%);
            top: -120px; left: -100px;
            animation: orbFloat1 20s ease-in-out infinite;
        }

        .orb-2 {
            width: 480px; height: 480px;
            background: radial-gradient(circle, rgba(99,102,241,0.22) 0%, transparent 70%);
            bottom: -100px; right: -80px;
            animation: orbFloat2 25s ease-in-out infinite;
        }

        .orb-3 {
            width: 320px; height: 320px;
            background: radial-gradient(circle, rgba(236,72,153,0.14) 0%, transparent 70%);
            top: 40%; right: 10%;
            animation: orbFloat3 18s ease-in-out infinite;
        }

        .orb-4 {
            width: 280px; height: 280px;
            background: radial-gradient(circle, rgba(59,130,246,0.16) 0%, transparent 70%);
            bottom: 20%; left: 8%;
            animation: orbFloat4 22s ease-in-out infinite;
        }

        @keyframes orbFloat1 {
            0%,100% { transform: translate(0,0)   scale(1);    }
            33%     { transform: translate(40px,-30px) scale(1.08); }
            66%     { transform: translate(-20px,50px) scale(0.95); }
        }
        @keyframes orbFloat2 {
            0%,100% { transform: translate(0,0)   scale(1);   }
            40%     { transform: translate(-50px,30px) scale(1.1); }
            70%     { transform: translate(30px,-40px) scale(0.92);}
        }
        @keyframes orbFloat3 {
            0%,100% { transform: translate(0,0); }
            50%     { transform: translate(-30px,20px); }
        }
        @keyframes orbFloat4 {
            0%,100% { transform: translate(0,0); }
            55%     { transform: translate(40px,-25px); }
        }

        /* subtle grid overlay on bg */
        .bg-mesh::after {
            content: '';
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        /* ── CARD WRAPPER ── */
        .card-wrap {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 420px;
            padding: 0 20px;
            animation: cardEntrance 0.9s cubic-bezier(0.16,1,0.3,1) forwards;
        }

        @keyframes cardEntrance {
            from { opacity: 0; transform: translateY(24px) scale(0.975); }
            to   { opacity: 1; transform: translateY(0)    scale(1);     }
        }

        /* ── GLASS CARD ── */
        .glass-card {
            background:      var(--glass-bg);
            backdrop-filter: blur(28px) saturate(170%) brightness(1.02);
            -webkit-backdrop-filter: blur(28px) saturate(170%) brightness(1.02);
            border:          1px solid var(--glass-border);
            border-radius:   var(--radius-card);
            box-shadow:      var(--shadow-card);
            padding:         40px 36px 36px;
            position:        relative;
            overflow:        hidden;
        }

        /* top edge shine */
        .glass-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg,
                transparent 0%,
                rgba(255,255,255,0.90) 30%,
                rgba(255,255,255,0.95) 50%,
                rgba(255,255,255,0.90) 70%,
                transparent 100%);
        }

        /* inner glass reflection */
        .glass-card::after {
            content: '';
            position: absolute; inset: 0;
            border-radius: inherit;
            background: linear-gradient(160deg,
                rgba(255,255,255,0.18) 0%, transparent 50%);
            pointer-events: none;
        }

        /* ── LOGO AREA ── */
        .logo-area {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 32px;
        }

        .logo-mark {
            width: 60px; height: 60px;
            border-radius: 18px;
            background: linear-gradient(145deg, #818cf8, #6366f1 60%, #4f46e5);
            display: flex; align-items: center; justify-content: center;
            box-shadow:
                0 8px 24px rgba(99,102,241,0.30),
                inset 0 1px 0 rgba(255,255,255,0.25);
            margin-bottom: 14px;
            position: relative; overflow: hidden;
        }

        /* logo inner shine */
        .logo-mark::before {
            content: '';
            position: absolute;
            top: -30%; left: -30%;
            width: 160%; height: 80%;
            background: linear-gradient(180deg, rgba(255,255,255,0.30) 0%, transparent 100%);
            border-radius: 50%;
        }

        .logo-mark svg {
            width: 28px; height: 28px;
            color: white;
            position: relative; z-index: 1;
        }

        .logo-name {
            font-size: 1.35rem; font-weight: 700;
            letter-spacing: -0.5px;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .logo-sub {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 400;
        }

        /* ── ERROR ALERT ── */
        .alert-error {
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.15);
            color: #b91c1c;
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 0.82rem; font-weight: 500;
            margin-bottom: 20px;
        }

        /* ── FORM ── */
        .form-group { margin-bottom: 16px; }

        .form-label {
            display: block;
            font-size: 0.82rem; font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 7px;
            letter-spacing: 0.2px;
        }

        /* ── INPUT ── */
        .input-wrap { position: relative; }

        .form-control {
            width: 100%;
            padding: 11px 40px 11px 14px;
            background: var(--input-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--input-border);
            border-radius: var(--radius-input);
            font-size: 0.92rem;
            font-family: 'Outfit', sans-serif;
            color: var(--text-primary);
            transition: all 0.25s cubic-bezier(0.4,0,0.2,1);
            outline: none;
            -webkit-appearance: none;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.03);
        }

        .form-control::placeholder { color: var(--text-muted); font-weight: 400; }

        .form-control:focus {
            background: rgba(255,255,255,0.85);
            border-color: rgba(99,102,241,0.4);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.10), inset 0 1px 3px rgba(0,0,0,0.02);
        }

        .form-control.is-invalid {
            border-color: rgba(239,68,68,0.4);
            background: rgba(254,242,242,0.60);
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(239,68,68,0.10);
        }

        .invalid-feedback {
            margin-top: 5px;
            font-size: 0.76rem;
            color: #dc2626;
            font-weight: 500;
        }

        /* ── TOGGLE EYE ── */
        .toggle-eye {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: var(--text-muted);
            display: flex; align-items: center;
            padding: 2px; border-radius: 6px;
            transition: color 0.2s, transform 0.2s;
        }

        .toggle-eye:hover { color: var(--primary); }
        .toggle-eye:active { transform: translateY(-50%) scale(0.88); }
        .toggle-eye svg { width: 16px; height: 16px; }

        /* ── SUBMIT BUTTON ── */
        .btn-login {
            width: 100%;
            margin-top: 24px;
            padding: 13px 20px;
            background: linear-gradient(135deg, #818cf8 0%, #6366f1 50%, #4f46e5 100%);
            border: none; border-radius: 14px;
            color: white;
            font-size: 0.95rem; font-weight: 600;
            font-family: 'Outfit', sans-serif;
            cursor: pointer;
            box-shadow: var(--shadow-btn);
            position: relative; overflow: hidden;
            transition: transform 0.25s cubic-bezier(0.4,0,0.2,1),
                        box-shadow 0.25s cubic-bezier(0.4,0,0.2,1);
        }

        /* shine sweep */
        .btn-login::before {
            content: '';
            position: absolute;
            top: -50%; left: -120%;
            width: 80%; height: 200%;
            background: linear-gradient(105deg,
                transparent 20%, rgba(255,255,255,0.18) 50%, transparent 80%);
            transform: skewX(-15deg);
            transition: left 0.5s ease;
        }

        .btn-login:hover::before { left: 140%; }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(99,102,241,0.40), 0 4px 12px rgba(99,102,241,0.25);
        }

        .btn-login:active {
            transform: translateY(0) scale(0.975);
            box-shadow: 0 4px 12px rgba(99,102,241,0.25);
        }

        /* ── REGISTER LINK ── */
        .register-text {
            margin-top: 22px;
            text-align: center;
            font-size: 0.84rem;
            color: var(--text-muted);
        }

        .register-text a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            margin-left: 3px;
            transition: opacity 0.2s;
        }

        .register-text a:hover { opacity: 0.75; text-decoration: underline; }

        /* ── RESPONSIVE ── */
        @media (max-width: 480px) {
            .glass-card { padding: 32px 24px 28px; }
            .card-wrap  { padding: 0 16px; }
        }
    </style>
</head>
<body>

    <div class="bg-mesh">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <div class="orb orb-4"></div>
    </div>

    <div class="card-wrap">
        <div class="glass-card">

            {{-- Logo --}}
            <div class="logo-area">
                <div class="logo-mark">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0
                                 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0
                                 2.704 2.704 0 00-3 0 2.704 2.704 0 01-1.5-.454M9 6l3-3 3 3m-3-3v12"/>
                    </svg>
                </div>
                <div class="logo-name">SugarBase</div>
                <div class="logo-sub">Masuk ke panel admin</div>
            </div>

            {{-- Error Alert --}}
            @if ($errors->any() && !$errors->has('email') && !$errors->has('password'))
                <div class="alert-error">{{ $errors->first() }}</div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ url('/login') }}" novalidate>
                @csrf

                {{-- Email --}}
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-wrap">
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            placeholder="contoh@email.com"
                            class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                        >
                    </div>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrap">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            autocomplete="current-password"
                            placeholder="••••••••"
                            class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                        >
                        <button type="button"
                                class="toggle-eye"
                                onclick="togglePassword()"
                                aria-label="Tampilkan password">
                            <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943
                                         9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit" class="btn-login" aria-label="Masuk ke akun">
                    Masuk
                </button>

            </form>

            <p class="register-text">
                Belum punya akun?
                <a href="{{ url('/register') }}">Daftar sekarang</a>
            </p>

        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon  = document.getElementById('eye-icon');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            icon.style.opacity = isHidden ? '0.5' : '1';
        }
    </script>

</body>
</html>