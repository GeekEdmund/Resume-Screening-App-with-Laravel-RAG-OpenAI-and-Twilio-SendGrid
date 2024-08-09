<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\OpenAIService;
use App\Services\RAGService;
use App\Services\SendGridService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(OpenAIService::class, function ($app) {
            return new OpenAIService();
        });

        $this->app->singleton(RAGService::class, function ($app) {
            return new RAGService($app->make(OpenAIService::class));
        });

        $this->app->singleton(SendGridService::class, function ($app) {
            return new SendGridService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
