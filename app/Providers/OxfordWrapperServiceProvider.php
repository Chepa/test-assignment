<?php

namespace App\Providers;

use App\Services\OxfordDictionaries\OxfordWrapper;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

final class OxfordWrapperServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider
     */
    public function register(): void
    {
        $this->app->singleton(Client::class, function () {
            return new Client([
                'base_uri' => config('oxford-dictionary.base_url'),
                'headers' => [
                    "app_id" => config('oxford-dictionary.app_id'),
                    "app_key" => config('oxford-dictionary.app_key'),
                ]
            ]);
        });

        $this->app->bind(OxfordWrapper::class, function ($app) {
            return new OxfordWrapper($app->make(Client::class));
        });
    }
}
