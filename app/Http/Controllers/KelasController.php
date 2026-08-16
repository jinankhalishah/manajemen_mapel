<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KelasController extends Controller
{
    /**
     * Menampilkan daftar kelas.
     */
    public function index(Request $request)
    {
        $keyword = $request->query('q');
        $tingkat = $request->query('tingkat');
        $jurusanId = $request->query('jurusan_id');
        $tahunAjaranId = $request->query('tahun_ajaran_id');

        $kelas = Kelas::with(['jurusan', 'tahunAjaran'])
            ->withCount('pengajaran')
            ->when($keyword, fn($query) => $query->where('nama_kelas', 'like', "%{$keyword}%"))
            ->when($tingkat, fn($query) => $query->where('tingkat', $tingkat))
            ->when($jurusanId, fn($query) => $query->where('jurusan_id', $jurusanId))
            ->when($tahunAjaranId, fn($query) => $query->where('tahun_ajaran_id', $tahunAjaranId))
            ->orderBy('tahun_ajaran_id')
            ->orderBy('jurusan_id')
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->paginate(10)
            ->withQueryString();

        $jurusan = Jurusan::orderBy('kode')->get();
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();
        $tahunAjaranAktif = TahunAjaran::where('status', true)->first();

        return view(
            'waka-kurikulum.kelas.index',
            compact('kelas', 'jurusan', 'tahunAjaran', 'tahunAjaranAktif')
        );
    }

    /**
     * Aturan validasi kelas (kombinasi jurusan + tahun ajaran + nama unik).
     */
    protected function rules(Request $request, ?int $ignoreId = null): array
    {
        $unique = Rule::unique('kelas', 'nama_kelas')
            ->where(fn($query) => $query
                ->where('jurusan_id', $request->jurusan_id)
                ->where('tahun_ajaran_id', $request->tahun_ajaran_id));

        if ($ignoreId !== null) {
            $unique->ignore($ignoreId);
        }

        return [
            'jurusan_id' => ['required', 'exists:jurusan,id'],
            'tahun_ajaran_id' => ['required', 'exists:tahun_ajaran,id'],
            'tingkat' => ['required', 'in:X,XI,XII'],
            'nama_kelas' => ['required', 'string', 'max:50', $unique],
        ];
    }

    /**
     * Form tambah kelas.
     */
    public function create()
    {
        $jurusan = Jurusan::orderBy('kode')->get();
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();
        $tahunAjaranAktif = TahunAjaran::where('status', true)->first();

        return view(
            'waka-kurikulum.kelas.create',
            compact('jurusan', 'tahunAjaran', 'tahunAjaranAktif')
        );
    }

    /**
     * Menyimpan kelas baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules($request));

        Kelas::create($validated);

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Form edit kelas.
     */
    public function edit(Kelas $kelas)
    {
        $jurusan = Jurusan::orderBy('kode')->get();
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();
        $tahunAjaranAktif = TahunAjaran::where('status', true)->first();

        return view(
            'waka-kurikulum.kelas.edit',
            compact('kelas', 'jurusan', 'tahunAjaran', 'tahunAjaranAktif')
        );
    }

    /**
     * Memperbarui kelas.
     */
    public function update(Request $request, Kelas $kelas)
    {
        $validated = $request->validate(
            $this->rules($request, $kelas->id)
        );

        $kelas->update($validated);

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    /**
     * Menghapus kelas.
     */
    public function destroy(Kelas $kelas)
    {
        if ($kelas->pengajaran()->exists()) {
            return redirect()
                ->route('kelas.index')
                ->with('error', 'Kelas tidak dapat dihapus karena masih digunakan oleh data pengajaran.');
        }

        $kelas->delete();

        return redirect()
            ->route('kelas.index')
            ->with('success', 'Kelas berhasil dihapus.');
    }
}