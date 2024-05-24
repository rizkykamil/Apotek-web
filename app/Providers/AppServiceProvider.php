<?php

namespace App\Providers;

use Midtrans\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
    public function boot()
    {
        if (config('app.env') === 'local') {
            URL::forceScheme(
                'https'
            );
        }
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$clientKey = config('midtrans.client_key');
        Config::$is3ds = true;
        Config::$isSanitized = true;
        
    }
}
