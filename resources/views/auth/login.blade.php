<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Masuk') }} - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .blob {
            position: absolute;
            border-radius: 9999px;
            filter: blur(90px);
            pointer-events: none;
            animation: float 14s ease-in-out infinite;
        }

        .blob-1 { width: 30rem; height: 30rem; background: #4f46e5; top: -10rem; right: -8rem; opacity: .55; }
        .blob-2 { width: 26rem; height: 26rem; background: #7c3aed; bottom: -10rem; left: -8rem; opacity: .45; animation-delay: -5s; }
        .blob-3 { width: 18rem; height: 18rem; background: #0891b2; top: 25%; left: 45%; opacity: .25; animation-delay: -9s; }

        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50%      { transform: translateY(-2rem) scale(1.06); }
        }

        .dot-grid {
            background-image: radial-gradient(rgba(255, 255, 255, .18) 1px, transparent 1px);
            background-size: 22px 22px;
        }
    </style>
</head>

<body class="font-sans antialiased text-gray-900">

    <div class="min-h-screen relative overflow-hidden bg-gradient-to-br from-slate-950 via-indigo-950 to-indigo-800 flex items-center justify-center px-4 py-10">

        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>

        <div class="relative w-full max-w-5xl bg-white/95 backdrop-blur rounded-3xl shadow-2xl overflow-hidden grid md:grid-cols-2">

            <!-- BRAND PANEL -->
            <div class="relative hidden md:flex flex-col justify-between p-10 bg-gradient-to-br from-indigo-700 via-indigo-800 to-purple-900 text-white overflow-hidden">

                <div class="absolute inset-0 dot-grid opacity-40"></div>
                <div class="absolute -top-16 -right-16 w-56 h-56 rounded-full bg-white/10 blur-2xl"></div>
                <div class="absolute -bottom-20 -left-10 w-64 h-64 rounded-full bg-purple-400/20 blur-2xl"></div>

                <div class="relative">

                    <div class="flex items-center gap-3">

                        <div class="w-11 h-11 rounded-2xl bg-white/15 backdrop-blur flex items-center justify-center shadow-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>

                        <div>
                            <p class="font-bold leading-tight">{{ config('app.name', 'Manajemen Mata Pelajaran') }}</p>
                            <p class="text-xs text-indigo-200">Sistem Kurikulum SMK</p>
                        </div>

                    </div>

                    <h1 class="mt-10 text-3xl font-bold leading-tight">
                        Kelola kurikulum<br>sekolah lebih<br><span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-300 to-pink-300">mudah &amp; rapi.</span>
                    </h1>

                    <p class="mt-4 text-sm text-indigo-100/80 leading-relaxed">
                        Satu platform untuk mengatur mata pelajaran, jadwal pengajaran, hingga laporan kurikulum.
                    </p>

                    <ul class="mt-8 space-y-4">

                        <li class="flex items-center gap-3">
                            <span class="w-9 h-9 shrink-0 rounded-xl bg-white/15 backdrop-blur flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253"/>
                                </svg>
                            </span>
                            <span class="text-sm font-medium">Kelola data mata pelajaran</span>
                        </li>

                        <li class="flex items-center gap-3">
                            <span class="w-9 h-9 shrink-0 rounded-xl bg-white/15 backdrop-blur flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </span>
                            <span class="text-sm font-medium">Atur jadwal pengajaran</span>
                        </li>

                        <li class="flex items-center gap-3">
                            <span class="w-9 h-9 shrink-0 rounded-xl bg-white/15 backdrop-blur flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                </svg>
                            </span>
                            <span class="text-sm font-medium">Cetak jadwal siap PDF</span>
                        </li>

                    </ul>

                </div>

                <p class="relative text-xs text-indigo-200/70">
                    &copy; {{ date('Y') }} {{ config('app.name', 'SMK') }}. All rights reserved.
                </p>

            </div>

            <!-- FORM PANEL -->
            <div class="p-8 sm:p-10">

                <!-- Mobile brand header -->
                <div class="md:hidden text-center mb-8">

                    <div class="mx-auto w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/30">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>

                    <h1 class="mt-4 text-xl font-bold text-gray-900">
                        {{ config('app.name', 'Manajemen Mata Pelajaran') }}
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Silakan masuk dengan akun Anda.
                    </p>

                </div>

                <!-- Desktop form header -->
                <div class="hidden md:block">
                    <h2 class="text-2xl font-bold text-gray-900">Selamat datang kembali</h2>
                    <p class="mt-1 text-sm text-gray-500">Silakan masuk dengan akun Anda untuk melanjutkan.</p>
                </div>

                @if(session('status'))
                    <div class="mt-6 p-3 rounded-lg bg-green-50 border border-green-200 text-sm text-green-700">
                        {{ session('status') }}
                    </div>
                @endif

                @if($errors->has('email') && $errors->first('email') === 'These credentials do not match our records.')
                    <div class="mt-6 flex items-start gap-2 p-3 rounded-lg bg-red-50 border border-red-200 text-sm text-red-700">
                        <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>Email atau password yang Anda masukkan salah.</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="mt-8">

                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Email
                        </label>

                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </span>

                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="nama@sekolah.sch.id"
                                class="w-full pl-10 pr-3 py-2.5 border rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition
                                    {{ $errors->has('email') && $errors->first('email') !== 'These credentials do not match our records.' ? 'border-red-300' : 'border-gray-300' }}"
                            >
                        </div>

                        @if($errors->has('email') && $errors->first('email') !== 'These credentials do not match our records.')
                            <p class="mt-1.5 text-sm text-red-600">{{ $errors->first('email') }}</p>
                        @endif
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Password
                        </label>

                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </span>

                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Masukkan password"
                                class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                            >

                            <button
                                type="button"
                                onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none"
                                aria-label="Tampilkan password"
                            >
                                <svg id="eye-open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg id="eye-closed" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </button>
                        </div>

                        @error('password')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between mt-4">

                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input
                                id="remember_me"
                                type="checkbox"
                                name="remember"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            >
                            <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
                        </label>

                        @if(Route::has('password.request'))
                            <a class="text-sm font-medium text-indigo-600 hover:text-indigo-500" href="{{ route('password.request') }}">
                                Lupa password?
                            </a>
                        @endif

                    </div>

                    <button
                        type="submit"
                        class="mt-6 w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-semibold rounded-xl shadow-lg shadow-indigo-500/30 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition"
                    >
                        Masuk
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </button>

                </form>

            </div>

        </div>

    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const open = document.getElementById('eye-open');
            const closed = document.getElementById('eye-closed');

            if (input.type === 'password') {
                input.type = 'text';
                open.classList.add('hidden');
                closed.classList.remove('hidden');
            } else {
                input.type = 'password';
                open.classList.remove('hidden');
                closed.classList.add('hidden');
            }
        }
    </script>

</body>

</html>