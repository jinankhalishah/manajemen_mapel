<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WakaKurikulumController;
use App\Http\Controllers\WakasekController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\PengajaranController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| Default Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    $user = auth()->user();

    return match ($user->role) {
        'waka_kurikulum' => redirect()->route('waka-kurikulum.dashboard'),
        'wakasek' => redirect()->route('wakasek.dashboard'),
        default => abort(403, 'Role pengguna tidak dikenali.'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| Dashboard Waka Kurikulum
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:waka_kurikulum'])->group(function () {

    Route::get('/waka-kurikulum/dashboard', [
        WakaKurikulumController::class,
        'index'
    ])->name('waka-kurikulum.dashboard');

    Route::resource('tahun-ajaran', TahunAjaranController::class)
        ->except(['show', 'edit', 'update']);

    Route::resource('jurusan', JurusanController::class)
        ->except(['show']);

    Route::resource('kelas', KelasController::class)
        ->parameters(['kelas' => 'kelas'])
        ->except(['show']);

    Route::resource('guru', GuruController::class)
        ->except(['show']);

    Route::resource('mata-pelajaran', MataPelajaranController::class)
        ->except(['show']);

    Route::resource('pengajaran', PengajaranController::class)
        ->except(['show']);

    Route::get('pengajaran/cetak', [PengajaranController::class, 'cetak'])
        ->name('pengajaran.cetak');

    Route::resource('laporan', LaporanController::class)
        ->only(['index', 'create', 'store', 'destroy']);

    Route::patch('/tahun-ajaran/{tahunAjaran}/aktifkan', [TahunAjaranController::class, 'aktifkan'])
        ->name('tahun-ajaran.aktifkan');

});


/*
|--------------------------------------------------------------------------
| Dashboard Wakasek
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:wakasek'])->group(function () {

    Route::get('/wakasek/dashboard', [
        WakasekController::class,
        'index'
    ])->name('wakasek.dashboard');

    Route::get('/wakasek/laporan', [
        WakasekController::class,
        'laporan'
    ])->name('wakasek.laporan');

    Route::get('/wakasek/jadwal', [
        WakasekController::class,
        'jadwal'
    ])->name('wakasek.jadwal');

});


/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [
        ProfileController::class,
        'edit'
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update'
    ])->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class,
        'destroy'
    ])->name('profile.destroy');

});


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
