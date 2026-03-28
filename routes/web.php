<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AbsensiRekapController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| DEFAULT
|--------------------------------------------------------------------------
*/
Route::redirect('/', '/dashboard');

/*
|--------------------------------------------------------------------------
| AUTH (GUEST)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    Route::controller(LoginController::class)->group(function () {

        Route::get('/login', 'index')->name('login.index');
        Route::post('/login', 'login')->name('login.process');

        Route::get('/register', 'registerForm')->name('register.index');
        Route::post('/register', 'register')->name('register.process');

    });

});

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| AREA LOGIN
|--------------------------------------------------------------------------
*/
Route::middleware('checkLogin')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | ABSENSI (SEMUA USER)
    |--------------------------------------------------------------------------
    */
    Route::prefix('absensi')->name('absensi.')->controller(AbsensiController::class)->group(function () {

        Route::get('/', 'index')->name('index');
        Route::post('/masuk', 'masuk')->name('masuk');
        Route::post('/keluar', 'keluar')->name('keluar');

    });

    /*
    |--------------------------------------------------------------------------
    | 🔥 KHUSUS PETINGGI (FIX)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:petinggi')->group(function () {

        Route::resource('user', UserController::class);

        Route::get('/absensi/rekap', [AbsensiRekapController::class, 'index'])
            ->name('absensi.rekap');

    });
    Route::get('/absensi/export', [AbsensiRekapController::class, 'export'])
        ->name('absensi.export');
});
