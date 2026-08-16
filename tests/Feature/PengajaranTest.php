<?php

use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Pengajaran;
use App\Models\TahunAjaran;
use App\Models\User;

function pengajaranWakaKurikulum(): User
{
    return User::factory()->create(['role' => 'waka_kurikulum']);
}

function pengajaranWakasek(): User
{
    return User::factory()->create(['role' => 'wakasek']);
}

function pengajaranData(): array
{
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

    $mapel = MataPelajaran::create([
        'kode' => 'MTK',
        'nama' => 'Matematika',
        'kelompok' => 'Umum',
        'status' => 'Aktif',
    ]);

    $guru = Guru::create([
        'nip' => '198001012000001001',
        'nama' => 'Budi Santoso',
        'status' => 'Aktif',
    ]);

    return compact('tahunAjaran', 'jurusan', 'kelas', 'mapel', 'guru');
}

function pengajaranPayload(array $data = [], array $options = []): array
{
    return array_merge([
        'tahun_ajaran_id' => $data['tahunAjaran']->id,
        'kelas_id' => $data['kelas']->id,
        'mata_pelajaran_id' => $data['mapel']->id,
        'guru_id' => $data['guru']->id,
        'hari' => 'Senin',
        'jam_mulai' => '07:00',
        'jam_selesai' => '08:00',
        'jam_per_minggu' => 2,
        'semester' => 'Ganjil',
    ], $options['overrides'] ?? []);
}

test('waka kurikulum dapat melihat halaman daftar pengajaran', function () {
    $data = pengajaranData();

    Pengajaran::create([
        'tahun_ajaran_id' => $data['tahunAjaran']->id,
        'kelas_id' => $data['kelas']->id,
        'mata_pelajaran_id' => $data['mapel']->id,
        'guru_id' => $data['guru']->id,
        'hari' => 'Senin',
        'jam_mulai' => '07:00',
        'jam_selesai' => '08:00',
        'jam_per_minggu' => 2,
        'semester' => 'Ganjil',
    ]);

    $response = $this->actingAs(pengajaranWakaKurikulum())->get('/pengajaran');

    $response
        ->assertOk()
        ->assertSee('X-RPL-1')
        ->assertSee('Matematika')
        ->assertSee('Budi Santoso')
        ->assertSee('Senin')
        ->assertSee('Tambah Pengajaran');
});

test('halaman tambah pengajaran dapat diakses', function () {
    pengajaranData();

    $response = $this->actingAs(pengajaranWakaKurikulum())->get('/pengajaran/create');

    $response
        ->assertOk()
        ->assertSee('Tambah Pengajaran')
        ->assertSee('Tahun Ajaran')
        ->assertSee('Simpan');
});

test('halaman edit pengajaran dapat diakses', function () {
    $data = pengajaranData();

    $pengajaran = Pengajaran::create([
        'tahun_ajaran_id' => $data['tahunAjaran']->id,
        'kelas_id' => $data['kelas']->id,
        'mata_pelajaran_id' => $data['mapel']->id,
        'guru_id' => $data['guru']->id,
        'hari' => 'Senin',
        'jam_mulai' => '07:00',
        'jam_selesai' => '08:00',
        'jam_per_minggu' => 2,
        'semester' => 'Ganjil',
    ]);

    $response = $this->actingAs(pengajaranWakaKurikulum())
        ->get("/pengajaran/{$pengajaran->id}/edit");

    $response
        ->assertOk()
        ->assertSee('Edit Pengajaran')
        ->assertSee('X-RPL-1');
});

test('pengajaran baru dapat ditambahkan', function () {
    $data = pengajaranData();

    $response = $this->actingAs(pengajaranWakaKurikulum())
        ->post('/pengajaran', pengajaranPayload($data));

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/pengajaran');

    $this->assertDatabaseHas('pengajaran', [
        'kelas_id' => $data['kelas']->id,
        'mata_pelajaran_id' => $data['mapel']->id,
        'guru_id' => $data['guru']->id,
        'hari' => 'Senin',
    ]);
});

test('jam selesai harus setelah jam mulai', function () {
    $data = pengajaranData();

    $response = $this->actingAs(pengajaranWakaKurikulum())
        ->post('/pengajaran', pengajaranPayload($data, [
            'overrides' => [
                'jam_mulai' => '09:00',
                'jam_selesai' => '08:00',
            ],
        ]));

    $response->assertSessionHasErrors('jam_selesai');
});

