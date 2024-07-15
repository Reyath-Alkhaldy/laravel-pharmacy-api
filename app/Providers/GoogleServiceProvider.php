<?php

namespace App\Providers;

use App\Services\GoogleClientService;
use App\Services\NotificationService;
use Illuminate\Support\ServiceProvider;

class GoogleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(GoogleClientService::class, function ($app) {
            return new GoogleClientService();
        });

        $this->app->singleton(NotificationService::class, function ($app) {
            return new NotificationService($app->make(GoogleClientService::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
