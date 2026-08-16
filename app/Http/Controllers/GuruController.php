<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GuruController extends Controller
{
    /**
     * Menampilkan daftar guru.
     */
    public function index(Request $request)
    {
        $keyword = $request->query('q');
        $status = $request->query('status');

        $guru = Guru::withCount('pengajaran')
            ->when($keyword, fn($query) => $query
                ->where('nip', 'like', "%{$keyword}%")
                ->orWhere('nama', 'like', "%{$keyword}%"))
            ->when($status, fn($query) => $query->where('status', $status))
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        $totalAktif = Guru::where('status', 'Aktif')->count();

        return view(
            'waka-kurikulum.guru.index',
            compact('guru', 'totalAktif')
        );
    }

    /**
     * Aturan validasi guru.
     */
    protected function rules(Request $request, ?int $ignoreId = null): array
    {
        $uniqueNip = Rule::unique('guru', 'nip');
        $uniqueEmail = Rule::unique('guru', 'email');

        if ($ignoreId !== null) {
            $uniqueNip->ignore($ignoreId);
            $uniqueEmail->ignore($ignoreId);
        }

        return [
            'nip' => ['required', 'string', 'max:30', $uniqueNip],
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', $uniqueEmail],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'status' => ['required', 'in:Aktif,Tidak Aktif'],
        ];
    }

    /**
     * Form tambah guru.
     */
    public function create()
    {
        return view('waka-kurikulum.guru.create');
    }

    /**
     * Menyimpan guru baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules($request));

        Guru::create($validated);

        return redirect()
            ->route('guru.index')
            ->with('success', 'Guru berhasil ditambahkan.');
    }

    /**
     * Form edit guru.
     */
    public function edit(Guru $guru)
    {
        return view(
            'waka-kurikulum.guru.edit',
            compact('guru')
        );
    }

    /**
     * Memperbarui guru.
     */
    public function update(Request $request, Guru $guru)
    {
        $validated = $request->validate(
            $this->rules($request, $guru->id)
        );

        $guru->update($validated);

        return redirect()
            ->route('guru.index')
            ->with('success', 'Guru berhasil diperbarui.');
    }

    /**
     * Menghapus guru.
     */
    public function destroy(Guru $guru)
    {
        if ($guru->pengajaran()->exists()) {
            return redirect()
                ->route('guru.index')
                ->with('error', 'Guru tidak dapat dihapus karena masih memiliki data pengajaran.');
        }

        $guru->delete();

        return redirect()
            ->route('guru.index')
            ->with('success', 'Guru berhasil dihapus.');
    }
}