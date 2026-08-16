<x-app-layout>

    <x-slot name="header">

        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Ringkasan data akademik sekolah
            </p>
        </div>

    </x-slot>


    <!-- HERO -->

    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-indigo-600 via-indigo-700 to-purple-700 text-white shadow-lg shadow-indigo-500/20">

        <div class="absolute -top-16 -right-10 w-64 h-64 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-20 -left-10 w-72 h-72 rounded-full bg-purple-400/20 blur-2xl pointer-events-none"></div>

        <div class="relative p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center justify-between gap-6">

            <div>

                <p class="text-sm font-medium text-indigo-200">
                    Waka Kurikulum
                </p>

                <h1 class="mt-1 text-2xl sm:text-3xl font-bold">
                    Selamat Datang, {{ auth()->user()->name }}!
                </h1>

                <p class="mt-2 text-sm text-indigo-100/90 max-w-md">
                    Berikut ringkasan pengelolaan mata pelajaran, kelas, dan jadwal pengajaran.
                </p>

            </div>

            <div class="flex flex-col sm:flex-row gap-3 shrink-0">

                <a href="{{ route('mata-pelajaran.create') }}"
                   class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white text-indigo-700 text-sm font-semibold rounded-xl hover:bg-indigo-50 transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Mata Pelajaran
                </a>

                <a href="{{ route('pengajaran.create') }}"
                   class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white/15 backdrop-blur border border-white/25 text-white text-sm font-semibold rounded-xl hover:bg-white/25 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Pengajaran
                </a>

            </div>

        </div>

    </div>


    <!-- TAHUN AJARAN AKTIF -->

    <div class="mt-6">

        @if($tahunAjaranAktif)

            <div class="flex flex-wrap items-center justify-between gap-4 bg-indigo-50 border border-indigo-200 rounded-2xl p-4">

                <div class="flex items-center gap-3">

                    <span class="relative flex w-2.5 h-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-500 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                    </span>

                    <div>

                        <p class="text-sm font-medium text-indigo-900">
                            Tahun Ajaran Aktif:
                            <strong>{{ $tahunAjaranAktif->tahun }} - Semester {{ $tahunAjaranAktif->semester }}</strong>
                        </p>

                        <p class="text-xs text-indigo-600 mt-0.5">
                            Data kelas dan pengajaran mengacu pada tahun ajaran ini.
                        </p>

                    </div>

                </div>

                <a href="{{ route('tahun-ajaran.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition">
                    Kelola Tahun Ajaran
                </a>

            </div>

        @else

            <div class="flex flex-wrap items-center justify-between gap-4 bg-yellow-50 border border-yellow-200 rounded-2xl p-4 text-sm text-yellow-800">

                <p>
                    Belum ada tahun ajaran yang aktif.
                    Aktifkan tahun ajaran untuk mulai mengelola kelas dan pengajaran.
                </p>

                <a href="{{ route('tahun-ajaran.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium bg-yellow-600 text-white rounded-xl hover:bg-yellow-700 transition shrink-0">
                    Kelola Tahun Ajaran
                </a>

            </div>

        @endif

    </div>


    <!-- STATISTICS -->

    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 flex items-center justify-between">

            <div>

                <p class="text-sm font-medium text-gray-500">
                    Total Guru
                </p>

                <p class="text-3xl font-bold text-gray-800 mt-1">
                    {{ $totalGuru }}
                </p>

            </div>

            <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-4a4 4 0 100-8 4 4 0 000 8zm6 2a4 4 0 100-8 4 4 0 000 8z"/>
                </svg>
            </div>

        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 flex items-center justify-between">

            <div>

                <p class="text-sm font-medium text-gray-500">
                    Mata Pelajaran
                </p>

                <p class="text-3xl font-bold text-gray-800 mt-1">
                    {{ $totalMapel }}
                </p>

            </div>

            <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253"/>
                </svg>
            </div>

        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 flex items-center justify-between">

            <div>

                <p class="text-sm font-medium text-gray-500">
                    Total Kelas
                </p>

                <p class="text-3xl font-bold text-gray-800 mt-1">
                    {{ $totalKelas }}
                </p>

            </div>

            <div class="w-12 h-12 rounded-xl bg-cyan-50 flex items-center justify-center">
                <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
            </div>

        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 flex items-center justify-between">

            <div>

                <p class="text-sm font-medium text-gray-500">
                    Total Pengajaran
                </p>

                <p class="text-3xl font-bold text-gray-800 mt-1">
                    {{ $totalPengajaran }}
                </p>

            </div>

            <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>

        </div>

    </div>


    <!-- MENU CEPAT -->

    <div class="mt-8">

        <div class="flex items-center justify-between mb-4">

            <h3 class="font-semibold text-gray-800">
                Menu Cepat
            </h3>

            <span class="px-2.5 py-1 text-xs font-medium bg-indigo-50 text-indigo-700 rounded-full">
                Modul Waka Kurikulum
            </span>

        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

            @php
                $menus = [
                    ['route' => 'tahun-ajaran.index', 'label' => 'Tahun Ajaran', 'desc' => 'Kelola tahun & semester', 'color' => 'bg-indigo-50 text-indigo-600', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                    ['route' => 'jurusan.index', 'label' => 'Jurusan', 'desc' => 'Kelola jurusan sekolah', 'color' => 'bg-purple-50 text-purple-600', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
                    ['route' => 'kelas.index', 'label' => 'Kelas', 'desc' => 'Kelola kelas & rombongan', 'color' => 'bg-cyan-50 text-cyan-600', 'icon' => 'M4 6h16M4 10h16M4 14h16M4 18h16'],
                    ['route' => 'guru.index', 'label' => 'Guru', 'desc' => 'Data tenaga pendidik', 'color' => 'bg-green-50 text-green-600', 'icon' => 'M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-4a4 4 0 100-8 4 4 0 000 8zm6 2a4 4 0 100-8 4 4 0 000 8z'],
                    ['route' => 'mata-pelajaran.index', 'label' => 'Mata Pelajaran', 'desc' => 'Kelola mata pelajaran', 'color' => 'bg-amber-50 text-amber-600', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253'],
                    ['route' => 'pengajaran.index', 'label' => 'Pengajaran', 'desc' => 'Jadwal & distribusi guru', 'color' => 'bg-rose-50 text-rose-600', 'icon' => 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ];
            @endphp

            @foreach($menus as $menu)

                <a href="{{ route($menu['route']) }}"
                   class="group flex items-center gap-4 p-4 bg-white rounded-2xl border border-gray-200 shadow-sm hover:shadow-md hover:border-indigo-200 transition">

                    <div class="w-11 h-11 shrink-0 rounded-xl {{ $menu['color'] }} flex items-center justify-center group-hover:scale-105 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $menu['icon'] }}"/>
                        </svg>
                    </div>

                    <div class="flex-1 min-w-0">

                        <p class="font-semibold text-gray-800">
                            {{ $menu['label'] }}
                        </p>

                        <p class="text-xs text-gray-500 truncate">
                            {{ $menu['desc'] }}
                        </p>

                    </div>

                    <svg class="w-4 h-4 text-gray-300 group-hover:text-indigo-500 group-hover:translate-x-0.5 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>

                </a>

            @endforeach

        </div>

    </div>


    <!-- INFORMASI -->

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200">

            <div class="p-5 border-b border-gray-100 flex items-center gap-2">

                <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000 18z"/>
                    </svg>
                </div>

                <h3 class="font-semibold text-gray-800">
                    Informasi Sistem
                </h3>

            </div>

            <div class="p-5">

                <p class="font-medium text-gray-800">
                    Sistem Manajemen Mata Pelajaran
                </p>

                <p class="text-sm text-gray-500 mt-1 leading-relaxed">
                    Digunakan untuk mengelola data guru, mata pelajaran, kelas, dan pengajaran,
                    serta mencetak jadwal dalam format siap PDF.
                </p>

            </div>

        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200">

            <div class="p-5 border-b border-gray-100 flex items-center gap-2">

                <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>

                <h3 class="font-semibold text-gray-800">
                    Akun Aktif
                </h3>

            </div>

            <div class="p-5 flex items-center justify-between gap-4">

                <div>

                    <p class="text-sm text-gray-500">
                        Pengguna
                    </p>

                    <p class="font-semibold text-gray-800 mt-0.5">
                        {{ auth()->user()->name }}
                    </p>

                </div>

                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-medium rounded-full bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-700 border border-indigo-100">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                    Waka Kurikulum
                </span>

            </div>

        </div>

    </div>

</x-app-layout>