<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tahun Ajaran
            </h2>

            <a href="{{ route('tahun-ajaran.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Tahun Ajaran
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Pesan sukses --}}
            @if(session('success'))
                <div class="mb-4 flex items-start gap-3 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Pesan error --}}
            @if(session('error'))
                <div class="mb-4 flex items-start gap-3 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm">{{ session('error') }}</p>
                </div>
            @endif

            {{-- Pesan info --}}
            @if(session('info'))
                <div class="mb-4 flex items-start gap-3 p-4 bg-blue-50 border border-blue-200 text-blue-800 rounded-xl">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm">{{ session('info') }}</p>
                </div>
            @endif

            {{-- Info tahun ajaran aktif --}}
            @if($tahunAjaranAktif)

                <div class="mb-6 flex items-center justify-between gap-4 bg-indigo-50 border border-indigo-200 rounded-xl p-4">

                    <div class="flex items-center gap-3">

                        <span class="relative flex h-3 w-3 shrink-0">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                        </span>

                        <p class="text-sm text-indigo-900">
                            Tahun Ajaran Aktif:
                            <strong>{{ $tahunAjaranAktif->tahun }} - Semester {{ $tahunAjaranAktif->semester }}</strong>
                        </p>

                    </div>

                    <p class="text-xs text-indigo-600 shrink-0">
                        Hanya satu tahun ajaran yang dapat aktif pada satu waktu.
                    </p>

                </div>

            @else

                <div class="mb-6 flex items-start gap-3 bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-sm text-yellow-800">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <p>
                        Belum ada tahun ajaran yang aktif. Gunakan tombol
                        <strong>Aktifkan</strong> untuk memilih tahun ajaran yang sedang berjalan.
                    </p>
                </div>

            @endif

            <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">

                <div class="px-4 sm:px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-800">
                        Daftar Tahun Ajaran
                    </h3>
                    <span class="px-2.5 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full">
                        {{ $tahunAjaran->count() }} data
                    </span>
                </div>

                <div class="hidden md:block overflow-x-auto">

                    <table class="w-full border-collapse">

                        <thead>
                            <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <th class="px-6 py-3">No</th>
                                <th class="px-6 py-3">Tahun Ajaran</th>
                                <th class="px-6 py-3">Semester</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @forelse($tahunAjaran as $item)

                                <tr class="hover:bg-gray-50 transition">

                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                        {{ $item->tahun }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $item->semester }}
                                    </td>

                                    <td class="px-6 py-4">

                                        @if($item->status)

                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                                Aktif
                                            </span>

                                        @else

                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium bg-gray-100 text-gray-500 rounded-full">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                                Tidak Aktif
                                            </span>

                                        @endif

                                    </td>

                                    <td class="px-6 py-4">

                                        <div class="flex justify-end gap-2">

                                            @if(!$item->status)

                                                <form action="{{ route('tahun-ajaran.aktifkan', $item) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')

                                                    <button type="submit"
                                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                        </svg>
                                                        Aktifkan
                                                    </button>

                                                </form>

                                            @endif

                                            <form action="{{ route('tahun-ajaran.destroy', $item) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus tahun ajaran ini?')">
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
                                    <td colspan="5" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                                <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                            <p class="text-sm text-gray-500">
                                                Belum ada data tahun ajaran.
                                            </p>
                                            <a href="{{ route('tahun-ajaran.create') }}"
                                               class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                </svg>
                                                Tambah Tahun Ajaran
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="md:hidden divide-y divide-gray-100">

                    @forelse($tahunAjaran as $item)

                        <div class="p-4">

                            <div class="flex items-start justify-between gap-3">

                                <div class="min-w-0">

                                    <p class="text-sm font-medium text-gray-800">
                                        {{ $item->tahun }}
                                    </p>

                                    <p class="text-sm text-gray-500 mt-0.5">
                                        Semester {{ $item->semester }}
                                    </p>

                                </div>

                                @if($item->status)

                                    <span class="shrink-0 inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                        Aktif
                                    </span>

                                @else

                                    <span class="shrink-0 inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium bg-gray-100 text-gray-500 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                        Tidak Aktif
                                    </span>

                                @endif

                            </div>

                            <div class="mt-3 flex flex-wrap gap-2">

                                @if(!$item->status)

                                    <form action="{{ route('tahun-ajaran.aktifkan', $item) }}" method="POST">
                                        @csrf
                                        @method('PATCH')

                                        <button type="submit"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                            </svg>
                                            Aktifkan
                                        </button>
                                    </form>

                                @endif

                                <form action="{{ route('tahun-ajaran.destroy', $item) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus tahun ajaran ini?')">
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
                                    Belum ada data tahun ajaran.
                                </p>
                                <a href="{{ route('tahun-ajaran.create') }}"
                                   class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Tambah Tahun Ajaran
                                </a>
                            </div>
                        </div>

                    @endforelse

                </div>

            </div>

        </div>
    </div>

</x-app-layout>