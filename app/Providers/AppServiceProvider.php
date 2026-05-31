<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Video;
use App\Observers\VideoObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        require_once app_path('own.php');
        Video::observe(VideoObserver::class);
    }
}
