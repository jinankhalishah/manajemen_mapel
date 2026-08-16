<?php

use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Pengajaran;
use App\Models\TahunAjaran;
use App\Models\User;

function guruWakaKurikulum(): User
{
    return User::factory()->create(['role' => 'waka_kurikulum']);
}

function guruWakasek(): User
{
    return User::factory()->create(['role' => 'wakasek']);
}

test('waka kurikulum dapat melihat halaman daftar guru', function () {
    Guru::create([
        'nip' => '198001012000001001',
        'nama' => 'Budi Santoso',
    ]);

    $response = $this->actingAs(guruWakaKurikulum())->get('/guru');

    $response
        ->assertOk()
        ->assertSee('Budi Santoso')
        ->assertSee('Tambah Guru');
});

test('halaman tambah guru dapat diakses', function () {
    $response = $this->actingAs(guruWakaKurikulum())->get('/guru/create');

    $response
        ->assertOk()
        ->assertSee('Tambah Guru')
        ->assertSee('Simpan');
});

test('halaman edit guru dapat diakses', function () {
    $guru = Guru::create([
        'nip' => '198001012000001001',
        'nama' => 'Budi Santoso',
    ]);

    $response = $this->actingAs(guruWakaKurikulum())->get("/guru/{$guru->id}/edit");

    $response
        ->assertOk()
        ->assertSee('Edit Guru')
        ->assertSee('Budi Santoso');
});

test('guru baru dapat ditambahkan', function () {
    $response = $this->actingAs(guruWakaKurikulum())->post('/guru', [
        'nip' => '198002022000002002',
        'nama' => 'Siti Aminah',
        'email' => 'siti@sekolah.sch.id',
        'no_hp' => '081234567890',
        'status' => 'Aktif',
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/guru');

    $this->assertDatabaseHas('guru', [
        'nip' => '198002022000002002',
        'nama' => 'Siti Aminah',
    ]);
});

test('nip yang sama ditolak', function () {
    Guru::create([
        'nip' => '198001012000001001',
        'nama' => 'Budi Santoso',
    ]);

    $response = $this->actingAs(guruWakaKurikulum())->post('/guru', [
        'nip' => '198001012000001001',
        'nama' => 'Orang Lain',
    ]);

    $response->assertSessionHasErrors('nip');
});

test('email yang sama ditolak', function () {
    Guru::create([
        'nip' => '198001012000001001',
        'nama' => 'Budi Santoso',
        'email' => 'budi@sekolah.sch.id',
    ]);

    $response = $this->actingAs(guruWakaKurikulum())->post('/guru', [
        'nip' => '198002022000002002',
        'nama' => 'Siti Aminah',
        'email' => 'budi@sekolah.sch.id',
    ]);

    $response->assertSessionHasErrors('email');
});

test('guru dapat diperbarui', function () {
    $guru = Guru::create([
        'nip' => '198001012000001001',
        'nama' => 'Budi Santoso',
        'status' => 'Aktif',
    ]);

    $response = $this->actingAs(guruWakaKurikulum())->put("/guru/{$guru->id}", [
        'nip' => '198001012000001001',
        'nama' => 'Budi Santoso, S.Pd.',
        'status' => 'Tidak Aktif',
    ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/guru');

    $this->assertSame('Tidak Aktif', $guru->fresh()->status);
});

test('guru yang dipakai pengajaran tidak dapat dihapus', function () {
    $guru = Guru::create([
        'nip' => '198001012000001001',
        'nama' => 'Budi Santoso',
    ]);

    Pengajaran::create([
        'tahun_ajaran_id' => TahunAjaran::create([
            'tahun' => '2026/2027',
            'semester' => 'Ganjil',
            'status' => true,
        ])->id,
        'kelas_id' => Kelas::create([
            'jurusan_id' => Jurusan::create([
                'kode' => 'RPL',
                'nama' => 'Rekayasa Perangkat Lunak',
            ])->id,
            'tahun_ajaran_id' => TahunAjaran::latest('id')->value('id'),
            'tingkat' => 'X',
            'nama_kelas' => 'X-RPL-1',
        ])->id,
        'mata_pelajaran_id' => MataPelajaran::create([
            'kode' => 'MTK',
            'nama' => 'Matematika',
            'kelompok' => 'Umum',
        ])->id,
        'guru_id' => $guru->id,
        'hari' => 'Senin',
        'jam_mulai' => '07:00',
        'jam_selesai' => '08:00',
        'jam_per_minggu' => 2,
        'semester' => 'Ganjil',
    ]);

    $this->actingAs(guruWakaKurikulum())->delete("/guru/{$guru->id}");

    $this->assertDatabaseHas('guru', ['id' => $guru->id]);
});

test('guru yang tidak dipakai dapat dihapus', function () {
    $guru = Guru::create([
        'nip' => '198001012000001001',
        'nama' => 'Budi Santoso',
    ]);

    $this->actingAs(guruWakaKurikulum())->delete("/guru/{$guru->id}");

    $this->assertDatabaseMissing('guru', ['id' => $guru->id]);
});

test('waka kurikulum wajib login untuk mengakses halaman guru', function () {
    $this->get('/guru')->assertRedirect('/login');
});

test('wakasek tidak dapat mengakses halaman guru', function () {
    $this->actingAs(guruWakasek())
        ->get('/guru')
        ->assertForbidden();
});