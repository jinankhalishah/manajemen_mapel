<?php

use App\Models\Laporan;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

function laporanWakaKurikulum(): User
{
    return User::factory()->create(['role' => 'waka_kurikulum']);
}

function laporanWakasek(): User
{
    return User::factory()->create(['role' => 'wakasek']);
}

function laporanTahunAjaran(): TahunAjaran
{
    return TahunAjaran::create([
        'tahun' => '2026/2027',
        'semester' => 'Ganjil',
        'status' => true,
    ]);
}

test('waka kurikulum dapat melihat halaman daftar laporan', function () {
    $user = laporanWakaKurikulum();
    $tahunAjaran = laporanTahunAjaran();

    Laporan::create([
        'user_id' => $user->id,
        'tahun_ajaran_id' => $tahunAjaran->id,
        'judul' => 'Rekap Distribusi Guru',
        'jenis' => 'Distribusi Pengajaran',
    ]);

    $response = $this->actingAs($user)->get('/laporan');

    $response
        ->assertOk()
        ->assertSee('Rekap Distribusi Guru')
        ->assertSee('Distribusi Pengajaran')
        ->assertSee('Tambah Laporan');
});

test('halaman tambah laporan dapat diakses', function () {
    laporanTahunAjaran();

    $response = $this->actingAs(laporanWakaKurikulum())->get('/laporan/create');

    $response
        ->assertOk()
        ->assertSee('Tambah Laporan')
        ->assertSee('Jenis')
        ->assertSee('Simpan');
});

test('laporan baru dapat ditambahkan tanpa file', function () {
    $user = laporanWakaKurikulum();
    $tahunAjaran = laporanTahunAjaran();

    $response = $this->actingAs($user)->post('/laporan', [
        'tahun_ajaran_id' => $tahunAjaran->id,
        'judul' => 'Laporan Mata Pelajaran Umum',
        'jenis' => 'Mata Pelajaran',
        'keterangan' => 'Rekap semester ganjil.',
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/laporan');

    $this->assertDatabaseHas('laporan', [
        'user_id' => $user->id,
        'judul' => 'Laporan Mata Pelajaran Umum',
        'jenis' => 'Mata Pelajaran',
    ]);
});

test('laporan dengan file dapat ditambahkan', function () {
    Storage::fake('public');

    $user = laporanWakaKurikulum();
    $tahunAjaran = laporanTahunAjaran();

    $response = $this->actingAs($user)->post('/laporan', [
        'tahun_ajaran_id' => $tahunAjaran->id,
        'judul' => 'Jadwal Pengajaran Ganjil',
        'jenis' => 'Jadwal',
        'file' => UploadedFile::fake()->create('jadwal.pdf', 100),
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/laporan');

    $laporan = Laporan::first();

    $this->assertNotNull($laporan->file);
    Storage::disk('public')->assertExists($laporan->file);
});

test('judul laporan wajib diisi', function () {
    $user = laporanWakaKurikulum();
    $tahunAjaran = laporanTahunAjaran();

    $response = $this->actingAs($user)->post('/laporan', [
        'tahun_ajaran_id' => $tahunAjaran->id,
        'judul' => '',
        'jenis' => 'Jadwal',
    ]);

    $response->assertSessionHasErrors('judul');
});

test('laporan dapat dihapus', function () {
    $user = laporanWakaKurikulum();
    $tahunAjaran = laporanTahunAjaran();

    $laporan = Laporan::create([
        'user_id' => $user->id,
        'tahun_ajaran_id' => $tahunAjaran->id,
        'judul' => 'Laporan Lama',
        'jenis' => 'Jadwal',
    ]);

    $this->actingAs($user)
        ->delete("/laporan/{$laporan->id}")
        ->assertRedirect('/laporan');

    $this->assertDatabaseMissing('laporan', ['id' => $laporan->id]);
});

test('waka kurikulum wajib login untuk mengakses halaman laporan', function () {
    $this->get('/laporan')->assertRedirect('/login');
});

test('wakasek tidak dapat mengakses halaman laporan', function () {
    $this->actingAs(laporanWakasek())
        ->get('/laporan')
        ->assertForbidden();
});