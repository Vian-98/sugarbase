<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk – SugarBase</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background: linear-gradient(135deg, #fff7ed 0%, #fef3c7 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen font-sans">

    <div class="w-full max-w-md mx-4">

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-xl px-8 py-10">

            {{-- Logo --}}
            <div class="flex flex-col items-center mb-8">
                <div class="w-16 h-16 bg-amber-400 rounded-full flex items-center justify-center shadow-md mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9 text-white" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 
                                 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 
                                 2.704 2.704 0 00-3 0 2.704 2.704 0 01-1.5-.454M9 6l3-3 3 3m-3-3v12"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-amber-700 tracking-wide">SugarBase</h1>
                <p class="text-sm text-gray-400 mt-1">Masuk ke akun Anda</p>
            </div>

            {{-- Global Error --}}
            @if ($errors->any() && !$errors->has('email'))
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg px-4 py-3 mb-5 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ url('/login') }}" novalidate>
                @csrf

                {{-- Email --}}
                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        placeholder="contoh@email.com"
                        class="w-full px-4 py-2.5 rounded-lg border
                               {{ $errors->has('email') ? 'border-red-400 bg-red-50 focus:ring-red-300' : 'border-gray-300 focus:ring-amber-300' }}
                               focus:outline-none focus:ring-2 text-gray-800 text-sm transition"
                    >
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Password
                    </label>
                    <div class="relative">
                        <input
                            id="password"
                            type="password"
                            name="password"
                            autocomplete="current-password"
                            placeholder="••••••••"
                            class="w-full px-4 py-2.5 pr-10 rounded-lg border
                                   {{ $errors->has('password') ? 'border-red-400 bg-red-50 focus:ring-red-300' : 'border-gray-300 focus:ring-amber-300' }}
                                   focus:outline-none focus:ring-2 text-gray-800 text-sm transition"
                        >
                        {{-- Toggle visibility --}}
                        <button type="button"
                                onclick="togglePassword('password', this)"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600">
                            <svg id="icon-eye-password" xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 
                                         9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full bg-amber-400 hover:bg-amber-500 active:bg-amber-600
                               text-white font-semibold py-2.5 rounded-lg transition text-sm shadow-sm">
                    Masuk
                </button>
            </form>

            {{-- Register Link --}}
            <p class="mt-6 text-center text-sm text-gray-500">
                Belum punya akun?
                <a href="{{ url('/register') }}" class="text-amber-600 font-medium hover:underline">
                    Daftar
                </a>
            </p>

        </div>{{-- end card --}}

    </div>

    <script>
        function togglePassword(inputId, btn) {
            const input = document.getElementById(inputId);
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    </script>

</body>
</html>
