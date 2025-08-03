<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\RiwayatPemesananController;
use App\Http\Controllers\TransaksiController;
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
Route::middleware('guest')->group(function () {
    // register
    Route::post('/registersubmit', [AuthController::class, 'registersubmit'])->name('admin.registersubmit');
    // login auth

    Route::post('/login/proses', [AuthController::class, 'login_proses'])->name('admin.login_proses');
});
    Route::get('/register', [AuthController::class, 'register'])->name('admin.register');
    Route::get('/', [AuthController::class, 'login'])->name('admin.login');
// -----------------------------------------------------------------------------------------------------------//
Route::group(['middleware' => ['auth']], function (){
    // dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    


    // barang
    Route::get('/data-barang', [BarangController::class, 'barang'])->name('admin.barang');
    Route::get('/createbarang', [BarangController::class, 'createbarang'])->name('admin.tambahbarang');
    Route::post('/createproses/barang', [BarangController::class, 'createproses'])->name('admin.tambahproses');
    Route::get('/edit/barang/{b}', [BarangController::class, 'edit'])->name('admin.edit');
    Route::put('/barang/update/{id}', [BarangController::class, 'update'])->name('admin.update');
    Route::delete('/barang/{id}', [BarangController::class, 'destroy'])->name('admin.delete');
    // Rak
    Route::get('/Rak-barang', [RakController::class, 'rak'])->name('admin.rak');
    Route::get('/createrak', [RakController::class, 'create'])->name('admin.tambah');
    Route::post('/createproses/rak', [RakController::class, 'createproses'])->name('admin.rakproses');
    Route::get('/edit/rak/{r}', [RakController::class, 'edit'])->name('admin.editrak');
    Route::put('/rak/update/{id}', [RakController::class, 'update'])->name('admin.updaterak');
    Route::delete('/rak/{id}', [RakController::class, 'hapus'])->name('rak.delete');
    // Transaksi
    Route::get('/data-transaksi', [TransaksiController::class, 'index'])->name('base.transaksi');
    Route::get('/transaksi', [TransaksiController::class, 'transaksi'])->name('transaksi');
    Route::post('/createproses/transaksi', [TransaksiController::class, 'createproses'])->name('save.transaksi');
    Route::delete('/transaksi/{id}', [TransaksiController::class, 'hapus'])->name('delete.transaksi');
    Route::get('/admin/transaksi/detail/{id}', [TransaksiController::class, 'showDetail'])->name('transaksi.detail');
    // Riwayat Pemesanan
    Route::get('/riwayat-pemesanan', [RiwayatPemesananController::class, 'index'])->name('admin.riwayat');
    Route::post('/riwayat-pemesanan/update/{id}', [RiwayatPemesananController::class, 'updateStatus'])->name('admin.riwayat.update');

    // logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

});
