<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
// use App\Models\Barang;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\SatuanBarangController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminNavbarController;
use App\Http\Controllers\OwnerDashboardController;
use App\Http\Middleware\CheckRoleAdmin;
use App\Http\Middleware\CheckRolePemilik;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'verified','pemilik'])->group(function () {
    Route::get('/pemilik/dashboard', [OwnerDashboardController::class, 'index'])->name('pemilik.dashboard');
    Route::get('/pemilik/api/dashboard-data', [OwnerDashboardController::class, 'getDashboardData']);
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity.logs');
    Route::get('/pemilik/stok', [BarangController::class, 'stokpemilik'])->name('stok');
    Route::get('/laporan', [BarangMasukController::class, 'laporanFormBarangMasuk'])->name('laporanFormBarangMasuk');
    Route::get('/laporan/create', [BarangMasukController::class, 'generateLaporan'])->name('barang.laporan.generate');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route untuk update profile
    // Di routes/web.php
    Route::get('/api/owner-dashboard-data', [OwnerDashboardController::class, 'getDashboardData']);
});

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/api/dashboard-data', [AdminDashboardController::class, 'getDashboardData']);

    Route::get('/admin/navbar', [AdminNavbarController::class, 'showNavbar'])->name('admin.navbar');
    Route::get('/stok', [BarangController::class, 'stok'])->name('stok');

    // Barang
    Route::get('/data-barang', [BarangController::class, 'index'])->name('data-barang');
    Route::get('/data-barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/data-barang', [BarangController::class, 'store'])->name('barang.store');
    Route::get('/data-barang/{id}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('/data-barang/{id}', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/data-barang/{id}', [BarangController::class, 'destroy'])->name('barang.destroy');

    // Jenis Barang
    Route::get('/jenis-barang', [JenisBarangController::class, 'index'])->name('jenis-barang');
    Route::get('/jenis-barang/create', [JenisBarangController::class, 'create'])->name('jenis-barang.create');
    Route::post('/jenis-barang', [JenisBarangController::class, 'store'])->name('jenis-barang.store');
    Route::get('/jenis-barang/{id}/edit', [JenisBarangController::class, 'edit'])->name('jenis-barang.edit');
    Route::put('/jenis-barang/{id}', [JenisBarangController::class, 'update'])->name('jenis-barang.update');
    Route::delete('/jenis-barang/{id}', [JenisBarangController::class, 'destroy'])->name('jenis-barang.destroy');


    //Supplier
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
    Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
    Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
    Route::get('/suppliers/{id_supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
    Route::put('/suppliers/{id_supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
    Route::delete('/suppliers/{id_supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

    // Barang Masuk
    Route::get('/barang-masuk', [BarangMasukController::class, 'index'])->name('barang-masuk.index');
    Route::get('/barang-masuk/create', [BarangMasukController::class, 'create'])->name('barang-masuk.create');
    Route::post('/barang-masuk', [BarangMasukController::class, 'store'])->name('barang-masuk.store');
    Route::get('/barang-masuk/{id}/edit', [BarangMasukController::class, 'edit'])->name('barang-masuk.edit');
    Route::put('/barang-masuk/{id}', [BarangMasukController::class, 'update'])->name('barang-masuk.update');
    Route::delete('/barang-masuk/{id}', [BarangMasukController::class, 'destroy'])->name('barang-masuk.destroy');

    // Barang Keluar
    Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])->name('barang-keluar.index');
    Route::get('/barang-keluar/create', [BarangKeluarController::class, 'create'])->name('barang-keluar.create');
    Route::post('/barang-keluar', [BarangKeluarController::class, 'store'])->name('barang-keluar.store');
    Route::get('/barang-keluar/{id}/edit', [BarangKeluarController::class, 'edit'])->name('barang-keluar.edit');
    Route::put('/barang-keluar/{id}', [BarangKeluarController::class, 'update'])->name('barang-keluar.update');
    Route::delete('/barang-keluar/{id}', [BarangKeluarController::class, 'destroy'])->name('barang-keluar.destroy');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
