<?php

use App\Http\Controllers\Api\AssetController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\LocationController;
use Illuminate\Support\Facades\Route;

// Phase 1: open read/write for internal tooling.
// In Phase 2+ wrap with ->middleware('auth:sanctum') once user accounts/roles exist.
Route::prefix('v1')->group(function () {
    Route::apiResource('assets', AssetController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('locations', LocationController::class);
});
