<?php

namespace App\Providers;

use App\Models\Measurements;
use App\Observers\MeasurementObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Measurements::observe(MeasurementObserver::class);
    }
}
