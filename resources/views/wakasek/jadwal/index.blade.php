<x-app-layout>

    <x-slot name="header">

        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Jadwal Pengajaran
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Pemantauan jadwal pengajaran sekolah
            </p>
        </div>

    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">

                <div class="px-4 sm:px-6 py-4 border-b border-gray-200 flex flex-wrap items-center justify-between gap-4">

                    <h3 class="font-semibold text-gray-800">
                        Jadwal Pengajaran
                    </h3>

                    <div class="flex flex-wrap items-center gap-3">

                        <form method="GET" action="{{ route('wakasek.jadwal') }}" class="flex flex-col w-full gap-2 sm:flex-row sm:flex-wrap sm:items-center">

                            <div class="relative w-full sm:w-auto">
                                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <input
                                    type="text"
                                    name="q"
                                    value="{{ request('q') }}"
                                    placeholder="Cari kelas / mapel / guru..."
                                    class="w-full sm:w-56 pl-9 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                >
                            </div>

                            <select
                                name="hari"
                                onchange="this.form.submit()"
                                class="w-full sm:w-auto px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            >
                                <option value="">Semua Hari</option>
                                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $h)
                                    <option value="{{ $h }}" {{ request('hari') === $h ? 'selected' : '' }}>
                                        {{ $h }}
                                    </option>
                                @endforeach
                            </select>

                            <select
                                name="kelas_id"
                                onchange="this.form.submit()"
                                class="w-full sm:w-auto px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            >
                                <option value="">Semua Kelas</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}"
                                        {{ (string) request('kelas_id') === (string) $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kelas }} ({{ $k->jurusan?->kode }})
                                    </option>
                                @endforeach
                            </select>

                            <select
                                name="tahun_ajaran_id"
                                onchange="this.form.submit()"
                                class="w-full sm:w-auto px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            >
                                <option value="">Semua Tahun Ajaran</option>
                                @foreach($tahunAjaran as $ta)
                                    <option value="{{ $ta->id }}"
                                        {{ (string) request('tahun_ajaran_id') === (string) $ta->id ? 'selected' : '' }}>
                                        {{ $ta->tahun }} ({{ $ta->semester }})
                                    </option>
                                @endforeach
                            </select>

                            <button type="submit"
                                    class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition">
                                Cari
                            </button>

                            @if(request('q') || request('hari') || request('kelas_id') || request('tahun_ajaran_id'))
                                <a href="{{ route('wakasek.jadwal') }}"
                                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                                    Reset
                                </a>
                            @endif

                        </form>

                        <span class="px-2.5 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full">
                            {{ $pengajaran->total() }} jadwal
                        </span>

                    </div>

                </div>

                <div class="hidden md:block overflow-x-auto">

                    <table class="w-full border-collapse">

                        <thead>
                            <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <th class="px-6 py-3">Kelas</th>
                                <th class="px-6 py-3">Mata Pelajaran</th>
                                <th class="px-6 py-3">Guru</th>
                                <th class="px-6 py-3">Hari</th>
                                <th class="px-6 py-3">Jam</th>
                                <th class="px-6 py-3">JPM</th>
                                <th class="px-6 py-3">Semester</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @forelse($pengajaran as $item)

                                <tr class="hover:bg-gray-50 transition">

                                    <td class="px-6 py-4">

                                        <p class="text-sm font-medium text-gray-800">
                                            {{ $item->kelas?->nama_kelas }}
                                        </p>

                                        <p class="text-xs text-gray-500">
                                            {{ $item->kelas?->jurusan?->kode }} &bull; {{ $item->tahunAjaran?->tahun }}
                                        </p>

                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $item->mataPelajaran?->nama }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $item->guru?->nama }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium bg-indigo-50 text-indigo-700 rounded-full">
                                            {{ $item->hari }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $item->jam_mulai->format('H:i') }} - {{ $item->jam_selesai->format('H:i') }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $item->jam_per_minggu }} jam
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full">
                                            {{ $item->semester }}
                                        </span>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                                <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <p class="text-sm text-gray-500">
                                                Belum ada jadwal pengajaran.
                                            </p>
                                        </div>
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="md:hidden divide-y divide-gray-100">

                    @forelse($pengajaran as $item)

                        <div class="p-4">

                            <div class="flex items-start justify-between gap-3">

                                <div class="min-w-0">

                                    <p class="text-sm font-medium text-gray-800">
                                        {{ $item->kelas?->nama_kelas }}
                                    </p>

                                    <p class="text-xs text-gray-500 mt-0.5">
                                        {{ $item->kelas?->jurusan?->kode }} &bull; {{ $item->tahunAjaran?->tahun }}
                                    </p>

                                </div>

                                <span class="shrink-0 inline-flex px-2.5 py-1 text-xs font-medium bg-indigo-50 text-indigo-700 rounded-full">
                                    {{ $item->hari }}
                                </span>

                            </div>

                            <div class="mt-3 space-y-1.5 text-sm">

                                <p class="text-gray-800">
                                    {{ $item->mataPelajaran?->nama }}
                                </p>

                                <p class="text-gray-600">
                                    {{ $item->guru?->nama }}
                                </p>

                                <div class="flex flex-wrap items-center gap-2 text-gray-600">

                                    <span class="inline-flex px-2.5 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full">
                                        {{ $item->jam_mulai->format('H:i') }} - {{ $item->jam_selesai->format('H:i') }}
                                    </span>

                                    <span class="inline-flex px-2.5 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full">
                                        {{ $item->jam_per_minggu }} jam
                                    </span>

                                    <span class="inline-flex px-2.5 py-1 text-xs font-medium bg-gray-100 text-gray-700 rounded-full">
                                        {{ $item->semester }}
                                    </span>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="p-4">
                            <div class="flex flex-col items-center gap-3 py-8">
                                <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                    <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-500">
                                    Belum ada jadwal pengajaran.
                                </p>
                            </div>
                        </div>

                    @endforelse

                </div>

                @if($pengajaran->hasPages())

                    <div class="px-4 sm:px-6 py-4 border-t border-gray-200">
                        {{ $pengajaran->links() }}
                    </div>

                @endif

            </div>

        </div>
    </div>

</x-app-layout>