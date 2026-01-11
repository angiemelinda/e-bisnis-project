<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Midtrans\Config;

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
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = config('midtrans.is_sanitized', true);
        Config::$is3ds = config('midtrans.is_3ds', true);
        
        // Fix SSL certificate issue for development/sandbox environment
        // This is especially needed for Windows/XAMPP where CA bundle might not be available
        if (!config('midtrans.is_production', false)) {
            // Initialize curlOptions as array if not already set
            if (!isset(Config::$curlOptions) || !is_array(Config::$curlOptions)) {
                Config::$curlOptions = [];
            }
            
            // Disable SSL verification for sandbox/development only
            // WARNING: Never use this in production! Only for development/sandbox mode
            Config::$curlOptions[CURLOPT_SSL_VERIFYPEER] = false;
            Config::$curlOptions[CURLOPT_SSL_VERIFYHOST] = false;
            Config::$curlOptions[CURLOPT_RETURNTRANSFER] = true;
            Config::$curlOptions[CURLOPT_TIMEOUT] = 60;
            Config::$curlOptions[CURLOPT_CONNECTTIMEOUT] = 30;
            Config::$curlOptions[CURLOPT_FOLLOWLOCATION] = true;
            Config::$curlOptions[CURLOPT_MAXREDIRS] = 5;
        }
    }

}
