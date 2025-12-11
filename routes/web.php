<?php

use App\Http\Controllers\AnggotaKeluargaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KeluargaKKController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PeristiwaKelahiranController;
use App\Http\Controllers\PeristiwaKematianController;
use App\Http\Controllers\PeristiwaPindahController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WargaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| DEFAULT ROUTE → LANGSUNG KE DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'login'])->name('login.process');
Route::get('/logout', function (\Illuminate\Http\Request $request) {
    // Hapus semua session login
    $request->session()->flush();

    // Arahkan ke dashboard
    return redirect()->route('dashboard')
        ->with('success', 'Anda berhasil logout.');
})->name('logout');

Route::get('/register', [LoginController::class, 'registerForm'])->name('register.index');
Route::post('/register', [LoginController::class, 'register'])->name('register.process');

/*
|--------------------------------------------------------------------------
| DASHBOARD → TIDAK BUTUH LOGIN
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| ROUTE YANG WAJIB LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware(['checkLogin'])->group(function () {

    // USER
    Route::resource('user', UserController::class);

    // WARGA
    Route::resource('warga', WargaController::class);

    // MEDIA
    Route::post('/media', [MediaController::class, 'store'])->name('media.store');
    Route::delete('/media/{id}', [MediaController::class, 'destroy'])->name('media.destroy');

    // KELUARGA KK
    Route::resource('keluarga-kk', KeluargaKKController::class)->names('keluarga_kk');

    // ANGGOTA KELUARGA
    Route::resource('anggota-keluarga', AnggotaKeluargaController::class)->names('anggota_keluarga');

    // PERISTIWA
    Route::resource('peristiwa-kelahiran', PeristiwaKelahiranController::class)->names('peristiwa_kelahiran');
    Route::resource('peristiwa-kematian', PeristiwaKematianController::class)->names('peristiwa_kematian');
    Route::resource('peristiwa-pindah', PeristiwaPindahController::class)->names('peristiwa_pindah');
});
