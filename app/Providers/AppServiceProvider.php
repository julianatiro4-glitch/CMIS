<?php

namespace App\Providers;

use App\Models\Asset;
use App\Models\TechnicalSupport;
use App\Observers\AssetObserver;
use App\Observers\TechnicalSupportObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Asset::observe(AssetObserver::class);
        TechnicalSupport::observe(TechnicalSupportObserver::class);
    }
}