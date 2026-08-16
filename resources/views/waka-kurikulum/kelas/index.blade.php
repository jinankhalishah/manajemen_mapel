<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Kelas
            </h2>

            <a href="{{ route('kelas.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Kelas
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

            {{-- Info tahun ajaran aktif --}}
            @if($tahunAjaranAktif)

                <div class="mb-6 flex items-center gap-3 bg-indigo-50 border border-indigo-200 rounded-xl p-4">

                    <span class="relative flex h-3 w-3 shrink-0">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                    </span>

                    <p class="text-sm text-indigo-900">
                        Tahun Ajaran Aktif:
                        <strong>{{ $tahunAjaranAktif->tahun }} - Semester {{ $tahunAjaranAktif->semester }}</strong>.
                        Daftar kelas di bawah mencakup seluruh tahun ajaran.
                    </p>

                </div>

            @else

                <div class="mb-6 flex items-start gap-3 bg-yellow-50 border border-yellow-200 rounded-xl p-4 text-sm text-yellow-800">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <p>
                        Belum ada tahun ajaran yang aktif. Aktifkan tahun ajaran terlebih dahulu agar data kelas terstruktur dengan benar.
                    </p>
                </div>

            @endif

            <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">

                <div class="px-6 py-4 border-b border-gray-200 flex flex-wrap items-center justify-between gap-4">

                    <h3 class="font-semibold text-gray-800">
                        Daftar Kelas
                    </h3>

                    <div class="flex flex-wrap items-center gap-3">

                        <form method="GET" action="{{ route('kelas.index') }}" class="flex flex-wrap items-center gap-2">

                            <div class="relative">
                                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                <input
                                    type="text"
                                    name="q"
                                    value="{{ request('q') }}"
                                    placeholder="Cari nama kelas..."
                                    class="pl-9 pr-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                >
                            </div>

                            <select
                                name="tingkat"
                                onchange="this.form.submit()"
                                class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            >
                                <option value="">Semua Tingkat</option>
                                @foreach(['X', 'XI', 'XII'] as $t)
                                    <option value="{{ $t }}" {{ request('tingkat') === $t ? 'selected' : '' }}>
                                        {{ $t }}
                                    </option>
                                @endforeach
                            </select>

                            <select
                                name="jurusan_id"
                                onchange="this.form.submit()"
                                class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            >
                                <option value="">Semua Jurusan</option>
                                @foreach($jurusan as $j)
                                    <option value="{{ $j->id }}"
                                        {{ (string) request('jurusan_id') === (string) $j->id ? 'selected' : '' }}>
                                        {{ $j->kode }} - {{ $j->nama }}
                                    </option>
                                @endforeach
                            </select>

                            <select
                                name="tahun_ajaran_id"
                                onchange="this.form.submit()"
                                class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
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
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition">
                                Cari
                            </button>

                            @if(request('q') || request('tingkat') || request('jurusan_id') || request('tahun_ajaran_id'))
                                <a href="{{ route('kelas.index') }}"
                                   class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition">
                                    Reset
                                </a>
                            @endif

                        </form>

                        <span class="px-2.5 py-1 text-xs font-medium bg-gray-100 text-gray-600 rounded-full">
                            {{ $kelas->total() }} data
                        </span>

                    </div>

                </div>

                <div class="overflow-x-auto">

                    <table class="w-full border-collapse">

                        <thead>
                            <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                <th class="px-6 py-3">No</th>
                                <th class="px-6 py-3">Nama Kelas</th>
                                <th class="px-6 py-3">Tingkat</th>
                                <th class="px-6 py-3">Jurusan</th>
                                <th class="px-6 py-3">Tahun Ajaran</th>
                                <th class="px-6 py-3">Pengajaran</th>
                                <th class="px-6 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                            @forelse($kelas as $item)

                                <tr class="hover:bg-gray-50 transition">

                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                        {{ $item->nama_kelas }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="inline-flex px-2.5 py-1 text-xs font-semibold bg-gray-100 text-gray-700 rounded-md">
                                            {{ $item->tingkat }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        <span class="inline-flex px-2.5 py-1 text-xs font-semibold bg-indigo-50 text-indigo-700 rounded-md mr-1.5">
                                            {{ $item->jurusan->kode }}
                                        </span>
                                        {{ $item->jurusan->nama }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $item->tahunAjaran->tahun }} - Semester {{ $item->tahunAjaran->semester }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $item->pengajaran_count }} jadwal
                                    </td>

                                    <td class="px-6 py-4">

                                        <div class="flex justify-end gap-2">

                                            <a href="{{ route('kelas.edit', $item) }}"
                                               class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                                Edit
                                            </a>

                                            <form action="{{ route('kelas.destroy', $item) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
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
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                                                <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                                </svg>
                                            </div>
                                            <p class="text-sm text-gray-500">
                                                Belum ada data kelas.
                                            </p>
                                            <a href="{{ route('kelas.create') }}"
                                               class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                </svg>
                                                Tambah Kelas
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                @if($kelas->hasPages())

                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $kelas->links() }}
                    </div>

                @endif

            </div>

        </div>
    </div>

</x-app-layout>