<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tambah Laporan
            </h2>

            <a href="{{ route('laporan.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">

                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-800">
                        Form Tambah Laporan
                    </h3>
                    <p class="text-sm text-gray-500 mt-0.5">
                        Buat laporan baru terkait pengajaran.
                    </p>
                </div>

                <div class="p-6">

                    <div class="mb-6 flex items-start gap-3 p-4 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-600">
                        <svg class="w-5 h-5 shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p>
                            Pembuat laporan otomatis terisi oleh akun Anda.
                            File pendukung opsional (PDF, Word, atau Excel, maksimal 2 MB).
                        </p>
                    </div>

                    <form action="{{ route('laporan.store') }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf

                        <div class="mb-5">

                            <label for="judul" class="block font-medium text-sm text-gray-700 mb-2">
                                Judul
                            </label>

                            <input
                                id="judul"
                                type="text"
                                name="judul"
                                value="{{ old('judul') }}"
                                placeholder="Contoh: Rekap Distribusi Guru Semester Ganjil"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                required
                            >

                            @error('judul')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">

                            <div>

                                <label for="jenis" class="block font-medium text-sm text-gray-700 mb-2">
                                    Jenis
                                </label>

                                <select
                                    id="jenis"
                                    name="jenis"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    required
                                >

                                    <option value="">
                                        -- Pilih Jenis --
                                    </option>

                                    @foreach(['Mata Pelajaran', 'Distribusi Pengajaran', 'Jadwal'] as $j)

                                        <option value="{{ $j }}"
                                            {{ old('jenis') == $j ? 'selected' : '' }}>
                                            {{ $j }}
                                        </option>

                                    @endforeach

                                </select>

                                @error('jenis')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                            </div>

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

                        </div>

                        <div class="mb-5">

                            <label for="keterangan" class="block font-medium text-sm text-gray-700 mb-2">
                                Keterangan <span class="text-gray-400 font-normal">(opsional)</span>
                            </label>

                            <textarea
                                id="keterangan"
                                name="keterangan"
                                rows="4"
                                placeholder="Catatan singkat terkait laporan."
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            >{{ old('keterangan') }}</textarea>

                            @error('keterangan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                        </div>

                        <div class="mb-6">

                            <label for="file" class="block font-medium text-sm text-gray-700 mb-2">
                                File Pendukung <span class="text-gray-400 font-normal">(opsional)</span>
                            </label>

                            <input
                                id="file"
                                type="file"
                                name="file"
                                accept=".pdf,.doc,.docx,.xls,.xlsx"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            >

                            @error('file')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                        </div>

                        <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">

                            <a href="{{ route('laporan.index') }}"
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