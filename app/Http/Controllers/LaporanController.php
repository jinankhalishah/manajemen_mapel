<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LaporanController extends Controller
{
    /**
     * Menampilkan daftar laporan.
     */
    public function index(Request $request)
    {
        $keyword = $request->query('q');
        $jenis = $request->query('jenis');
        $tahunAjaranId = $request->query('tahun_ajaran_id');

        $laporan = Laporan::with(['user', 'tahunAjaran'])
            ->when($keyword, fn($query) => $query
                ->where('judul', 'like', "%{$keyword}%")
                ->orWhere('keterangan', 'like', "%{$keyword}%"))
            ->when($jenis, fn($query) => $query->where('jenis', $jenis))
            ->when($tahunAjaranId, fn($query) => $query->where('tahun_ajaran_id', $tahunAjaranId))
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();

        return view(
            'waka-kurikulum.laporan.index',
            compact('laporan', 'tahunAjaran')
        );
    }

    /**
     * Form tambah laporan.
     */
    public function create()
    {
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();
        $tahunAjaranAktif = TahunAjaran::where('status', true)->first();

        return view('waka-kurikulum.laporan.create', [
            'tahunAjaran' => $tahunAjaran,
            'tahunAjaranAktif' => $tahunAjaranAktif,
        ]);
    }

    /**
     * Menyimpan laporan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun_ajaran_id' => ['required', 'exists:tahun_ajaran,id'],
            'judul' => ['required', 'string', 'max:255'],
            'jenis' => [
                'required',
                Rule::in(['Mata Pelajaran', 'Distribusi Pengajaran', 'Jadwal']),
            ],
            'keterangan' => ['nullable', 'string'],
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx', 'max:2048'],
        ]);

        $data = [
            'user_id' => $request->user()->id,
            'tahun_ajaran_id' => $validated['tahun_ajaran_id'],
            'judul' => $validated['judul'],
            'jenis' => $validated['jenis'],
            'keterangan' => $validated['keterangan'] ?? null,
        ];

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('laporan', 'public');
        }

        Laporan::create($data);

        return redirect()
            ->route('laporan.index')
            ->with('success', 'Laporan berhasil ditambahkan.');
    }

    /**
     * Menghapus laporan.
     */
    public function destroy(Laporan $laporan)
    {
        if ($laporan->file && \Storage::disk('public')->exists($laporan->file)) {
            \Storage::disk('public')->delete($laporan->file);
        }

        $laporan->delete();

        return redirect()
            ->route('laporan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}