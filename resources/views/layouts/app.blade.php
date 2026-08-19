<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config('app.name', 'Manajemen Mapel') }}
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased bg-gray-100">

    <div class="min-h-screen flex" x-data="{ open: false }" @keydown.escape.window="open = false">

        <!-- MOBILE BACKDROP -->

        <div
            x-show="open"
            x-transition:opacity
            @click="open = false"
            style="display: none;"
            class="fixed inset-0 z-30 bg-gray-900/50 lg:hidden"
        ></div>

        <!-- SIDEBAR -->

        <aside
            :class="open ? 'translate-x-0' : '-translate-x-full'"
            @click="open = false"
            class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-gray-200 flex flex-col transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static"
        >

            <!-- Logo -->

            <div class="h-16 flex items-center px-6 border-b border-gray-200">

                <a href="{{ route('dashboard') }}" @click="open = false">

                    <span class="text-xl font-bold text-gray-800">
                        Manajemen Mapel
                    </span>

                </a>

            </div>


            <!-- MENU -->

            <div class="flex-1 px-4 py-6 overflow-y-auto">

                <!-- Dashboard -->

                <div class="mb-6">

                    @php
                        $dashboardRoute = auth()->user()->role === 'wakasek'
                            ? 'wakasek.dashboard'
                            : 'waka-kurikulum.dashboard';
                    @endphp

                    <a
                        href="{{ route($dashboardRoute) }}"
                        class="flex items-center px-4 py-3 rounded-lg
                        {{ request()->routeIs($dashboardRoute)
                            ? 'bg-gray-900 text-white'
                            : 'text-gray-600 hover:bg-gray-100' }}"
                    >

                        <svg
                            class="w-5 h-5 mr-3"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4"
                            />
                        </svg>

                        Dashboard

                    </a>

                </div>


                @if(auth()->user()->role === 'wakasek')

                    <!-- PEMANTAUAN (WAKASEK) -->

                    <div class="mb-6">

                        <p class="px-4 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                            Pemantauan
                        </p>


                        <a
                            href="{{ route('wakasek.laporan') }}"
                            class="flex items-center px-4 py-2.5 rounded-lg
                            {{ request()->routeIs('wakasek.laporan')
                                ? 'bg-gray-900 text-white'
                                : 'text-gray-600 hover:bg-gray-100' }}"
                        >
                            Laporan Pengajuan
                        </a>


                        <a
                            href="{{ route('wakasek.jadwal') }}"
                            class="flex items-center px-4 py-2.5 rounded-lg
                            {{ request()->routeIs('wakasek.jadwal')
                                ? 'bg-gray-900 text-white'
                                : 'text-gray-600 hover:bg-gray-100' }}"
                        >
                            Jadwal Pengajaran
                        </a>

                    </div>

                @else

                    <!-- MASTER DATA -->

                    <div class="mb-6">

                    <p class="px-4 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Master Data
                    </p>


                    <a
                        href="{{ route('tahun-ajaran.index') }}"
                        class="flex items-center px-4 py-2.5 rounded-lg
                        {{ request()->routeIs('tahun-ajaran.*')
                            ? 'bg-gray-900 text-white'
                            : 'text-gray-600 hover:bg-gray-100' }}"
                    >
                        Tahun Ajaran
                    </a>


                    <a
                        href="{{ route('jurusan.index') }}"
                        class="flex items-center px-4 py-2.5 rounded-lg
                        {{ request()->routeIs('jurusan.*')
                            ? 'bg-gray-900 text-white'
                            : 'text-gray-600 hover:bg-gray-100' }}"
                    >
                        Jurusan
                    </a>


                    <a
                        href="{{ route('kelas.index') }}"
                        class="flex items-center px-4 py-2.5 rounded-lg
                        {{ request()->routeIs('kelas.*')
                            ? 'bg-gray-900 text-white'
                            : 'text-gray-600 hover:bg-gray-100' }}"
                    >
                        Kelas
                    </a>


                    <a
                        href="{{ route('guru.index') }}"
                        class="flex items-center px-4 py-2.5 rounded-lg
                        {{ request()->routeIs('guru.*')
                            ? 'bg-gray-900 text-white'
                            : 'text-gray-600 hover:bg-gray-100' }}"
                    >
                        Guru
                    </a>


                    <a
                        href="{{ route('mata-pelajaran.index') }}"
                        class="flex items-center px-4 py-2.5 rounded-lg
                        {{ request()->routeIs('mata-pelajaran.*')
                            ? 'bg-gray-900 text-white'
                            : 'text-gray-600 hover:bg-gray-100' }}"
                    >
                        Mata Pelajaran
                    </a>

                </div>


                <!-- PENGAJARAN -->

                <div class="mb-6">

                    <p class="px-4 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Pengajaran
                    </p>


                    <a
                        href="{{ route('pengajaran.index') }}"
                        class="flex items-center px-4 py-2.5 rounded-lg
                        {{ request()->routeIs('pengajaran.*')
                            ? 'bg-gray-900 text-white'
                            : 'text-gray-600 hover:bg-gray-100' }}"
                    >
                        Pengajaran
                    </a>

                </div>


                <!-- LAPORAN -->

                <div class="mb-6">

                    <p class="px-4 mb-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Laporan
                    </p>


                    <a
                        href="{{ route('laporan.index') }}"
                        class="flex items-center px-4 py-2.5 rounded-lg
                        {{ request()->routeIs('laporan.*')
                            ? 'bg-gray-900 text-white'
                            : 'text-gray-600 hover:bg-gray-100' }}"
                    >
                        Laporan Pengajaran
                    </a>

                </div>

                @endif

            </div>


            <!-- USER -->

            <div class="border-t border-gray-200 p-4">

                <div class="flex items-center">

                    <div
                        class="w-10 h-10 rounded-full bg-gray-900 text-white flex items-center justify-center font-semibold"
                    >
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>


                    <div class="ml-3">

                        <p class="text-sm font-semibold text-gray-800">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="text-xs text-gray-500">
                            {{ auth()->user()->role === 'wakasek' ? 'Wakasek' : 'Waka Kurikulum' }}
                        </p>

                    </div>

                </div>


                <!-- Logout -->

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                    class="mt-3"
                    onsubmit="return confirm('Yakin ingin keluar dari aplikasi?')"
                >

                    @csrf

                    <button
                        type="submit"
                        class="w-full flex items-center gap-2 px-3 py-2 text-sm font-medium text-red-600 rounded-lg hover:bg-red-50 transition"
                    >
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Keluar
                    </button>

                </form>

            </div>

        </aside>


        <!-- MAIN CONTENT -->

        <div class="flex-1 flex flex-col min-w-0">

            <!-- TOPBAR -->

            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 sm:px-6">

                <div class="flex items-center gap-3 min-w-0">

                    <button
                        @click="open = true"
                        type="button"
                        class="lg:hidden inline-flex items-center justify-center w-10 h-10 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition"
                    >
                        <span class="sr-only">Buka menu</span>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    @isset($header)

                        {{ $header }}

                    @endisset

                </div>


                <div class="text-sm text-gray-500 hidden sm:block">

                    {{ now()->translatedFormat('l, d F Y') }}

                </div>

            </header>


            <!-- CONTENT -->

            <main class="flex-1 p-4 sm:p-6">

                {{ $slot }}

            </main>

        </div>

    </div>

</body>

</html>
