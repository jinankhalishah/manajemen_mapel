<?php

use App\Models\TahunAjaran;
use App\Models\User;

function wakaKurikulum(): User
{
    return User::factory()->create(['role' => 'waka_kurikulum']);
}

function wakasek(): User
{
    return User::factory()->create(['role' => 'wakasek']);
}

test('waka kurikulum dapat melihat halaman daftar tahun ajaran', function () {
    TahunAjaran::create([
        'tahun' => '2026/2027',
        'semester' => 'Ganjil',
        'status' => true,
    ]);

    $response = $this->actingAs(wakaKurikulum())->get('/tahun-ajaran');

    $response
        ->assertOk()
        ->assertSee('2026/2027')
        ->assertSee('Tambah Tahun Ajaran');
});

test('halaman tambah tahun ajaran dapat diakses', function () {
    $response = $this->actingAs(wakaKurikulum())->get('/tahun-ajaran/create');

    $response
        ->assertOk()
        ->assertSee('Tambah Tahun Ajaran')
        ->assertSee('Simpan');
});

test('halaman edit tahun ajaran tidak tersedia', function () {
    $tahunAjaran = TahunAjaran::create([
        'tahun' => '2026/2027',
        'semester' => 'Ganjil',
        'status' => true,
    ]);

    $this->actingAs(wakaKurikulum())
        ->get("/tahun-ajaran/{$tahunAjaran->id}/edit")
        ->assertNotFound();
});

test('tahun ajaran baru dapat ditambahkan', function () {
    $response = $this->actingAs(wakaKurikulum())->post('/tahun-ajaran', [
        'tahun' => '2027/2028',
        'semester' => 'Genap',
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/tahun-ajaran');

    $this->assertDatabaseHas('tahun_ajaran', [
        'tahun' => '2027/2028',
        'semester' => 'Genap',
        'status' => false,
    ]);
});

test('kombinasi tahun dan semester yang sama ditolak', function () {
    TahunAjaran::create([
        'tahun' => '2026/2027',
        'semester' => 'Ganjil',
        'status' => true,
    ]);

    $response = $this->actingAs(wakaKurikulum())->post('/tahun-ajaran', [
        'tahun' => '2026/2027',
        'semester' => 'Ganjil',
    ]);

    $response->assertSessionHasErrors('tahun');
});

test('tahun ajaran dapat diperbarui tanpa error validasi pada data sendiri', function () {
    $tahunAjaran = TahunAjaran::create([
        'tahun' => '2026/2027',
        'semester' => 'Ganjil',
        'status' => true,
    ]);

    $this->actingAs(wakaKurikulum())
        ->put("/tahun-ajaran/{$tahunAjaran->id}", [
            'tahun' => '2026/2027',
            'semester' => 'Ganjil',
        ])
        ->assertMethodNotAllowed();
});

test('hanya satu tahun ajaran yang aktif saat tombol aktifkan ditekan', function () {
    TahunAjaran::create([
        'tahun' => '2026/2027',
        'semester' => 'Ganjil',
        'status' => true,
    ]);

    $baru = TahunAjaran::create([
        'tahun' => '2027/2028',
        'semester' => 'Ganjil',
        'status' => false,
    ]);

    $this->actingAs(wakaKurikulum())->patch("/tahun-ajaran/{$baru->id}/aktifkan");

    $this->assertSame(1, TahunAjaran::where('status', true)->count());
    $this->assertTrue($baru->fresh()->status);
});

test('tahun ajaran aktif tidak dapat dihapus', function () {
    $aktif = TahunAjaran::create([
        'tahun' => '2026/2027',
        'semester' => 'Ganjil',
        'status' => true,
    ]);

    $this->actingAs(wakaKurikulum())->delete("/tahun-ajaran/{$aktif->id}");

    $this->assertDatabaseHas('tahun_ajaran', ['id' => $aktif->id]);
});

test('tahun ajaran non-aktif dapat dihapus', function () {
    $nonAktif = TahunAjaran::create([
        'tahun' => '2025/2026',
        'semester' => 'Ganjil',
        'status' => false,
    ]);

    $this->actingAs(wakaKurikulum())->delete("/tahun-ajaran/{$nonAktif->id}");

    $this->assertDatabaseMissing('tahun_ajaran', ['id' => $nonAktif->id]);
});

test('waka kurikulum wajib login untuk mengakses halaman tahun ajaran', function () {
    $this->get('/tahun-ajaran')->assertRedirect('/login');
});

test('wakasek tidak dapat mengakses halaman tahun ajaran', function () {
    $this->actingAs(wakasek())
        ->get('/tahun-ajaran')
        ->assertForbidden();
});

test('format tahun yang tidak valid ditolak', function () {
    $this->actingAs(wakaKurikulum())
        ->post('/tahun-ajaran', [
            'tahun' => '2026-2027',
            'semester' => 'Ganjil',
        ])
        ->assertSessionHasErrors('tahun');
});