test('jadwal bentrok untuk guru yang sama ditolak', function () {
    $data = pengajaranData();

    Pengajaran::create(pengajaranPayload($data));

    $response = $this->actingAs(pengajaranWakaKurikulum())
        ->post('/pengajaran', pengajaranPayload($data, [
            'overrides' => [
                'kelas_id' => $data['kelas']->id,
                'mata_pelajaran_id' => $data['mapel']->id,
                'hari' => 'Senin',
                'jam_mulai' => '07:30',
                'jam_selesai' => '08:30',
            ],
        ]));

    $response->assertSessionHasErrors('jam_mulai');
});

test('jadwal bentrok untuk kelas yang sama ditolak', function () {
    $data = pengajaranData();

    Pengajaran::create(pengajaranPayload($data));

    $guruLain = Guru::create([
        'nip' => '199001012000001002',
        'nama' => 'Siti Aminah',
        'status' => 'Aktif',
    ]);

    $response = $this->actingAs(pengajaranWakaKurikulum())
        ->post('/pengajaran', pengajaranPayload($data, [
            'overrides' => [
                'guru_id' => $guruLain->id,
                'hari' => 'Senin',
                'jam_mulai' => '07:30',
                'jam_selesai' => '08:30',
            ],
        ]));

    $response->assertSessionHasErrors('jam_mulai');
});

test('pengajaran dapat diperbarui', function () {
    $data = pengajaranData();

    $pengajaran = Pengajaran::create(pengajaranPayload($data));

    $response = $this->actingAs(pengajaranWakaKurikulum())
        ->put("/pengajaran/{$pengajaran->id}", pengajaranPayload($data, [
            'overrides' => [
                'hari' => 'Selasa',
                'jam_mulai' => '10:00',
                'jam_selesai' => '11:00',
                'jam_per_minggu' => 3,
            ],
        ]));

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/pengajaran');

    $this->assertSame('Selasa', $pengajaran->fresh()->hari);
});

test('pengajaran dapat dihapus', function () {
    $data = pengajaranData();

    $pengajaran = Pengajaran::create(pengajaranPayload($data));

    $this->actingAs(pengajaranWakaKurikulum())
        ->delete("/pengajaran/{$pengajaran->id}")
        ->assertRedirect('/pengajaran');

    $this->assertDatabaseMissing('pengajaran', ['id' => $pengajaran->id]);
});

test('waka kurikulum wajib login untuk mengakses halaman pengajaran', function () {
    $this->get('/pengajaran')->assertRedirect('/login');
});

test('wakasek tidak dapat mengakses halaman pengajaran', function () {
    $this->actingAs(pengajaranWakasek())
        ->get('/pengajaran')
        ->assertForbidden();
});

test('halaman cetak jadwal pengajaran dapat diakses', function () {
    $data = pengajaranData();

    Pengajaran::create(pengajaranPayload($data));

    $response = $this->actingAs(pengajaranWakaKurikulum())
        ->get('/pengajaran/cetak');

    $response
        ->assertOk()
        ->assertSee('Jadwal Pengajaran')
        ->assertSee('X-RPL-1')
        ->assertSee('Matematika')
        ->assertSee('Cetak / Simpan PDF');
});

test('halaman cetak menampilkan data sesuai filter tahun ajaran', function () {
    $data = pengajaranData();

    Pengajaran::create(pengajaranPayload($data));

    $response = $this->actingAs(pengajaranWakaKurikulum())
        ->get('/pengajaran/cetak?tahun_ajaran_id=' . $data['tahunAjaran']->id);

    $response
        ->assertOk()
        ->assertSee('X-RPL-1')
        ->assertSee('Matematika');
});

test('halaman cetak dengan filter kelas menampilkan kelas yang tepat', function () {
    $data = pengajaranData();

    Pengajaran::create(pengajaranPayload($data));

    $response = $this->actingAs(pengajaranWakaKurikulum())
        ->get('/pengajaran/cetak?kelas_id=' . $data['kelas']->id);

    $response
        ->assertOk()
        ->assertSee('X-RPL-1')
        ->assertSee('Budi Santoso');
});

test('wakasek tidak dapat mengakses halaman cetak jadwal', function () {
    $this->actingAs(pengajaranWakasek())
        ->get('/pengajaran/cetak')
        ->assertForbidden();
});