<?php

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\User;

function jurusanWakaKurikulum(): User
{
    return User::factory()->create(['role' => 'waka_kurikulum']);
}

function jurusanWakasek(): User
{
    return User::factory()->create(['role' => 'wakasek']);
}

test('waka kurikulum dapat melihat halaman daftar jurusan', function () {
    Jurusan::create([
        'kode' => 'RPL',
        'nama' => 'Rekayasa Perangkat Lunak',
    ]);

    $response = $this->actingAs(jurusanWakaKurikulum())->get('/jurusan');

    $response
        ->assertOk()
        ->assertSee('RPL')
        ->assertSee('Rekayasa Perangkat Lunak')
        ->assertSee('Tambah Jurusan');
});

test('halaman tambah jurusan dapat diakses', function () {
    $response = $this->actingAs(jurusanWakaKurikulum())->get('/jurusan/create');

    $response
        ->assertOk()
        ->assertSee('Tambah Jurusan')
        ->assertSee('Simpan');
});

test('halaman edit jurusan dapat diakses', function () {
    $jurusan = Jurusan::create([
        'kode' => 'RPL',
        'nama' => 'Rekayasa Perangkat Lunak',
    ]);

    $response = $this->actingAs(jurusanWakaKurikulum())->get("/jurusan/{$jurusan->id}/edit");

    $response
        ->assertOk()
        ->assertSee('Edit Jurusan')
        ->assertSee('RPL');
});

test('jurusan baru dapat ditambahkan', function () {
    $response = $this->actingAs(jurusanWakaKurikulum())->post('/jurusan', [
        'kode' => 'TKJ',
        'nama' => 'Teknik Komputer dan Jaringan',
        'deskripsi' => 'Fokus pada jaringan komputer.',
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/jurusan');

    $this->assertDatabaseHas('jurusan', [
        'kode' => 'TKJ',
        'nama' => 'Teknik Komputer dan Jaringan',
    ]);
});

test('kode jurusan yang sama ditolak', function () {
    Jurusan::create([
        'kode' => 'RPL',
        'nama' => 'Rekayasa Perangkat Lunak',
    ]);

    $response = $this->actingAs(jurusanWakaKurikulum())->post('/jurusan', [
        'kode' => 'RPL',
        'nama' => 'Jurusan Lain',
    ]);

    $response->assertSessionHasErrors('kode');
});

test('jurusan dapat diperbarui', function () {
    $jurusan = Jurusan::create([
        'kode' => 'RPL',
        'nama' => 'Rekayasa Perangkat Lunak',
    ]);

    $response = $this->actingAs(jurusanWakaKurikulum())->put("/jurusan/{$jurusan->id}", [
        'kode' => 'RPL',
        'nama' => 'Rekayasa Perangkat Lunak dan Gim',
        'deskripsi' => 'Fokus pengembangan aplikasi.',
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/jurusan');

    $this->assertSame('Rekayasa Perangkat Lunak dan Gim', $jurusan->fresh()->nama);
});

test('jurusan yang dipakai kelas tidak dapat dihapus', function () {
    $jurusan = Jurusan::create([
        'kode' => 'RPL',
        'nama' => 'Rekayasa Perangkat Lunak',
    ]);

    $tahunAjaran = TahunAjaran::create([
        'tahun' => '2026/2027',
        'semester' => 'Ganjil',
        'status' => true,
    ]);

    Kelas::create([
        'jurusan_id' => $jurusan->id,
        'tahun_ajaran_id' => $tahunAjaran->id,
        'tingkat' => 'X',
        'nama_kelas' => 'X-RPL-1',
    ]);

    $this->actingAs(jurusanWakaKurikulum())->delete("/jurusan/{$jurusan->id}");

    $this->assertDatabaseHas('jurusan', ['id' => $jurusan->id]);
});

test('jurusan yang tidak dipakai dapat dihapus', function () {
    $jurusan = Jurusan::create([
        'kode' => 'MM',
        'nama' => 'Multimedia',
    ]);

    $this->actingAs(jurusanWakaKurikulum())->delete("/jurusan/{$jurusan->id}");

    $this->assertDatabaseMissing('jurusan', ['id' => $jurusan->id]);
});

test('waka kurikulum wajib login untuk mengakses halaman jurusan', function () {
    $this->get('/jurusan')->assertRedirect('/login');
});

test('wakasek tidak dapat mengakses halaman jurusan', function () {
    $this->actingAs(jurusanWakasek())
        ->get('/jurusan')
        ->assertForbidden();
});