<?php

use App\Http\Controllers\HariLiburController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JamKerjaController;
use App\Http\Controllers\PangkatGolController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PerhitunganController;
use App\Http\Controllers\TarifLemburController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('logout', [HomeController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('user', UserController::class);
    Route::controller(PangkatGolController::class)->group(function () {
        Route::resource('pangkat', PangkatGolController::class);
        Route::post('pangkat/import', [PangkatGolController::class, 'import'])->name('pangkat.import');
    });
    Route::resource('jamkerja', JamKerjaController::class);
    Route::resource('tariflembur', TarifLemburController::class);
    Route::resource('harilibur', HariLiburController::class);
    Route::controller(PegawaiController::class)->group(function () {
        Route::resource('pegawai', PegawaiController::class);
        Route::post('pegawai/import', [PegawaiController::class, 'import'])->name('pegawai.import');
    });
    Route::controller(PerhitunganController::class)->group(function () {
        Route::resource('lembur', PerhitunganController::class);
        Route::post('lembur/import', [PerhitunganController::class, 'import'])->name('lembur.import');
    });
});
