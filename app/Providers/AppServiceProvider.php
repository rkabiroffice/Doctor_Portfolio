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
        $publicPath = env('APP_PUBLIC_PATH');

        if ($publicPath) {
            if (preg_match('/^(?:[A-Za-z]:\\|\\\\|\/)/', $publicPath)) {
                $publicPath = $publicPath;
            } else {
                $publicPath = base_path($publicPath);
            }
        } elseif ($this->app->environment('production')) {
            $publicPath = base_path('../public_html');
        } else {
            $publicPath = base_path('public');
        }

        $this->app->bind('path.public', function () use ($publicPath) {
            return $publicPath;
        });

        if (Schema::hasTable('settings')) {
            $settings = cache()->remember('app_settings', now()->addMinutes(5), fn () => Setting::pluck('value', 'key')->all());
            view()->share('appSettings', $settings);
        }
    }
}
