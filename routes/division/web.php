<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MaintenanceRecordController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('assets.index'));

// --- Login / Logout (custom, no Breeze/npm needed) ---
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});
Route::post('logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::get('assets/export', [AssetController::class, 'export'])->name('assets.export');
Route::get('assets/trash', [AssetController::class, 'trash'])->name('assets.trash');
Route::post('assets/{asset}/restore', [AssetController::class, 'restore'])->name('assets.restore');
Route::delete('assets/{asset}/force-delete', [AssetController::class, 'forceDelete'])->name('assets.force-delete');

// --- Phase 1: read access stays open for anyone ---
Route::resource('assets', AssetController::class);
Route::resource('categories', CategoryController::class)->except(['show']);
Route::resource('locations', LocationController::class);
Route::resource('divisions', DivisionController::class);

// --- Phase 2: maintenance requires login ---
Route::middleware('auth')->group(function () {
    Route::get('maintenance', [MaintenanceRecordController::class, 'index'])->name('maintenance.index');

    // Only Admin / IT Staff can create or modify tickets
    Route::middleware('role:admin,it_staff')->group(function () {
        Route::get('maintenance/create', [MaintenanceRecordController::class, 'create'])->name('maintenance.create');
        Route::post('maintenance', [MaintenanceRecordController::class, 'store'])->name('maintenance.store');
        Route::get('maintenance/{maintenance}/edit', [MaintenanceRecordController::class, 'edit'])->name('maintenance.edit');
        Route::put('maintenance/{maintenance}', [MaintenanceRecordController::class, 'update'])->name('maintenance.update');
    });

    // Only Admin can manage user accounts
    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });
});

/*
 * Login/logout are handled above by a custom LoginController — no Laravel
 * Breeze or npm/Vite build step required.
 */