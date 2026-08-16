<?php

use App\Models\MataPelajaran;
use App\Models\User;
use App\Models\TahunAjaran;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Pengajaran;

function mapelWakaKurikulum(): User
{
    return User::factory()->create(['role' => 'waka_kurikulum']);
}

function mapelWakasek(): User
{
    return User::factory()->create(['role' => 'wakasek']);
}

test('waka kurikulum dapat melihat halaman daftar mata pelajaran', function () {
    MataPelajaran::create([
        'kode' => 'MTK',
        'nama' => 'Matematika',
        'kelompok' => 'Umum',
    ]);

    $response = $this->actingAs(mapelWakaKurikulum())->get('/mata-pelajaran');

    $response
        ->assertOk()
        ->assertSee('MTK')
        ->assertSee('Matematika')
        ->assertSee('Tambah Mata Pelajaran');
});

test('halaman tambah mata pelajaran dapat diakses', function () {
    $response = $this->actingAs(mapelWakaKurikulum())->get('/mata-pelajaran/create');

    $response
        ->assertOk()
        ->assertSee('Tambah Mata Pelajaran')
        ->assertSee('Simpan');
});

test('halaman edit mata pelajaran dapat diakses', function () {
    $mapel = MataPelajaran::create([
        'kode' => 'MTK',
        'nama' => 'Matematika',
        'kelompok' => 'Umum',
    ]);

    $response = $this->actingAs(mapelWakaKurikulum())->get("/mata-pelajaran/{$mapel->id}/edit");

    $response
        ->assertOk()
        ->assertSee('Edit Mata Pelajaran')
        ->assertSee('MTK');
});

test('mata pelajaran baru dapat ditambahkan', function () {
    $response = $this->actingAs(mapelWakaKurikulum())->post('/mata-pelajaran', [
        'kode' => 'BIN',
        'nama' => 'Bahasa Indonesia',
        'kelompok' => 'Umum',
        'status' => 'Aktif',
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/mata-pelajaran');

    $this->assertDatabaseHas('mata_pelajaran', [
        'kode' => 'BIN',
        'nama' => 'Bahasa Indonesia',
    ]);
});

test('kode mata pelajaran yang sama ditolak', function () {
    MataPelajaran::create([
        'kode' => 'MTK',
        'nama' => 'Matematika',
        'kelompok' => 'Umum',
    ]);

    $response = $this->actingAs(mapelWakaKurikulum())->post('/mata-pelajaran', [
        'kode' => 'MTK',
        'nama' => 'Matematika Lanjut',
        'kelompok' => 'Kejuruan',
        'status' => 'Aktif',
    ]);

    $response->assertSessionHasErrors('kode');
});

test('mata pelajaran dapat diperbarui', function () {
    $mapel = MataPelajaran::create([
        'kode' => 'MTK',
        'nama' => 'Matematika',
        'kelompok' => 'Umum',
        'status' => 'Aktif',
    ]);

    $response = $this->actingAs(mapelWakaKurikulum())->put("/mata-pelajaran/{$mapel->id}", [
        'kode' => 'MTK',
        'nama' => 'Matematika Wajib',
        'kelompok' => 'Umum',
        'status' => 'Tidak Aktif',
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/mata-pelajaran');

    $this->assertSame('Tidak Aktif', $mapel->fresh()->status);
});

test('mata pelajaran yang dipakai pengajaran tidak dapat dihapus', function () {
    $mapel = MataPelajaran::create([
        'kode' => 'MTK',
        'nama' => 'Matematika',
        'kelompok' => 'Umum',
    ]);

    $tahunAjaran = TahunAjaran::create([
        'tahun' => '2026/2027',
        'semester' => 'Ganjil',
        'status' => true,
    ]);

    $jurusan = Jurusan::create([
        'kode' => 'RPL',
        'nama' => 'Rekayasa Perangkat Lunak',
    ]);

    $kelas = Kelas::create([
        'jurusan_id' => $jurusan->id,
        'tahun_ajaran_id' => $tahunAjaran->id,
        'tingkat' => 'X',
        'nama_kelas' => 'X-RPL-1',
    ]);

    $guru = Guru::create([
        'nip' => '198001012000001001',
        'nama' => 'Budi Santoso',
    ]);

    Pengajaran::create([
        'tahun_ajaran_id' => $tahunAjaran->id,
        'kelas_id' => $kelas->id,
        'mata_pelajaran_id' => $mapel->id,
        'guru_id' => $guru->id,
        'hari' => 'Senin',
        'jam_mulai' => '07:00',
        'jam_selesai' => '08:00',
        'jam_per_minggu' => 2,
        'semester' => 'Ganjil',
    ]);

    $this->actingAs(mapelWakaKurikulum())->delete("/mata-pelajaran/{$mapel->id}");

    $this->assertDatabaseHas('mata_pelajaran', ['id' => $mapel->id]);
});

test('mata pelajaran yang tidak dipakai dapat dihapus', function () {
    $mapel = MataPelajaran::create([
        'kode' => 'SBK',
        'nama' => 'Seni Budaya',
        'kelompok' => 'Umum',
    ]);

    $this->actingAs(mapelWakaKurikulum())->delete("/mata-pelajaran/{$mapel->id}");

    $this->assertDatabaseMissing('mata_pelajaran', ['id' => $mapel->id]);
});

test('waka kurikulum wajib login untuk mengakses halaman mata pelajaran', function () {
    $this->get('/mata-pelajaran')->assertRedirect('/login');
});

test('wakasek tidak dapat mengakses halaman mata pelajaran', function () {
    $this->actingAs(mapelWakasek())
        ->get('/mata-pelajaran')
        ->assertForbidden();
});