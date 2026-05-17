<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar – SugarBase</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        :root {
            --primary:         #789DBC;
            --primary-hover:   #6A8DAB;
            --glass-bg:        rgba(255,255,255,0.72);
            --glass-border:    rgba(255,255,255,0.55);
            --input-bg:        rgba(255,255,255,0.62);
            --input-border:    rgba(0,0,0,0.07);
            --text-primary:    #2B2B2B;
            --text-secondary:  #6B7280;
            --text-muted:      #6B7280;
            --radius-card:     28px;
            --radius-input:    14px;
            --shadow-card:
                0 20px 60px rgba(0,0,0,0.10),
                0 8px  20px rgba(0,0,0,0.06),
                inset 0 1px 0 rgba(255,255,255,0.90);
            --shadow-btn:
                0 8px 24px rgba(120,157,188,0.35),
                0 2px  8px rgba(120,157,188,0.20);
            --gradient-brand: linear-gradient(135deg, #789DBC 0%, #C9E9D2 100%);
            --gradient-soft: linear-gradient(135deg, #FEF9F2 0%, #FFE3E3 40%, #C9E9D2 100%);
        }

        html, body {
            min-height: 100%;
            font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            background: var(--gradient-soft);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 40px 0;
            position: relative;
        }

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
            background: radial-gradient(circle, rgba(120,157,188,0.24) 0%, transparent 70%);
            top: -120px; left: -100px;
            animation: orbFloat1 20s ease-in-out infinite;
        }

        .orb-2 {
            width: 480px; height: 480px;
            background: radial-gradient(circle, rgba(201,233,210,0.24) 0%, transparent 70%);
            bottom: -100px; right: -80px;
            animation: orbFloat2 25s ease-in-out infinite;
        }

        .orb-3 {
            width: 320px; height: 320px;
            background: radial-gradient(circle, rgba(255,227,227,0.24) 0%, transparent 70%);
            top: 40%; right: 10%;
            animation: orbFloat3 18s ease-in-out infinite;
        }

        .orb-4 {
            width: 280px; height: 280px;
            background: radial-gradient(circle, rgba(126,187,152,0.16) 0%, transparent 70%);
            bottom: 20%; left: 8%;
            animation: orbFloat4 22s ease-in-out infinite;
        }

        @keyframes orbFloat1 {
            0%,100% { transform: translate(0,0) scale(1); }
            33%     { transform: translate(40px,-30px) scale(1.08); }
            66%     { transform: translate(-20px,50px) scale(0.95); }
        }
        @keyframes orbFloat2 {
            0%,100% { transform: translate(0,0) scale(1); }
            40%     { transform: translate(-50px,30px) scale(1.1); }
            70%     { transform: translate(30px,-40px) scale(0.92); }
        }
        @keyframes orbFloat3 {
            0%,100% { transform: translate(0,0); }
            50%     { transform: translate(-30px,20px); }
        }
        @keyframes orbFloat4 {
            0%,100% { transform: translate(0,0); }
            55%     { transform: translate(40px,-25px); }
        }

        .bg-mesh::after {
            content: '';
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px);
            background-size: 60px 60px;
        }

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
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(28px) saturate(170%) brightness(1.02);
            -webkit-backdrop-filter: blur(28px) saturate(170%) brightness(1.02);
            border: 1px solid var(--glass-border);
            border-radius: var(--radius-card);
            box-shadow: var(--shadow-card);
            padding: 40px 36px 36px;
            position: relative;
            overflow: hidden;
        }

        .glass-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.90) 30%, rgba(255,255,255,0.95) 50%, rgba(255,255,255,0.90) 70%, transparent 100%);
        }

        .glass-card::after {
            content: '';
            position: absolute; inset: 0;
            border-radius: inherit;
            background: linear-gradient(160deg, rgba(255,255,255,0.18) 0%, transparent 50%);
            pointer-events: none;
        }

        .logo-area {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 28px;
        }

        .logo-mark {
            width: 60px; height: 60px;
            border-radius: 18px;
            background: var(--gradient-brand);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 8px 24px rgba(120,157,188,0.30), inset 0 1px 0 rgba(255,255,255,0.25);
            margin-bottom: 14px;
            position: relative; overflow: hidden;
        }

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
            font-size: 1.35rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .logo-sub {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 400;
        }

        .alert-error {
            background: rgba(239,68,68,0.08);
            border: 1px solid rgba(239,68,68,0.15);
            color: #9B3A4A;
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 0.82rem;
            font-weight: 500;
            margin-bottom: 18px;
        }

        .form-group { margin-bottom: 14px; }

        .form-label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 7px;
            letter-spacing: 0.2px;
        }

        .input-wrap { position: relative; }

        .form-control {
            width: 100%;
            padding: 11px 40px 11px 14px;
            background: var(--input-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--input-border);
            border-radius: var(--radius-input);
            font-size: 0.92rem;
            font-family: 'Montserrat', sans-serif;
            color: var(--text-primary);
            transition: all 0.25s cubic-bezier(0.4,0,0.2,1);
            outline: none;
            -webkit-appearance: none;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.03);
        }

        .form-control::placeholder { color: var(--text-muted); font-weight: 400; }

        .form-control:focus {
            background: rgba(255,255,255,0.85);
            border-color: rgba(120,157,188,0.4);
            box-shadow: 0 0 0 3px rgba(120,157,188,0.10), inset 0 1px 3px rgba(0,0,0,0.02);
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
            color: #9B3A4A;
            font-weight: 500;
        }

        .toggle-eye {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            padding: 2px;
            border-radius: 6px;
            transition: color 0.2s, transform 0.2s;
        }

        .toggle-eye:hover { color: var(--primary); }
        .toggle-eye:active { transform: translateY(-50%) scale(0.88); }
        .toggle-eye svg { width: 16px; height: 16px; }

        .password-meta {
            margin-top: 8px;
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: center;
            font-size: 0.76rem;
            color: var(--text-muted);
        }

        .strength-meter {
            margin-top: 8px;
            width: 100%;
            height: 7px;
            border-radius: 999px;
            background: rgba(0,0,0,0.06);
            overflow: hidden;
        }

        .strength-meter span {
            display: block;
            height: 100%;
            width: 0%;
            border-radius: inherit;
            transition: width 0.25s ease, background-color 0.25s ease;
            background: #D98999;
        }

        .match-hint {
            margin-top: 8px;
            font-size: 0.76rem;
            font-weight: 500;
            color: var(--text-muted);
        }

        .match-hint.ok { color: #3A7A5A; }
        .match-hint.bad { color: #9B3A4A; }

        .btn-login {
            width: 100%;
            margin-top: 22px;
            padding: 13px 20px;
            background: var(--gradient-brand);
            border: none;
            border-radius: 14px;
            color: white;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: 'Montserrat', sans-serif;
            cursor: pointer;
            box-shadow: var(--shadow-btn);
            position: relative;
            overflow: hidden;
            transition: transform 0.25s cubic-bezier(0.4,0,0.2,1), box-shadow 0.25s cubic-bezier(0.4,0,0.2,1);
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: -50%; left: -120%;
            width: 80%; height: 200%;
            background: linear-gradient(105deg, transparent 20%, rgba(255,255,255,0.18) 50%, transparent 80%);
            transform: skewX(-15deg);
            transition: left 0.5s ease;
        }

        .btn-login:hover::before { left: 140%; }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(120,157,188,0.40), 0 4px 12px rgba(120,157,188,0.25);
        }

        .btn-login:active {
            transform: translateY(0) scale(0.975);
            box-shadow: 0 4px 12px rgba(120,157,188,0.25);
        }

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

        @media (max-width: 480px) {
            body { align-items: flex-start; padding: 20px 0; }
            .glass-card { padding: 32px 24px 28px; }
            .card-wrap  { padding: 0 16px; }
        }

        @media (max-height: 760px) {
            body { align-items: flex-start; }
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
                <div class="logo-sub">Buat akun baru</div>
            </div>

            @if ($errors->any())
                <div class="alert-error">Periksa kembali isian form di bawah.</div>
            @endif

            <form method="POST" action="{{ url('/register') }}" novalidate>
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <div class="input-wrap">
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            autocomplete="name"
                            placeholder="Nama Anda"
                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                        >
                    </div>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

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

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrap">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            autocomplete="new-password"
                            placeholder="Minimal 8 karakter"
                            class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                        >
                        <button type="button"
                                class="toggle-eye"
                                onclick="togglePassword('password', this)"
                                aria-label="Tampilkan password">
                            <svg id="eye-password" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943
                                         9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    <div class="password-meta">
                        <span id="strengthLabel">Kekuatan password: belum diisi</span>
                        <span>Gunakan huruf, angka, dan simbol</span>
                    </div>
                    <div class="strength-meter" aria-hidden="true">
                        <span id="strengthFill"></span>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <div class="input-wrap">
                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            autocomplete="new-password"
                            placeholder="Ulangi password"
                            class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                        >
                        <button type="button"
                                class="toggle-eye"
                                onclick="togglePassword('password_confirmation', this)"
                                aria-label="Tampilkan konfirmasi password">
                            <svg id="eye-password_confirmation" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943
                                         9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    <div id="matchHint" class="match-hint">Ketik ulang password untuk memeriksa kecocokan.</div>
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-login" aria-label="Buat akun baru">
                    Buat Akun
                </button>
            </form>

            <p class="register-text">
                Sudah punya akun?
                <a href="{{ url('/login') }}">Masuk</a>
            </p>

        </div>
    </div>

    <script>
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            if (button) {
                button.style.color = isHidden ? 'var(--primary)' : 'var(--text-muted)';
            }
        }

        function getStrengthScore(password) {
            let score = 0;
            if (!password) return score;
            if (password.length >= 8) score += 1;
            if (password.length >= 12) score += 1;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) score += 1;
            if (/\d/.test(password)) score += 1;
            if (/[^A-Za-z0-9]/.test(password)) score += 1;
            return Math.min(score, 5);
        }

        function updatePasswordStrength() {
            const password = document.getElementById('password').value;
            const fill = document.getElementById('strengthFill');
            const label = document.getElementById('strengthLabel');
            const score = getStrengthScore(password);

            const states = [
                { width: '0%', text: 'Kekuatan password: belum diisi', color: '#D98999' },
                { width: '20%', text: 'Sangat lemah', color: '#D98999' },
                { width: '40%', text: 'Lemah', color: '#E7C89E' },
                { width: '60%', text: 'Cukup', color: '#789DBC' },
                { width: '80%', text: 'Bagus', color: '#C9E9D2' },
                { width: '100%', text: 'Kuat', color: '#7EBB98' },
            ];

            const state = states[score];
            fill.style.width = state.width;
            fill.style.background = state.color;
            label.textContent = state.text;
            label.style.color = state.color;

            updatePasswordMatch();
        }

        function updatePasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmation = document.getElementById('password_confirmation').value;
            const hint = document.getElementById('matchHint');

            if (!confirmation) {
                hint.textContent = 'Ketik ulang password untuk memeriksa kecocokan.';
                hint.className = 'match-hint';
                return;
            }

            if (password === confirmation) {
                hint.textContent = 'Password cocok.';
                hint.className = 'match-hint ok';
            } else {
                hint.textContent = 'Password belum cocok.';
                hint.className = 'match-hint bad';
            }
        }

        document.getElementById('password').addEventListener('input', updatePasswordStrength);
        document.getElementById('password_confirmation').addEventListener('input', updatePasswordMatch);
    </script>

</body>
</html>