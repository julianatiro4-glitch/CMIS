<?php

namespace App\Providers;

use App\Models\Asset;
use App\Models\Assignment;
use App\Models\MaintenanceRecord;
use App\Observers\AssetObserver;
use App\Observers\AssignmentObserver;
use App\Observers\MaintenanceRecordObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Asset::observe(AssetObserver::class);
        Assignment::observe(AssignmentObserver::class);
        MaintenanceRecord::observe(MaintenanceRecordObserver::class);
    }
}