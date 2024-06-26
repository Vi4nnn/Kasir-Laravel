<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\UserController;
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

Route::get('', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth', 'checkRole:admin']], function () {
Route::get('/users', [UserController::class, 'index'])->name('users');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::post('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');
});

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('/jenis-barang', [JenisBarangController::class, 'index'])->name('jenis-barang');
Route::post('/jenis-barang/store', [JenisBarangController::class, 'store'])->name('jenis-barang.store');
Route::post('/jenis-barang/update/{id}', [JenisBarangController::class, 'update'])->name('jenis-barang.update');
Route::delete('/jenis-barang/destroy/{id}', [JenisBarangController::class, 'destroy'])->name('jenis-barang.destroy');

Route::get('/barang', [BarangController::class, 'index'])->name('barang');
Route::post('/barang/store', [BarangController::class, 'store'])->name('barang.store');
Route::post('/barang/update/{id}', [BarangController::class, 'update'])->name('barang.update');
Route::delete('/barang/destroy/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');

Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
Route::put('/transaksi/{id}', [TransaksiController::class, 'update'])->name('transaksi.update');
Route::delete('/transaksi/{id}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');