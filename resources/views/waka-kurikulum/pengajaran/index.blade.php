<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Pengajaran
            </h2>

            <div class="flex flex-wrap items-center gap-3">

                <a href="{{ route('pengajaran.cetak', $filter ? ['tahun_ajaran_id' => $filter] : []) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Cetak Jadwal
                </a>

                <a href="{{ route('pengajaran.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Pengajaran
                </a>

            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 flex items-start gap-3 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 flex items-start gap-3 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm">{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">

                <div class="px-4 sm:px-6 py-4 border-b border-gray-200 flex flex-wrap items-center justify-between gap-4">

                    <h3 class="font-semibold text-gray-800">
                        Jadwal Pengajaran
                    </h3>

                    <div class="flex flex-wrap items-center gap-3">

                        <form method="GET" action="{{ route('pengajaran.index') }}" class="flex flex-col w-full gap-2 sm:flex-row sm:items-center">

                            <select
                                name="tahun_ajaran_id"
                                onchange="this.form.submit()"
                                class="w-full sm:w-auto px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            >

                                <option value="">
                                    Semua Tahun Ajaran
                                </option>

                                @foreach($tahunAjaran as $ta)

                                    <option value="{{ $ta->id }}"
                                        {{ (string) $filter === (string) $ta->id ? 'selected' : '' }}>
                                        {{ $ta->tahun }} ({{ $ta->semester }})
                                    </option>

                                @endforeach

                            </select>

                            @if($filter)

                                <a href="{{ route('pengajaran.index') }}"
                                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                                    Reset
                                </a>

                            @endif

                        </form>

                        <span class="px-2.5 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full">
                            {{ $pengajaran->count() }} jadwal
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
                                <th class="px-6 py-3 text-right">Aksi</th>
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

                                    <td class="px-6 py-4">

                                        <div class="flex justify-end gap-2">

                                            <a href="{{ route('pengajaran.edit', $item) }}"
                                               class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Edit
                                            </a>

                                            <form action="{{ route('pengajaran.destroy', $item) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus data pengajaran ini?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Hapus
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="8" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                                <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <p class="text-sm text-gray-500">
                                                Belum ada data pengajaran.
                                            </p>
                                            <a href="{{ route('pengajaran.create') }}"
                                               class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                </svg>
                                                Tambah Pengajaran
                                            </a>
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

                            <div class="mt-3 flex flex-wrap gap-2">

                                <a href="{{ route('pengajaran.edit', $item) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>

                                <form action="{{ route('pengajaran.destroy', $item) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus data pengajaran ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>

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
                                    Belum ada data pengajaran.
                                </p>
                                <a href="{{ route('pengajaran.create') }}"
                                   class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Tambah Pengajaran
                                </a>
                            </div>
                        </div>

                    @endforelse

                </div>

            </div>

        </div>
    </div>

</x-app-layout>