<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Pengajaran;
use App\Models\TahunAjaran;

class WakaKurikulumController extends Controller
{
    public function index()
    {
        $totalGuru = Guru::count();
        $totalMapel = MataPelajaran::count();
        $totalKelas = Kelas::count();
        $totalPengajaran = Pengajaran::count();
        $tahunAjaranAktif = TahunAjaran::where('status', true)->first();

        return view('waka-kurikulum.dashboard', compact(
            'totalGuru',
            'totalMapel',
            'totalKelas',
            'totalPengajaran',
            'tahunAjaranAktif'
        ));
    }
}
