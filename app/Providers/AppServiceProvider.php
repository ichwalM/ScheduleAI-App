<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        // Paksa Laravel selalu menggunakan HTTPS untuk semua asset() dan route()
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }
    }
}
