<?php

use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MaintenanceRecordController;
use App\Http\Controllers\ReportController;
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
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

    Route::get('assets/export', [AssetController::class, 'export'])->name('assets.export');
    Route::get('assets/trash', [AssetController::class, 'trash'])->name('assets.trash');
    Route::get('assets/{asset}/label', [AssetController::class, 'label'])->name('assets.label');
    Route::resource('assets', AssetController::class)->except(['destroy']);

    Route::middleware('role:admin,it_staff')->group(function () {
        Route::post('assets/bulk-destroy', [AssetController::class, 'bulkDestroy'])->name('assets.bulk-destroy');
        Route::post('assets/{asset}/restore', [AssetController::class, 'restore'])->name('assets.restore');
        Route::delete('assets/{asset}/force-delete', [AssetController::class, 'forceDelete'])->name('assets.force-delete');
        Route::delete('assets/{asset}', [AssetController::class, 'destroy'])->name('assets.destroy');
    });

    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('locations', LocationController::class);
    Route::resource('divisions', DivisionController::class);

    Route::get('assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::get('maintenance', [MaintenanceRecordController::class, 'index'])->name('maintenance.index');

    Route::middleware('role:admin,it_staff')->group(function () {
        Route::get('assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
        Route::post('assignments', [AssignmentController::class, 'store'])->name('assignments.store');
        Route::patch('assignments/{assignment}/check-in', [AssignmentController::class, 'checkIn'])->name('assignments.check-in');

        Route::get('maintenance/create', [MaintenanceRecordController::class, 'create'])->name('maintenance.create');
        Route::post('maintenance', [MaintenanceRecordController::class, 'store'])->name('maintenance.store');
        Route::get('maintenance/{maintenance}/edit', [MaintenanceRecordController::class, 'edit'])->name('maintenance.edit');
        Route::put('maintenance/{maintenance}', [MaintenanceRecordController::class, 'update'])->name('maintenance.update');
    });

    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });

});
