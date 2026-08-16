<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MataPelajaranController extends Controller
{
    /**
     * Menampilkan daftar mata pelajaran.
     */
    public function index(Request $request)
    {
        $keyword = $request->query('q');
        $kelompok = $request->query('kelompok');
        $status = $request->query('status');

        $mataPelajaran = MataPelajaran::withCount('pengajaran')
            ->when($keyword, fn($query) => $query
                ->where('kode', 'like', "%{$keyword}%")
                ->orWhere('nama', 'like', "%{$keyword}%"))
            ->when($kelompok, fn($query) => $query->where('kelompok', $kelompok))
            ->when($status, fn($query) => $query->where('status', $status))
            ->orderBy('kode')
            ->paginate(10)
            ->withQueryString();

        return view(
            'waka-kurikulum.mata-pelajaran.index',
            compact('mataPelajaran')
        );
    }

    /**
     * Aturan validasi mata pelajaran.
     */
    protected function rules(Request $request, ?int $ignoreId = null): array
    {
        $unique = Rule::unique('mata_pelajaran', 'kode');

        if ($ignoreId !== null) {
            $unique->ignore($ignoreId);
        }

        return [
            'kode' => ['required', 'string', 'max:20', 'alpha_dash', $unique],
            'nama' => ['required', 'string', 'max:255'],
            'kelompok' => ['required', 'in:Umum,Kejuruan,Muatan Lokal'],
            'deskripsi' => ['nullable', 'string'],
            'status' => ['required', 'in:Aktif,Tidak Aktif'],
        ];
    }

    /**
     * Form tambah mata pelajaran.
     */
    public function create()
    {
        return view('waka-kurikulum.mata-pelajaran.create');
    }

    /**
     * Menyimpan mata pelajaran baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules($request));

        MataPelajaran::create($validated);

        return redirect()
            ->route('mata-pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    /**
     * Form edit mata pelajaran.
     */
    public function edit(MataPelajaran $mataPelajaran)
    {
        return view(
            'waka-kurikulum.mata-pelajaran.edit',
            compact('mataPelajaran')
        );
    }

    /**
     * Memperbarui mata pelajaran.
     */
    public function update(Request $request, MataPelajaran $mataPelajaran)
    {
        $validated = $request->validate(
            $this->rules($request, $mataPelajaran->id)
        );

        $mataPelajaran->update($validated);

        return redirect()
            ->route('mata-pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    /**
     * Menghapus mata pelajaran.
     */
    public function destroy(MataPelajaran $mataPelajaran)
    {
        if ($mataPelajaran->pengajaran()->exists()) {
            return redirect()
                ->route('mata-pelajaran.index')
                ->with('error', 'Mata pelajaran tidak dapat dihapus karena masih digunakan oleh data pengajaran.');
        }

        $mataPelajaran->delete();

        return redirect()
            ->route('mata-pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}