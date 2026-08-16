<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tambah Pengajaran
            </h2>

            <a href="{{ route('pengajaran.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">

                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-800">
                        Form Tambah Pengajaran
                    </h3>
                    <p class="text-sm text-gray-500 mt-0.5">
                        Atur jadwal pengajaran guru pada kelas tertentu.
                    </p>
                </div>

                <div class="p-6">

                    <div class="mb-6 flex items-start gap-3 p-4 bg-indigo-50 border border-indigo-100 rounded-lg text-sm text-indigo-800">
                        <svg class="w-5 h-5 shrink-0 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p>
                            Pastikan kelas sesuai dengan tahun ajaran yang dipilih.
                            Sistem menolak jadwal bentrok (guru atau kelas mengajar pada hari dan jam yang sama).
                        </p>
                    </div>

                    <form action="{{ route('pengajaran.store') }}"
                          method="POST">

                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">

                            <div>

                                <label for="tahun_ajaran_id" class="block font-medium text-sm text-gray-700 mb-2">
                                    Tahun Ajaran
                                </label>

                                <select
                                    id="tahun_ajaran_id"
                                    name="tahun_ajaran_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    required
                                >

                                    <option value="">
                                        -- Pilih Tahun Ajaran --
                                    </option>

                                    @foreach($tahunAjaran as $ta)

                                        <option value="{{ $ta->id }}"
                                            {{ old('tahun_ajaran_id', $tahunAjaranAktif?->id) == $ta->id ? 'selected' : '' }}>
                                            {{ $ta->tahun }} ({{ $ta->semester }})
                                            {{ $ta->status ? ' - Aktif' : '' }}
                                        </option>

                                    @endforeach

                                </select>

                                @error('tahun_ajaran_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                            </div>

                            <div>

                                <label for="kelas_id" class="block font-medium text-sm text-gray-700 mb-2">
                                    Kelas
                                </label>

                                <select
                                    id="kelas_id"
                                    name="kelas_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    required
                                >

                                    <option value="">
                                        -- Pilih Kelas --
                                    </option>

                                    @foreach($kelas as $k)

                                        <option value="{{ $k->id }}"
                                            {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                            {{ $k->nama_kelas }} ({{ $k->jurusan?->kode }} - {{ $k->tahunAjaran?->tahun }})
                                        </option>

                                    @endforeach

                                </select>

                                @error('kelas_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                            </div>

                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">

                            <div>

                                <label for="mata_pelajaran_id" class="block font-medium text-sm text-gray-700 mb-2">
                                    Mata Pelajaran
                                </label>

                                <select
                                    id="mata_pelajaran_id"
                                    name="mata_pelajaran_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    required
                                >

                                    <option value="">
                                        -- Pilih Mata Pelajaran --
                                    </option>

                                    @foreach($mataPelajaran as $mp)

                                        <option value="{{ $mp->id }}"
                                            {{ old('mata_pelajaran_id') == $mp->id ? 'selected' : '' }}>
                                            {{ $mp->nama }} ({{ $mp->kode }})
                                        </option>

                                    @endforeach

                                </select>

                                @error('mata_pelajaran_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                            </div>

                            <div>

                                <label for="guru_id" class="block font-medium text-sm text-gray-700 mb-2">
                                    Guru
                                </label>

                                <select
                                    id="guru_id"
                                    name="guru_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    required
                                >

                                    <option value="">
                                        -- Pilih Guru --
                                    </option>

                                    @foreach($guru as $g)

                                        <option value="{{ $g->id }}"
                                            {{ old('guru_id') == $g->id ? 'selected' : '' }}>
                                            {{ $g->nama }} ({{ $g->nip }})
                                        </option>

                                    @endforeach

                                </select>

                                @error('guru_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                            </div>

                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-5">

                            <div>

                                <label for="hari" class="block font-medium text-sm text-gray-700 mb-2">
                                    Hari
                                </label>

                                <select
                                    id="hari"
                                    name="hari"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    required
                                >

                                    <option value="">
                                        -- Pilih Hari --
                                    </option>

                                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $h)

                                        <option value="{{ $h }}"
                                            {{ old('hari') == $h ? 'selected' : '' }}>
                                            {{ $h }}
                                        </option>

                                    @endforeach

                                </select>

                                @error('hari')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                            </div>

                            <div>

                                <label for="jam_mulai" class="block font-medium text-sm text-gray-700 mb-2">
                                    Jam Mulai
                                </label>

                                <input
                                    id="jam_mulai"
                                    type="time"
                                    name="jam_mulai"
                                    value="{{ old('jam_mulai') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    required
                                >

                                @error('jam_mulai')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                            </div>

                            <div>

                                <label for="jam_selesai" class="block font-medium text-sm text-gray-700 mb-2">
                                    Jam Selesai
                                </label>

                                <input
                                    id="jam_selesai"
                                    type="time"
                                    name="jam_selesai"
                                    value="{{ old('jam_selesai') }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    required
                                >

                                @error('jam_selesai')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                            </div>

                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-6">

                            <div>

                                <label for="jam_per_minggu" class="block font-medium text-sm text-gray-700 mb-2">
                                    Jam Per Minggu
                                </label>

                                <input
                                    id="jam_per_minggu"
                                    type="number"
                                    name="jam_per_minggu"
                                    value="{{ old('jam_per_minggu') }}"
                                    min="1"
                                    max="40"
                                    placeholder="Contoh: 2"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    required
                                >

                                @error('jam_per_minggu')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                            </div>

                            <div>

                                <label for="semester" class="block font-medium text-sm text-gray-700 mb-2">
                                    Semester
                                </label>

                                <select
                                    id="semester"
                                    name="semester"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    required
                                >

                                    <option value="">
                                        -- Pilih Semester --
                                    </option>

                                    @foreach(['Ganjil', 'Genap'] as $s)

                                        <option value="{{ $s }}"
                                            {{ old('semester') == $s ? 'selected' : '' }}>
                                            {{ $s }}
                                        </option>

                                    @endforeach

                                </select>

                                @error('semester')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                            </div>

                        </div>

                        <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">

                            <a href="{{ route('pengajaran.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition">
                                Batal
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>