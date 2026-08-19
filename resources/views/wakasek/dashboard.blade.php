<x-app-layout>

    <x-slot name="header">

        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard Wakasek
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Pemantauan ringkasan data akademik sekolah
            </p>
        </div>

    </x-slot>


    <!-- HERO -->

    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-800 via-gray-900 to-slate-900 text-white shadow-lg">

        <div class="absolute -top-16 -right-10 w-64 h-64 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-20 -left-10 w-72 h-72 rounded-full bg-indigo-500/20 blur-2xl pointer-events-none"></div>

        <div class="relative p-6 sm:p-8 flex flex-col sm:flex-row sm:items-center justify-between gap-6">

            <div>

                <p class="text-sm font-medium text-slate-300">
                    Wakasek
                </p>

                <h1 class="mt-1 text-2xl sm:text-3xl font-bold">
                    Selamat Datang, {{ auth()->user()->name }}!
                </h1>

                <p class="mt-2 text-sm text-slate-300/90 max-w-md">
                    Anda dapat memantau data guru, mata pelajaran, kelas, jadwal pengajaran, serta laporan pengajuan.
                </p>

            </div>

            <div class="flex flex-col sm:flex-row gap-3 shrink-0">

                <a href="{{ route('wakasek.laporan') }}"
                   class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white text-slate-700 text-sm font-semibold rounded-xl hover:bg-slate-100 transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Laporan Pengajuan
                </a>

                <a href="{{ route('wakasek.jadwal') }}"
                   class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-white/15 backdrop-blur border border-white/25 text-white text-sm font-semibold rounded-xl hover:bg-white/25 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Jadwal Pengajaran
                </a>

            </div>

        </div>

    </div>


    <!-- TAHUN AJARAN AKTIF -->

    <div class="mt-6">

        @if($tahunAjaranAktif)

            <div class="flex flex-wrap items-center justify-between gap-4 bg-slate-50 border border-slate-200 rounded-2xl p-4">

                <div class="flex items-center gap-3">

                    <span class="relative flex w-2.5 h-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-500 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                    </span>

                    <div>

                        <p class="text-sm font-medium text-slate-900">
                            Tahun Ajaran Aktif:
                            <strong>{{ $tahunAjaranAktif->tahun }} - Semester {{ $tahunAjaranAktif->semester }}</strong>
                        </p>

                        <p class="text-xs text-slate-500 mt-0.5">
                            Seluruh data yang ditampilkan mengacu pada tahun ajaran aktif.
                        </p>

                    </div>

                </div>

            </div>

        @else

            <div class="flex flex-wrap items-center justify-between gap-4 bg-yellow-50 border border-yellow-200 rounded-2xl p-4 text-sm text-yellow-800">

                <p>
                    Belum ada tahun ajaran yang aktif. Aktifkan tahun ajaran oleh Waka Kurikulum agar data terstruktur.
                </p>

            </div>

        @endif

    </div>


    <!-- STATISTICS -->

    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Guru</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['guru'] }}</p>
                <p class="text-xs text-green-600 mt-1">{{ $stats['guruAktif'] }} aktif</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-4a4 4 0 100-8 4 4 0 000 8zm6 2a4 4 0 100-8 4 4 0 000 8z"/>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Mata Pelajaran</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['mapel'] }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5S19.832 5.477 21 6.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Kelas</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['kelas'] }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $stats['jurusan'] }} jurusan</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-cyan-50 flex items-center justify-center">
                <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Pengajaran</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['pengajaran'] }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $stats['laporan'] }} laporan</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
        </div>

    </div>


    <!-- ANALITIK -->

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Mapel per kelompok --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5">

            <h3 class="font-semibold text-gray-800">Mata Pelajaran per Kelompok</h3>
            <p class="text-xs text-gray-500 mt-0.5">Komposisi mapel berdasarkan kelompok</p>

            <div class="mt-4 space-y-3">

                @forelse($mapelPerKelompok as $row)

                    @php
                        $max = max($mapelPerKelompok->pluck('total')->push(1)->all());
                        $width = $row->total / $max * 100;
                    @endphp

                    <div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">{{ $row->kelompok }}</span>
                            <span class="font-semibold text-gray-800">{{ $row->total }}</span>
                        </div>
                        <div class="mt-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-500 rounded-full" style="width: {{ $width }}%"></div>
                        </div>
                    </div>

                @empty

                    <p class="text-sm text-gray-500">Belum ada data mata pelajaran.</p>

                @endforelse

            </div>

        </div>

        {{-- Kelas per tingkat --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5">

            <h3 class="font-semibold text-gray-800">Kelas per Tingkat</h3>
            <p class="text-xs text-gray-500 mt-0.5">Jumlah rombongan belajar per tingkat</p>

            <div class="mt-4 space-y-3">

                @forelse($kelasPerTingkat as $row)

                    @php
                        $max = max($kelasPerTingkat->pluck('total')->push(1)->all());
                        $width = $row->total / $max * 100;
                    @endphp

                    <div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Tingkat {{ $row->tingkat }}</span>
                            <span class="font-semibold text-gray-800">{{ $row->total }} kelas</span>
                        </div>
                        <div class="mt-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-purple-500 rounded-full" style="width: {{ $width }}%"></div>
                        </div>
                    </div>

                @empty

                    <p class="text-sm text-gray-500">Belum ada data kelas.</p>

                @endforelse

            </div>

        </div>

        {{-- Jadwal per hari --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5">

            <h3 class="font-semibold text-gray-800">Jadwal per Hari</h3>
            <p class="text-xs text-gray-500 mt-0.5">Distribusi jadwal pengajaran dalam seminggu</p>

            <div class="mt-4 space-y-3">

                @forelse($jadwalPerHari as $row)

                    @php
                        $max = max($jadwalPerHari->pluck('total')->push(1)->all());
                        $width = $row->total / $max * 100;
                    @endphp

                    <div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">{{ $row->hari }}</span>
                            <span class="font-semibold text-gray-800">{{ $row->total }} jadwal</span>
                        </div>
                        <div class="mt-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-amber-500 rounded-full" style="width: {{ $width }}%"></div>
                        </div>
                    </div>

                @empty

                    <p class="text-sm text-gray-500">Belum ada jadwal pengajaran.</p>

                @endforelse

            </div>

        </div>

    </div>


    <!-- BEBAN MENGAJAR & LAPORAN TERBARU -->

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Beban mengajar guru --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-semibold text-gray-800">Beban Mengajar Guru</h3>
                <span class="px-2.5 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full">
                    Jam / Minggu
                </span>
            </div>

            <div class="p-5">

                @forelse($bebanMengajar as $row)

                    <div class="flex items-center justify-between py-2 {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
                        <div class="flex items-center gap-3 min-w-0">
                            <span class="w-7 h-7 shrink-0 rounded-full bg-indigo-50 text-indigo-700 text-xs font-bold flex items-center justify-center">
                                {{ $loop->iteration }}
                            </span>
                            <p class="text-sm font-medium text-gray-800 truncate">{{ $row->guru?->nama ?? '-' }}</p>
                        </div>
                        <span class="text-sm font-semibold text-gray-700">{{ $row->total_jam }} jam</span>
                    </div>

                @empty

                    <p class="text-sm text-gray-500">Belum ada data pengajaran.</p>

                @endforelse

            </div>

        </div>

        {{-- Laporan terbaru --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-semibold text-gray-800">Laporan Pengajuan Terbaru</h3>
                <a href="{{ route('wakasek.laporan') }}"
                   class="inline-flex items-center gap-1 text-xs font-medium text-indigo-600 hover:text-indigo-700 transition">
                    Lihat semua
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <div class="p-5">

                @forelse($laporanTerbaru as $item)

                    @php
                        /** @var \App\Models\Laporan $item */
                    @endphp

                    <div class="flex items-center justify-between gap-3 py-2 {{ !$loop->last ? 'border-b border-gray-50' : '' }}">

                        <div class="min-w-0">

                            <p class="text-sm font-medium text-gray-800 truncate">{{ $item->judul }}</p>

                            <p class="text-xs text-gray-500 mt-0.5">
                                <span class="inline-flex px-2 py-0.5 text-[10px] font-medium rounded-full bg-indigo-50 text-indigo-700 mr-1">
                                    {{ $item->jenis }}
                                </span>
                                {{ $item->user?->name }} &bull; {{ $item->created_at->format('d M Y') }}
                            </p>

                        </div>

                        @if($item->file)
                            <a href="{{ Storage::url($item->file) }}"
                               target="_blank"
                               class="shrink-0 inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Unduh
                            </a>
                        @endif

                    </div>

                @empty

                    <p class="text-sm text-gray-500">Belum ada laporan pengajuan.</p>

                @endforelse

            </div>

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
                    Data guru, mata pelajaran, kelas, dan pengajaran dikelola oleh Waka Kurikulum.
                    Halaman ini bersifat pemantauan untuk meninjau jadwal dan laporan pengajuan.
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

                <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-medium rounded-full bg-slate-50 text-slate-700 border border-slate-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                    Wakasek
                </span>

            </div>

        </div>

    </div>

</x-app-layout>