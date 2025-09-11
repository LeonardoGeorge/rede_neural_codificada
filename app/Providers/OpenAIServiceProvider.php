<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\WhisperService;

class OpenAIServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(WhisperService::class, function ($app) {
            return new WhisperService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
