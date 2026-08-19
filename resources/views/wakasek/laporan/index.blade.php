<x-app-layout>

    <x-slot name="header">

        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Laporan Pengajuan
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Peninjauan laporan pengajuan oleh Waka Kurikulum
            </p>
        </div>

    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">

                <div class="px-4 sm:px-6 py-4 border-b border-gray-200 flex flex-wrap items-center justify-between gap-4">

                    <h3 class="font-semibold text-gray-800">
                        Daftar Laporan
                    </h3>

                    <div class="flex flex-wrap items-center gap-3">

                        <form method="GET" action="{{ route('wakasek.laporan') }}" class="flex flex-col w-full gap-2 sm:flex-row sm:flex-wrap sm:items-center">

                            <div class="relative w-full sm:w-auto">
                                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <input
                                    type="text"
                                    name="q"
                                    value="{{ request('q') }}"
                                    placeholder="Cari judul / keterangan..."
                                    class="w-full sm:w-56 pl-9 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                >
                            </div>

                            <select
                                name="jenis"
                                onchange="this.form.submit()"
                                class="w-full sm:w-auto px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            >
                                <option value="">Semua Jenis</option>
                                @foreach(['Mata Pelajaran', 'Distribusi Pengajaran', 'Jadwal'] as $j)
                                    <option value="{{ $j }}" {{ request('jenis') === $j ? 'selected' : '' }}>
                                        {{ $j }}
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

                            @if(request('q') || request('jenis') || request('tahun_ajaran_id'))
                                <a href="{{ route('wakasek.laporan') }}"
                                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                                    Reset
                                </a>
                            @endif

                        </form>

                        <span class="px-2.5 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full">
                            {{ $laporan->total() }} laporan
                        </span>

                    </div>

                </div>

                <div class="hidden md:block overflow-x-auto">

                    <table class="w-full border-collapse">

                        <thead>
                            <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <th class="px-6 py-3">Judul</th>
                                <th class="px-6 py-3">Jenis</th>
                                <th class="px-6 py-3">Tahun Ajaran</th>
                                <th class="px-6 py-3">Pembuat</th>
                                <th class="px-6 py-3">Tanggal</th>
                                <th class="px-6 py-3">File</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @forelse($laporan as $item)

                                @php
                                    /** @var \App\Models\Laporan $item */
                                @endphp

                                <tr class="hover:bg-gray-50 transition">

                                    <td class="px-6 py-4">

                                        <p class="text-sm font-medium text-gray-800">
                                            {{ $item->judul }}
                                        </p>

                                        @if($item->keterangan)
                                            <p class="text-xs text-gray-500 mt-0.5 max-w-xs truncate">
                                                {{ $item->keterangan }}
                                            </p>
                                        @endif

                                    </td>

                                    <td class="px-6 py-4">

                                        @php
                                            $colors = [
                                                'Mata Pelajaran' => 'bg-indigo-50 text-indigo-700',
                                                'Distribusi Pengajaran' => 'bg-purple-50 text-purple-700',
                                                'Jadwal' => 'bg-cyan-50 text-cyan-700',
                                            ];
                                        @endphp

                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full {{ $colors[$item->jenis] ?? 'bg-gray-100 text-gray-700' }}">
                                            {{ $item->jenis }}
                                        </span>

                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $item->tahunAjaran?->tahun }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        {{ $item->user?->name }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $item->created_at->format('d M Y') }}
                                    </td>

                                    <td class="px-6 py-4">

                                        @if($item->file)

                                            <a href="{{ Storage::url($item->file) }}"
                                               target="_blank"
                                               class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                </svg>
                                                Download
                                            </a>

                                        @else

                                            <span class="text-xs text-gray-400">
                                                -
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                                <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </div>
                                            <p class="text-sm text-gray-500">
                                                Belum ada laporan pengajuan.
                                            </p>
                                        </div>
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="md:hidden divide-y divide-gray-100">

                    @forelse($laporan as $item)

                        @php
                            /** @var \App\Models\Laporan $item */
                            $colors = [
                                'Mata Pelajaran' => 'bg-indigo-50 text-indigo-700',
                                'Distribusi Pengajaran' => 'bg-purple-50 text-purple-700',
                                'Jadwal' => 'bg-cyan-50 text-cyan-700',
                            ];
                        @endphp

                        <div class="p-4">

                            <div class="flex items-start justify-between gap-3">

                                <div class="min-w-0">

                                    <p class="text-sm font-medium text-gray-800">
                                        {{ $item->judul }}
                                    </p>

                                    @if($item->keterangan)
                                        <p class="text-xs text-gray-500 mt-0.5">
                                            {{ $item->keterangan }}
                                        </p>
                                    @endif

                                </div>

                                <span class="shrink-0 inline-flex px-2.5 py-1 text-xs font-medium rounded-full {{ $colors[$item->jenis] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $item->jenis }}
                                </span>

                            </div>

                            <div class="mt-3 space-y-1 text-sm">

                                <p class="text-gray-600">
                                    <span class="text-gray-400">Tahun Ajaran:</span> {{ $item->tahunAjaran?->tahun }}
                                </p>

                                <p class="text-gray-600">
                                    <span class="text-gray-400">Pembuat:</span> {{ $item->user?->name }}
                                </p>

                                <p class="text-gray-600">
                                    <span class="text-gray-400">Tanggal:</span> {{ $item->created_at->format('d M Y') }}
                                </p>

                            </div>

                            <div class="mt-3">

                                @if($item->file)

                                    <a href="{{ Storage::url($item->file) }}"
                                       target="_blank"
                                       class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                        Download
                                    </a>

                                @else

                                    <span class="text-xs text-gray-400">
                                        Tidak ada file
                                    </span>

                                @endif

                            </div>

                        </div>

                    @empty

                        <div class="p-4">
                            <div class="flex flex-col items-center gap-3 py-8">
                                <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                    <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-500">
                                    Belum ada laporan pengajuan.
                                </p>
                            </div>
                        </div>

                    @endforelse

                </div>

                @if($laporan->hasPages())

                    <div class="px-4 sm:px-6 py-4 border-t border-gray-200">
                        {{ $laporan->links() }}
                    </div>

                @endif

            </div>

        </div>
    </div>

</x-app-layout>