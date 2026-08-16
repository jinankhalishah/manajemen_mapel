<x-app-layout>

    <x-slot name="header">
        <div class="flex justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Mata Pelajaran
            </h2>

            <a href="{{ route('mata-pelajaran.index') }}"
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
                        Form Edit Mata Pelajaran
                    </h3>
                    <p class="text-sm text-gray-500 mt-0.5">
                        Perbarui data mata pelajaran {{ $mataPelajaran->kode }} - {{ $mataPelajaran->nama }}.
                    </p>
                </div>

                <div class="p-6">

                    <div class="mb-6 flex items-start gap-3 p-4 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-600">
                        <svg class="w-5 h-5 shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p>
                            Kode bersifat unik. Mengubah kelompok tidak memengaruhi data pengajaran yang sudah ada.
                        </p>
                    </div>

                    <form action="{{ route('mata-pelajaran.update', $mataPelajaran) }}"
                          method="POST">

                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">

                            <div>

                                <label for="kode" class="block font-medium text-sm text-gray-700 mb-2">
                                    Kode
                                </label>

                                <input
                                    id="kode"
                                    type="text"
                                    name="kode"
                                    value="{{ old('kode', $mataPelajaran->kode) }}"
                                    maxlength="20"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    required
                                >

                                @error('kode')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                            </div>

                            <div>

                                <label for="nama" class="block font-medium text-sm text-gray-700 mb-2">
                                    Nama
                                </label>

                                <input
                                    id="nama"
                                    type="text"
                                    name="nama"
                                    value="{{ old('nama', $mataPelajaran->nama) }}"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    required
                                >

                                @error('nama')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                            </div>

                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">

                            <div>

                                <label for="kelompok" class="block font-medium text-sm text-gray-700 mb-2">
                                    Kelompok
                                </label>

                                <select
                                    id="kelompok"
                                    name="kelompok"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    required
                                >

                                    @foreach(['Umum', 'Kejuruan', 'Muatan Lokal'] as $k)

                                        <option value="{{ $k }}"
                                            {{ old('kelompok', $mataPelajaran->kelompok) == $k ? 'selected' : '' }}>
                                            {{ $k }}
                                        </option>

                                    @endforeach

                                </select>

                                @error('kelompok')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                            </div>

                            <div>

                                <label for="status" class="block font-medium text-sm text-gray-700 mb-2">
                                    Status
                                </label>

                                <select
                                    id="status"
                                    name="status"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    required
                                >

                                    <option value="Aktif"
                                        {{ old('status', $mataPelajaran->status) == 'Aktif' ? 'selected' : '' }}>
                                        Aktif
                                    </option>

                                    <option value="Tidak Aktif"
                                        {{ old('status', $mataPelajaran->status) == 'Tidak Aktif' ? 'selected' : '' }}>
                                        Tidak Aktif
                                    </option>

                                </select>

                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                            </div>

                        </div>

                        <div class="mb-6">

                            <label for="deskripsi" class="block font-medium text-sm text-gray-700 mb-2">
                                Deskripsi <span class="text-gray-400 font-normal">(opsional)</span>
                            </label>

                            <textarea
                                id="deskripsi"
                                name="deskripsi"
                                rows="4"
                                placeholder="Deskripsi singkat mata pelajaran."
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                            >{{ old('deskripsi', $mataPelajaran->deskripsi) }}</textarea>

                            @error('deskripsi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                        </div>

                        <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">

                            <a href="{{ route('mata-pelajaran.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition">
                                Batal
                            </a>

                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan Perubahan
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>