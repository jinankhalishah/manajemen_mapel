<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JurusanController extends Controller
{
    /**
     * Menampilkan daftar jurusan.
     */
    public function index(Request $request)
    {
        $keyword = $request->query('q');

        $jurusan = Jurusan::withCount('kelas')
            ->when($keyword, fn($query) => $query
                ->where('kode', 'like', "%{$keyword}%")
                ->orWhere('nama', 'like', "%{$keyword}%")
                ->orWhere('deskripsi', 'like', "%{$keyword}%"))
            ->orderBy('kode')
            ->paginate(10)
            ->withQueryString();

        return view('waka-kurikulum.jurusan.index', compact('jurusan'));
    }

    /**
     * Aturan validasi jurusan (kode unik).
     */
    protected function rules(Request $request, ?int $ignoreId = null): array
    {
        $unique = Rule::unique('jurusan', 'kode');

        if ($ignoreId !== null) {
            $unique->ignore($ignoreId);
        }

        return [
            'kode' => ['required', 'string', 'max:20', 'alpha_dash', $unique],
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
        ];
    }

    /**
     * Form tambah jurusan.
     */
    public function create()
    {
        return view('waka-kurikulum.jurusan.create');
    }

    /**
     * Menyimpan jurusan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules($request));

        Jurusan::create($validated);

        return redirect()
            ->route('jurusan.index')
            ->with('success', 'Jurusan berhasil ditambahkan.');
    }

    /**
     * Form edit jurusan.
     */
    public function edit(Jurusan $jurusan)
    {
        return view(
            'waka-kurikulum.jurusan.edit',
            compact('jurusan')
        );
    }

    /**
     * Memperbarui jurusan.
     */
    public function update(Request $request, Jurusan $jurusan)
    {
        $validated = $request->validate(
            $this->rules($request, $jurusan->id)
        );

        $jurusan->update($validated);

        return redirect()
            ->route('jurusan.index')
            ->with('success', 'Jurusan berhasil diperbarui.');
    }

    /**
     * Menghapus jurusan.
     */
    public function destroy(Jurusan $jurusan)
    {
        if ($jurusan->kelas()->exists()) {
            return redirect()
                ->route('jurusan.index')
                ->with('error', 'Jurusan tidak dapat dihapus karena masih digunakan oleh data kelas.');
        }

        $jurusan->delete();

        return redirect()
            ->route('jurusan.index')
            ->with('success', 'Jurusan berhasil dihapus.');
    }
}