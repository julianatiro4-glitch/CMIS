<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\TechnicalSupportController;

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', fn() => redirect()->route('login'));
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

Route::match(['get', 'post'], 'logout', [LoginController::class, 'logout'])->name('logout');

Route::get('assets/lookup/{tag}', [AssetController::class, 'lookup'])->name('assets.lookup');

Route::middleware('auth')->group(function () {

    Route::get('/', fn() => redirect()->route('dashboard'));
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

    Route::get('assets/export', [AssetController::class, 'export'])->name('assets.export');
    Route::get('assets/trash', [AssetController::class, 'trash'])->name('assets.trash');
    Route::get('assets/{asset}/label', [AssetController::class, 'label'])->name('assets.label');

    Route::middleware('role:admin,it_staff')->group(function () {
        Route::get('assets/create', [AssetController::class, 'create'])->name('assets.create');
        Route::post('assets', [AssetController::class, 'store'])->name('assets.store');
        Route::get('assets/{asset}/edit', [AssetController::class, 'edit'])->name('assets.edit');
        Route::put('assets/{asset}', [AssetController::class, 'update'])->name('assets.update');

        Route::post('assets/bulk-destroy', [AssetController::class, 'bulkDestroy'])->name('assets.bulk-destroy');
        Route::post('assets/bulk-force-delete', [AssetController::class, 'bulkForceDelete'])->name('assets.bulk-force-delete');
        Route::post('assets/{asset}/restore', [AssetController::class, 'restore'])->name('assets.restore');
        Route::delete('assets/{asset}/force-delete', [AssetController::class, 'forceDelete'])->name('assets.force-delete');
        Route::delete('assets/{asset}', [AssetController::class, 'destroy'])->name('assets.destroy');
    });

    Route::resource('assets', AssetController::class)->only(['index', 'show']);

    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('locations', LocationController::class);
    Route::resource('divisions', DivisionController::class);

    Route::get('technical-support', [TechnicalSupportController::class, 'index'])->name('technical_support.index');

    Route::middleware('role:admin,it_staff')->group(function () {
        Route::get('technical-support/create', [TechnicalSupportController::class, 'create'])->name('technical_support.create');
        Route::post('technical-support', [TechnicalSupportController::class, 'store'])->name('technical_support.store');
        Route::get('technical-support/{technical_support}/edit', [TechnicalSupportController::class, 'edit'])->name('technical_support.edit');
        Route::put('technical-support/{technical_support}', [TechnicalSupportController::class, 'update'])->name('technical_support.update');
        Route::delete('technical-support/{technical_support}', [TechnicalSupportController::class, 'destroy'])->name('technical_support.destroy');
    });

    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });

});
