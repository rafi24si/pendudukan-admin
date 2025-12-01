<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeluargaKKController;
use App\Http\Controllers\AnggotaKeluargaController;
use App\Http\Controllers\PeristiwaPindahController;
use App\Http\Controllers\PeristiwaKematianController;
use App\Http\Controllers\PeristiwaKelahiranController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [LoginController::class, 'registerForm'])->name('register.index');
Route::post('/register', [LoginController::class, 'register'])->name('register.process');

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| USER (View berada di pages/admin/user/)
|--------------------------------------------------------------------------
*/
Route::resource('user', UserController::class);

/*
|--------------------------------------------------------------------------
| WARGA (View berada di pages/warga/)
|--------------------------------------------------------------------------
*/
Route::resource('warga', WargaController::class);

/*
|--------------------------------------------------------------------------
| MEDIA (Upload + Delete)
|--------------------------------------------------------------------------
*/
Route::post('/media', [MediaController::class, 'store'])->name('media.store');
Route::delete('/media/{id}', [MediaController::class, 'destroy'])->name('media.destroy');


Route::resource('keluarga-kk', KeluargaKKController::class)->names('keluarga_kk');

Route::resource('anggota-keluarga', AnggotaKeluargaController::class)
    ->names('anggota_keluarga');

Route::resource('peristiwa-kelahiran', PeristiwaKelahiranController::class)
    ->names('peristiwa_kelahiran');

    Route::resource('peristiwa-kematian', PeristiwaKematianController::class)
    ->names('peristiwa_kematian');

Route::resource('peristiwa-pindah', PeristiwaPindahController::class)
    ->names('peristiwa_pindah');
