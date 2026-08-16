<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =========================
        // AKUN
        // =========================

        User::create([
            'name' => 'Waka Kurikulum',
            'email' => 'waka@smk.test',
            'password' => 'password',
            'role' => 'waka_kurikulum',
        ]);

        User::create([
            'name' => 'Wakasek',
            'email' => 'wakasek@smk.test',
            'password' => 'password',
            'role' => 'wakasek',
        ]);


        // =========================
        // TAHUN AJARAN
        // =========================

        $tahunAjaran = TahunAjaran::create([
            'tahun' => '2026/2027',
            'semester' => 'Ganjil',
            'status' => true,
        ]);


        // =========================
        // JURUSAN
        // =========================

        $rpl = Jurusan::create([
            'kode' => 'RPL',
            'nama' => 'Rekayasa Perangkat Lunak',
            'deskripsi' => 'Program keahlian Rekayasa Perangkat Lunak.',
        ]);

        $tkj = Jurusan::create([
            'kode' => 'TKJ',
            'nama' => 'Teknik Komputer dan Jaringan',
            'deskripsi' => 'Program keahlian Teknik Komputer dan Jaringan.',
        ]);

        $akl = Jurusan::create([
            'kode' => 'AKL',
            'nama' => 'Akuntansi dan Keuangan Lembaga',
            'deskripsi' => 'Program keahlian Akuntansi dan Keuangan Lembaga.',
        ]);


        // =========================
        // GURU
        // =========================

        $guru1 = Guru::create([
            'nip' => '198001012010011001',
            'nama' => 'Budi Santoso',
            'email' => 'budi@smk.test',
            'no_hp' => '081234567001',
            'status' => 'Aktif',
        ]);

        $guru2 = Guru::create([
            'nip' => '198202022011012002',
            'nama' => 'Siti Aminah',
            'email' => 'siti@smk.test',
            'no_hp' => '081234567002',
            'status' => 'Aktif',
        ]);

        $guru3 = Guru::create([
            'nip' => '198303032012013003',
            'nama' => 'Andi Pratama',
            'email' => 'andi@smk.test',
            'no_hp' => '081234567003',
            'status' => 'Aktif',
        ]);

        $guru4 = Guru::create([
            'nip' => '198404042013014004',
            'nama' => 'Dewi Lestari',
            'email' => 'dewi@smk.test',
            'no_hp' => '081234567004',
            'status' => 'Aktif',
        ]);


        // =========================
        // MATA PELAJARAN
        // =========================

        $matematika = MataPelajaran::create([
            'kode' => 'MTK',
            'nama' => 'Matematika',
            'kelompok' => 'Umum',
            'deskripsi' => 'Mata pelajaran Matematika.',
            'status' => 'Aktif',
        ]);

        $bahasaIndonesia = MataPelajaran::create([
            'kode' => 'BIN',
            'nama' => 'Bahasa Indonesia',
            'kelompok' => 'Umum',
            'deskripsi' => 'Mata pelajaran Bahasa Indonesia.',
            'status' => 'Aktif',
        ]);

        $pemrogramanWeb = MataPelajaran::create([
            'kode' => 'PWEB',
            'nama' => 'Pemrograman Web',
            'kelompok' => 'Kejuruan',
            'deskripsi' => 'Mata pelajaran Pemrograman Web.',
            'status' => 'Aktif',
        ]);

        $basisData = MataPelajaran::create([
            'kode' => 'BD',
            'nama' => 'Basis Data',
            'kelompok' => 'Kejuruan',
            'deskripsi' => 'Mata pelajaran Basis Data.',
            'status' => 'Aktif',
        ]);

        $jaringan = MataPelajaran::create([
            'kode' => 'JARKOM',
            'nama' => 'Jaringan Komputer',
            'kelompok' => 'Kejuruan',
            'deskripsi' => 'Mata pelajaran Jaringan Komputer.',
            'status' => 'Aktif',
        ]);


        // =========================
        // KELAS
        // =========================

        $xRpl1 = Kelas::create([
            'jurusan_id' => $rpl->id,
            'tahun_ajaran_id' => $tahunAjaran->id,
            'tingkat' => 'X',
            'nama_kelas' => 'X RPL 1',
        ]);

        $xRpl2 = Kelas::create([
            'jurusan_id' => $rpl->id,
            'tahun_ajaran_id' => $tahunAjaran->id,
            'tingkat' => 'X',
            'nama_kelas' => 'X RPL 2',
        ]);

        $xTkj1 = Kelas::create([
            'jurusan_id' => $tkj->id,
            'tahun_ajaran_id' => $tahunAjaran->id,
            'tingkat' => 'X',
            'nama_kelas' => 'X TKJ 1',
        ]);

        $xAkl1 = Kelas::create([
            'jurusan_id' => $akl->id,
            'tahun_ajaran_id' => $tahunAjaran->id,
            'tingkat' => 'X',
            'nama_kelas' => 'X AKL 1',
        ]);
    }
}
