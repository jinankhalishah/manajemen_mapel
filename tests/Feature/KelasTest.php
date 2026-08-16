<?php

use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Pengajaran;
use App\Models\TahunAjaran;
use App\Models\User;

function kelasWakaKurikulum(): User
{
    return User::factory()->create(['role' => 'waka_kurikulum']);
}

function kelasWakasek(): User
{
    return User::factory()->create(['role' => 'wakasek']);
}

function kelasJurusan(): Jurusan
{
    return Jurusan::create([
        'kode' => 'RPL',
        'nama' => 'Rekayasa Perangkat Lunak',
    ]);
}

function kelasTahunAjaran(): TahunAjaran
{
    return TahunAjaran::create([
        'tahun' => '2026/2027',
        'semester' => 'Ganjil',
        'status' => true,
    ]);
}

test('waka kurikulum dapat melihat halaman daftar kelas', function () {
    $jurusan = kelasJurusan();
    $tahunAjaran = kelasTahunAjaran();

    Kelas::create([
        'jurusan_id' => $jurusan->id,
        'tahun_ajaran_id' => $tahunAjaran->id,
        'tingkat' => 'X',
        'nama_kelas' => 'X-RPL-1',
    ]);

    $response = $this->actingAs(kelasWakaKurikulum())->get('/kelas');

    $response
        ->assertOk()
        ->assertSee('X-RPL-1')
        ->assertSee('RPL')
        ->assertSee('Tambah Kelas');
});

test('halaman tambah kelas dapat diakses', function () {
    $response = $this->actingAs(kelasWakaKurikulum())->get('/kelas/create');

    $response
        ->assertOk()
        ->assertSee('Tambah Kelas')
        ->assertSee('Simpan');
});

test('halaman edit kelas dapat diakses', function () {
    $kelas = Kelas::create([
        'jurusan_id' => kelasJurusan()->id,
        'tahun_ajaran_id' => kelasTahunAjaran()->id,
        'tingkat' => 'X',
        'nama_kelas' => 'X-RPL-1',
    ]);

    $response = $this->actingAs(kelasWakaKurikulum())->get("/kelas/{$kelas->id}/edit");

    $response
        ->assertOk()
        ->assertSee('Edit Kelas')
        ->assertSee('X-RPL-1');
});

test('kelas baru dapat ditambahkan', function () {
    $jurusan = kelasJurusan();
    $tahunAjaran = kelasTahunAjaran();

    $response = $this->actingAs(kelasWakaKurikulum())->post('/kelas', [
        'jurusan_id' => $jurusan->id,
        'tahun_ajaran_id' => $tahunAjaran->id,
        'tingkat' => 'XI',
        'nama_kelas' => 'XI-RPL-1',
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/kelas');

    $this->assertDatabaseHas('kelas', [
        'jurusan_id' => $jurusan->id,
        'tahun_ajaran_id' => $tahunAjaran->id,
        'nama_kelas' => 'XI-RPL-1',
    ]);
});

test('nama kelas yang sama dalam jurusan dan tahun ajaran yang sama ditolak', function () {
    $jurusan = kelasJurusan();
    $tahunAjaran = kelasTahunAjaran();

    Kelas::create([
        'jurusan_id' => $jurusan->id,
        'tahun_ajaran_id' => $tahunAjaran->id,
        'tingkat' => 'X',
        'nama_kelas' => 'X-RPL-1',
    ]);

    $response = $this->actingAs(kelasWakaKurikulum())->post('/kelas', [
        'jurusan_id' => $jurusan->id,
        'tahun_ajaran_id' => $tahunAjaran->id,
        'tingkat' => 'X',
        'nama_kelas' => 'X-RPL-1',
    ]);

    $response->assertSessionHasErrors('nama_kelas');
});

test('nama kelas yang sama diizinkan pada jurusan yang berbeda', function () {
    $jurusanA = kelasJurusan();
    $jurusanB = Jurusan::create([
        'kode' => 'TKJ',
        'nama' => 'Teknik Komputer dan Jaringan',
    ]);
    $tahunAjaran = kelasTahunAjaran();

    $response = $this->actingAs(kelasWakaKurikulum())->post('/kelas', [
        'jurusan_id' => $jurusanB->id,
        'tahun_ajaran_id' => $tahunAjaran->id,
        'tingkat' => 'X',
        'nama_kelas' => 'X-RPL-1',
    ]);

    $response->assertSessionHasNoErrors();
    $this->assertDatabaseHas('kelas', ['jurusan_id' => $jurusanB->id]);
});

test('kelas dapat diperbarui', function () {
    $kelas = Kelas::create([
        'jurusan_id' => kelasJurusan()->id,
        'tahun_ajaran_id' => kelasTahunAjaran()->id,
        'tingkat' => 'X',
        'nama_kelas' => 'X-RPL-1',
    ]);

    $response = $this->actingAs(kelasWakaKurikulum())->put("/kelas/{$kelas->id}", [
        'jurusan_id' => $kelas->jurusan_id,
        'tahun_ajaran_id' => $kelas->tahun_ajaran_id,
        'tingkat' => 'X',
        'nama_kelas' => 'X-RPL-2',
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/kelas');

    $this->assertSame('X-RPL-2', $kelas->fresh()->nama_kelas);
});

test('kelas yang dipakai pengajaran tidak dapat dihapus', function () {
    $kelas = Kelas::create([
        'jurusan_id' => kelasJurusan()->id,
        'tahun_ajaran_id' => kelasTahunAjaran()->id,
        'tingkat' => 'X',
        'nama_kelas' => 'X-RPL-1',
    ]);

    Pengajaran::create([
        'tahun_ajaran_id' => $kelas->tahun_ajaran_id,
        'kelas_id' => $kelas->id,
        'mata_pelajaran_id' => MataPelajaran::create([
            'kode' => 'MTK',
            'nama' => 'Matematika',
            'kelompok' => 'Umum',
        ])->id,
        'guru_id' => Guru::create([
            'nip' => '198001012000001001',
            'nama' => 'Budi Santoso',
        ])->id,
        'hari' => 'Senin',
        'jam_mulai' => '07:00',
        'jam_selesai' => '08:00',
        'jam_per_minggu' => 2,
        'semester' => 'Ganjil',
    ]);

    $this->actingAs(kelasWakaKurikulum())->delete("/kelas/{$kelas->id}");

    $this->assertDatabaseHas('kelas', ['id' => $kelas->id]);
});

test('kelas yang tidak dipakai dapat dihapus', function () {
    $kelas = Kelas::create([
        'jurusan_id' => kelasJurusan()->id,
        'tahun_ajaran_id' => kelasTahunAjaran()->id,
        'tingkat' => 'X',
        'nama_kelas' => 'X-RPL-1',
    ]);

    $this->actingAs(kelasWakaKurikulum())->delete("/kelas/{$kelas->id}");

    $this->assertDatabaseMissing('kelas', ['id' => $kelas->id]);
});

test('waka kurikulum wajib login untuk mengakses halaman kelas', function () {
    $this->get('/kelas')->assertRedirect('/login');
});

test('wakasek tidak dapat mengakses halaman kelas', function () {
    $this->actingAs(kelasWakasek())
        ->get('/kelas')
        ->assertForbidden();
});