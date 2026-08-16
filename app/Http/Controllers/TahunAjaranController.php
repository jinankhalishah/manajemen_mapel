<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TahunAjaranController extends Controller
{
    /**
     * Menampilkan daftar tahun ajaran.
     */
    public function index()
    {
        $tahunAjaran = TahunAjaran::orderByDesc('tahun')
            ->orderBy('semester')
            ->get();

        $tahunAjaranAktif = TahunAjaran::where('status', true)->first();

        return view(
            'waka-kurikulum.tahun-ajaran.index',
            compact('tahunAjaran', 'tahunAjaranAktif')
        );
    }

    /**
     * Aturan validasi tahun ajaran (kombinasi tahun + semester unik).
     */
    protected function rules(Request $request, ?int $ignoreId = null): array
    {
        $unique = Rule::unique('tahun_ajaran', 'tahun')
            ->where(fn($query) => $query->where('semester', $request->semester));

        if ($ignoreId !== null) {
            $unique->ignore($ignoreId);
        }

        return [
            'tahun' => [
                'required',
                'string',
                'regex:/^\d{4}\/\d{4}$/',
                $unique,
            ],
            'semester' => ['required', 'in:Ganjil,Genap'],
        ];
    }

    /**
     * Form tambah tahun ajaran.
     */
    public function create()
    {
        return view('waka-kurikulum.tahun-ajaran.create');
    }

    /**
     * Menyimpan tahun ajaran baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules($request));

        TahunAjaran::create([
            'tahun' => $validated['tahun'],
            'semester' => $validated['semester'],
            'status' => false,
        ]);

        return redirect()
            ->route('tahun-ajaran.index')
            ->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    /**
     * Menghapus tahun ajaran.
     */
    public function destroy(TahunAjaran $tahunAjaran)
    {
        if ($tahunAjaran->status) {
            return redirect()
                ->route('tahun-ajaran.index')
                ->with('error', 'Tahun ajaran yang sedang aktif tidak dapat dihapus. Aktifkan tahun ajaran lain terlebih dahulu.');
        }

        if ($tahunAjaran->kelas()->exists()) {
            return redirect()
                ->route('tahun-ajaran.index')
                ->with('error', 'Tahun ajaran tidak dapat dihapus karena sudah digunakan oleh data kelas.');
        }

        if ($tahunAjaran->pengajaran()->exists()) {
            return redirect()
                ->route('tahun-ajaran.index')
                ->with('error', 'Tahun ajaran tidak dapat dihapus karena sudah digunakan oleh data pengajaran.');
        }

        if ($tahunAjaran->laporan()->exists()) {
            return redirect()
                ->route('tahun-ajaran.index')
                ->with('error', 'Tahun ajaran tidak dapat dihapus karena sudah digunakan oleh data laporan.');
        }

        $tahunAjaran->delete();

        return redirect()
            ->route('tahun-ajaran.index')
            ->with('success', 'Tahun ajaran berhasil dihapus.');
    }

    /**
     * Mengaktifkan tahun ajaran.
     */
    public function aktifkan(TahunAjaran $tahunAjaran)
    {
        if ($tahunAjaran->status) {
            return redirect()
                ->route('tahun-ajaran.index')
                ->with('info', 'Tahun ajaran ini sudah aktif.');
        }

        // Menonaktifkan semua tahun ajaran terlebih dahulu
        TahunAjaran::query()->update([
            'status' => false,
        ]);

        // Mengaktifkan tahun ajaran yang dipilih
        $tahunAjaran->update([
            'status' => true,
        ]);

        return redirect()
            ->route('tahun-ajaran.index')
            ->with('success', 'Tahun ajaran berhasil diaktifkan.');
    }
}
