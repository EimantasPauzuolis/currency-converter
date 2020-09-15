<?php

namespace App\Providers;

use App\Actions\GetExchangeRates;
use App\Actions\GetHistoricalExchangeRates;
use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(GetExchangeRates::class, function () {
            return new GetExchangeRates(
                new Client()
            );
        });
    }
}
