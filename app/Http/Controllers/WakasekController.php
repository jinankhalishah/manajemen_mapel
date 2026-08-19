<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Laporan;
use App\Models\MataPelajaran;
use App\Models\Pengajaran;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class WakasekController extends Controller
{
    /**
     * Dashboard Wakasek (pemantauan, read-only).
     */
    public function index()
    {
        $tahunAjaranAktif = TahunAjaran::where('status', true)->first();

        $stats = [
            'guru' => Guru::count(),
            'guruAktif' => Guru::where('status', 'Aktif')->count(),
            'mapel' => MataPelajaran::count(),
            'kelas' => Kelas::count(),
            'jurusan' => Jurusan::count(),
            'pengajaran' => Pengajaran::count(),
            'laporan' => Laporan::count(),
        ];

        $jadwalPerHari = Pengajaran::query()
            ->selectRaw('hari, COUNT(*) as total')
            ->groupBy('hari')
            ->get();

        $mapelPerKelompok = MataPelajaran::query()
            ->selectRaw('kelompok, COUNT(*) as total')
            ->groupBy('kelompok')
            ->get();

        $kelasPerTingkat = Kelas::query()
            ->selectRaw('tingkat, COUNT(*) as total')
            ->groupBy('tingkat')
            ->get();

        $bebanMengajar = Pengajaran::with('guru')
            ->selectRaw('guru_id, SUM(jam_per_minggu) as total_jam')
            ->groupBy('guru_id')
            ->orderByDesc('total_jam')
            ->limit(8)
            ->get();

        $laporanTerbaru = Laporan::with(['user', 'tahunAjaran'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('wakasek.dashboard', compact(
            'tahunAjaranAktif',
            'stats',
            'jadwalPerHari',
            'mapelPerKelompok',
            'kelasPerTingkat',
            'bebanMengajar',
            'laporanTerbaru'
        ));
    }

    /**
     * Daftar laporan pengajuan (read-only).
     */
    public function laporan(Request $request)
    {
        $keyword = $request->query('q');
        $jenis = $request->query('jenis');
        $tahunAjaranId = $request->query('tahun_ajaran_id');

        $laporan = Laporan::with(['user', 'tahunAjaran'])
            ->when($keyword, function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('judul', 'like', "%{$keyword}%")
                        ->orWhere('keterangan', 'like', "%{$keyword}%");
                });
            })
            ->when($jenis, fn($query) => $query->where('jenis', $jenis))
            ->when($tahunAjaranId, fn($query) => $query->where('tahun_ajaran_id', $tahunAjaranId))
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();

        return view('wakasek.laporan.index', compact('laporan', 'tahunAjaran'));
    }

    /**
     * Daftar jadwal pengajaran (read-only).
     */
    public function jadwal(Request $request)
    {
        $keyword = $request->query('q');
        $hari = $request->query('hari');
        $tahunAjaranId = $request->query('tahun_ajaran_id');
        $kelasId = $request->query('kelas_id');

        $pengajaran = Pengajaran::with(['kelas.jurusan', 'mataPelajaran', 'guru', 'tahunAjaran'])
            ->when($keyword, function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->whereHas('kelas', fn($qq) => $qq->where('nama_kelas', 'like', "%{$keyword}%"))
                        ->orWhereHas('mataPelajaran', fn($qq) => $qq->where('nama', 'like', "%{$keyword}%"))
                        ->orWhereHas('guru', fn($qq) => $qq->where('nama', 'like', "%{$keyword}%"));
                });
            })
            ->when($hari, fn($query) => $query->where('hari', $hari))
            ->when($tahunAjaranId, fn($query) => $query->where('tahun_ajaran_id', $tahunAjaranId))
            ->when($kelasId, fn($query) => $query->where('kelas_id', $kelasId))
            ->orderByRaw("CASE hari WHEN 'Senin' THEN 1 WHEN 'Selasa' THEN 2 WHEN 'Rabu' THEN 3 WHEN 'Kamis' THEN 4 WHEN 'Jumat' THEN 5 WHEN 'Sabtu' THEN 6 ELSE 7 END")
            ->orderBy('jam_mulai')
            ->paginate(10)
            ->withQueryString();

        $tahunAjaran = TahunAjaran::orderByDesc('tahun')->get();
        $kelas = Kelas::with('jurusan')->orderBy('nama_kelas')->get();

        return view('wakasek.jadwal.index', compact('pengajaran', 'tahunAjaran', 'kelas'));
    }
}