<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
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
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
            $this->app->bind('path.public', function() {
                return base_path('../public_html'); 
            });
        }

        if (Schema::hasTable('settings')) {
            $settings = Setting::pluck('value', 'key')->all();
            view()->share('appSettings', $settings);
        }
    }
}
