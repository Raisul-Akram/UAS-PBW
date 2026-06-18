<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ServisController as AdminServisController;
use App\Http\Controllers\Admin\TeknisiController as AdminTeknisiController;
use App\Http\Controllers\Admin\PelangganController as AdminPelangganController;
use App\Http\Controllers\Pelanggan\DashboardController as PelangganDashboardController;
use App\Http\Controllers\Pelanggan\ServisController as PelangganServisController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Rute redirect /dashboard berdasarkan role
Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('pelanggan.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Grup Rute Admin (Dilindungi auth dan admin middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('servis', AdminServisController::class)->parameters(['servis' => 'servis']);
    Route::resource('teknisi', AdminTeknisiController::class);
    Route::resource('pelanggan', AdminPelangganController::class)->only(['index', 'show', 'edit', 'update']);
});

// Grup Rute Pelanggan (Dilindungi auth)
Route::middleware(['auth'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/dashboard', [PelangganDashboardController::class, 'index'])->name('dashboard');
    Route::resource('servis', PelangganServisController::class)->only(['index', 'create', 'store', 'show'])->parameters(['servis' => 'servis']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
