<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Pengajaran;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PengajaranController extends Controller
{
    /**
     * Menampilkan daftar pengajaran.
     */
    public function index(Request $request)
    {
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();

        $filter = $request->query('tahun_ajaran_id');

        $pengajaran = Pengajaran::with(['tahunAjaran', 'kelas.jurusan', 'mataPelajaran', 'guru'])
            ->when($filter, fn ($query) => $query->where('tahun_ajaran_id', $filter))
            ->get()
            ->sortBy([
                fn ($item) => $item->kelas->nama_kelas ?? '',
                fn ($item) => $item->hari,
                fn ($item) => $item->jam_mulai->format('H:i'),
            ]);

        return view('waka-kurikulum.pengajaran.index', [
            'tahunAjaran' => $tahunAjaran,
            'pengajaran' => $pengajaran,
            'filter' => $filter,
        ]);
    }

    /**
     * Aturan validasi pengajaran.
     */
    protected function rules(Request $request, ?int $ignoreId = null): array
    {
        return [
            'tahun_ajaran_id' => ['required', 'exists:tahun_ajaran,id'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'mata_pelajaran_id' => ['required', 'exists:mata_pelajaran,id'],
            'guru_id' => ['required', 'exists:guru,id'],
            'hari' => ['required', Rule::in(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'])],
            'jam_mulai' => ['required', 'date_format:H:i'],
            'jam_selesai' => ['required', 'date_format:H:i', 'after:jam_mulai'],
            'jam_per_minggu' => ['required', 'integer', 'min:1', 'max:40'],
            'semester' => ['required', Rule::in(['Ganjil', 'Genap'])],
        ];
    }

    /**
     * Cek bentrok jadwal untuk guru atau kelas pada hari & jam yang sama.
     */
    protected function hasConflict(Request $request, ?int $ignoreId = null): bool
    {
        $query = Pengajaran::where('tahun_ajaran_id', $request->tahun_ajaran_id)
            ->where('hari', $request->hari)
            ->where('jam_mulai', '<', $request->jam_selesai)
            ->where('jam_selesai', '>', $request->jam_mulai);

        if ($ignoreId !== null) {
            $query->where('id', '!=', $ignoreId);
        }

        $guruBentrok = (clone $query)->where('guru_id', $request->guru_id)->exists();
        $kelasBentrok = (clone $query)->where('kelas_id', $request->kelas_id)->exists();

        return $guruBentrok || $kelasBentrok;
    }

    /**
     * Form tambah pengajaran.
     */
    public function create()
    {
        return $this->formData();
    }

    /**
     * Data umum yang dibutuhkan form tambah & edit.
     */
    protected function formData()
    {
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();
        $kelas = Kelas::with(['jurusan', 'tahunAjaran'])
            ->orderBy('nama_kelas')
            ->get();
        $mataPelajaran = MataPelajaran::where('status', 'Aktif')
            ->orderBy('nama')
            ->get();
        $guru = Guru::where('status', 'Aktif')
            ->orderBy('nama')
            ->get();
        $tahunAjaranAktif = TahunAjaran::where('status', true)->first();

        return view('waka-kurikulum.pengajaran.create', [
            'tahunAjaran' => $tahunAjaran,
            'kelas' => $kelas,
            'mataPelajaran' => $mataPelajaran,
            'guru' => $guru,
            'tahunAjaranAktif' => $tahunAjaranAktif,
        ]);
    }

    /**
     * Menyimpan pengajaran baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules($request));

        if ($this->hasConflict($request)) {
            return back()
                ->withErrors([
                    'jam_mulai' => 'Jadwal bentrok: guru atau kelas sudah memiliki pengajaran pada hari dan jam tersebut.',
                ])
                ->withInput();
        }

        Pengajaran::create($validated);

        return redirect()
            ->route('pengajaran.index')
            ->with('success', 'Data pengajaran berhasil ditambahkan.');
    }

    /**
     * Form edit pengajaran.
     */
    public function edit(Pengajaran $pengajaran)
    {
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();
        $kelas = Kelas::with(['jurusan', 'tahunAjaran'])
            ->orderBy('nama_kelas')
            ->get();
        $mataPelajaran = MataPelajaran::orderBy('nama')->get();
        $guru = Guru::orderBy('nama')->get();
        $tahunAjaranAktif = TahunAjaran::where('status', true)->first();

        return view('waka-kurikulum.pengajaran.edit', [
            'pengajaran' => $pengajaran,
            'tahunAjaran' => $tahunAjaran,
            'kelas' => $kelas,
            'mataPelajaran' => $mataPelajaran,
            'guru' => $guru,
            'tahunAjaranAktif' => $tahunAjaranAktif,
        ]);
    }

    /**
     * Memperbarui pengajaran.
     */
    public function update(Request $request, Pengajaran $pengajaran)
    {
        $validated = $request->validate($this->rules($request, $pengajaran->id));

        if ($this->hasConflict($request, $pengajaran->id)) {
            return back()
                ->withErrors([
                    'jam_mulai' => 'Jadwal bentrok: guru atau kelas sudah memiliki pengajaran pada hari dan jam tersebut.',
                ])
                ->withInput();
        }

        $pengajaran->update($validated);

        return redirect()
            ->route('pengajaran.index')
            ->with('success', 'Data pengajaran berhasil diperbarui.');
    }

    /**
     * Menghapus pengajaran.
     */
    public function destroy(Pengajaran $pengajaran)
    {
        $pengajaran->delete();

        return redirect()
            ->route('pengajaran.index')
            ->with('success', 'Data pengajaran berhasil dihapus.');
    }

    /**
     * Menampilkan jadwal pengajaran dalam format siap cetak / PDF.
     */
    public function cetak(Request $request)
    {
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();
        $kelas = Kelas::with(['jurusan', 'tahunAjaran'])
            ->orderBy('nama_kelas')
            ->get();

        $filterTahun = $request->query('tahun_ajaran_id');
        $filterKelas = $request->query('kelas_id');

        $hariOrder = ['Senin' => 1, 'Selasa' => 2, 'Rabu' => 3, 'Kamis' => 4, 'Jumat' => 5, 'Sabtu' => 6];

        $pengajaran = Pengajaran::with(['tahunAjaran', 'kelas.jurusan', 'mataPelajaran', 'guru'])
            ->when($filterTahun, fn ($query) => $query->where('tahun_ajaran_id', $filterTahun))
            ->when($filterKelas, fn ($query) => $query->where('kelas_id', $filterKelas))
            ->get()
            ->groupBy('kelas_id')
            ->map(function ($items) use ($hariOrder) {
                return $items->sortBy([
                    fn ($item) => $hariOrder[$item->hari] ?? 99,
                    fn ($item) => $item->jam_mulai->format('H:i'),
                ]);
            })
            ->sortBy(fn ($items) => $items->first()->kelas->nama_kelas);

        $tahunAktif = TahunAjaran::where('status', true)->first();

        return view('waka-kurikulum.pengajaran.print', [
            'rows' => $pengajaran,
            'tahunAjaran' => $tahunAjaran,
            'kelas' => $kelas,
            'filterTahun' => $filterTahun,
            'filterKelas' => $filterKelas,
            'tahunAktif' => $tahunAktif,
        ]);
    }
}