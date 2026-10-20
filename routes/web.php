<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\ProfilKompetensiController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\IndustryController;
use App\Http\Controllers\KonfirmasiRekomendasiController;
use App\Http\Controllers\MasterWilayahController;


/*
|--------------------------------------------------------------------------
| Redirect Awal
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('mahasiswa.welcomenew');
});

/*
|--------------------------------------------------------------------------
| Profile (Auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])
    ->name('profile.password');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])
    ->name('profile.photo.delete');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [MahasiswaController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| Role Mahasiswa
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/mahasiswa', [MahasiswaController::class, 'index']);
});

/*
|--------------------------------------------------------------------------
| Role Admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])
        ->middleware(['auth'])
        ->name('admin.dashboard');

    // Mata Kuliah
    Route::get('/admin/matakuliah', [MataKuliahController::class, 'index'])->name('mk.index');
    Route::get('/admin/matakuliah/create', [MataKuliahController::class, 'create'])->name('mk.create');
    Route::post('/admin/matakuliah/store', [MataKuliahController::class, 'store'])->name('mk.store');
    Route::get('/admin/matakuliah/edit/{id}', [MataKuliahController::class, 'edit'])->name('mk.edit');
    Route::put('/admin/matakuliah/update/{id}', [MataKuliahController::class, 'update'])->name('mk.update');
    Route::delete('/admin/matakuliah/delete/{id}', [MataKuliahController::class, 'destroy'])->name('mk.delete');

    // Industri
    Route::get('/admin/industry', [IndustryController::class, 'index'])->name('industry.listindustry');
    Route::get('/admin/industry/create', [IndustryController::class, 'create'])->name('industry.create');
    Route::post('/admin/industry', [IndustryController::class, 'store'])->name('industry.store');
    Route::delete('/admin/industry/{id}', [IndustryController::class, 'destroy'])->name('industry.delete');
    Route::get('/admin/industry/{industry}/edit', [IndustryController::class, 'edit'])
        ->name('industry.edit');

    Route::put('/admin/industry/{industry}', [IndustryController::class, 'update'])
        ->name('industry.update');

        Route::resource('master-wilayah', MasterWilayahController::class);
});

/*
|--------------------------------------------------------------------------
| REKOMENDASI (AHP + WASPAS)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('rekomendasi')->group(function () {

    // ==============================
    // PROSES REKOMENDASI
    // WAJIB KUALIFIKASI LENGKAP
    // ==============================
    Route::middleware(['qualification.complete'])->group(function () {

        Route::get('/', [RekomendasiController::class, 'input'])
            ->name('rekomendasi');

        Route::post('/ahp', [RekomendasiController::class, 'hitungAHP'])
            ->name('rekomendasi.ahp');

        Route::get('/bobot', [RekomendasiController::class, 'bobot'])
            ->name('rekomendasi.bobot');

        Route::get('/waspas', [RekomendasiController::class, 'waspas'])
            ->name('rekomendasi.waspas');

        Route::get('/ranking', [RekomendasiController::class, 'ranking'])
            ->name('rekomendasi.ranking');

        Route::get(
            '/detail-perhitungan',
            [RekomendasiController::class, 'detailPerhitungan']
        )->name('detail.perhitungan');

    });

    // ==============================
    // HISTORY
    // TIDAK DIKUNCI
    // ==============================
    Route::get('/history', [RekomendasiController::class, 'history'])
        ->name('rekomendasi.history');

    Route::get(
        '/history/{id}',
        [RekomendasiController::class, 'detailHistory']
    )->name('rekomendasi.history.detail');

    Route::get(
        '/rekomendasi/hasil/{id}',
        [RekomendasiController::class, 'detailHasil']
    )->name('rekomendasi.detailHasil');

});


Route::middleware(['auth'])->group(function () {

    Route::get('/konfirmasi', [KonfirmasiRekomendasiController::class, 'index'])
        ->name('konfirmasi.index');

    Route::post('/konfirmasi/{id}/hold', [KonfirmasiRekomendasiController::class, 'aktifkanHold'])
        ->name('konfirmasi.hold');
    Route::post('/konfirmasi/{id}/cancel', [KonfirmasiRekomendasiController::class, 'batalkanHold'])
    ->name('konfirmasi.cancel');

});

Route::get('/profil', [ProfilKompetensiController::class, 'index'])->name('profil.index');
Route::post('/profil/simpan', [ProfilKompetensiController::class, 'simpan'])->name('profil.simpan');
Route::get('/profil/hitung', [ProfilKompetensiController::class, 'hitung'])->name('profil.hitung');
Route::post(
    '/profil/minat/simpan',
    [ProfilKompetensiController::class, 'simpanMinat']
)->name('profil.minat.simpan');



Route::middleware('auth')->group(function () {

    Route::get('/industryuser', [IndustryController::class, 'listUser'])->name('industryuser.index');
    Route::post(
        '/industryuser/upload-bukti',
        [IndustryController::class, 'uploadBukti']
    )->name('industry.upload-bukti');
});


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');;
/*
|--------------------------------------------------------------------------
| Auth (Laravel Breeze / Jetstream)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
