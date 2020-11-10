<?php


namespace LaravelLoggerExtension;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

use Illuminate\Foundation\Application as LaravelApplication;
use Laravel\Lumen\Application as LumenApplication;

class LaravelLoggerExtensionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->setupConfig();
        $this->setupGuzzleIntegration();
    }


    protected function setupGuzzleIntegration() {
        if (config('laravel-logger-extension.guzzle_log_integration_enabled') === true) {
            $this->app->bind(Client::class, function () {
                return new \LaravelLoggerExtension\Guzzle\Client(config('laravel-logger-extension.guzzle_log_integration'));
            });
        }
    }

    protected function setupConfig()
    {
        $source = realpath(__DIR__.'/config/laravel-logger-extension.php');

        if ($this->app instanceof LaravelApplication) {
            $this->publishes([$source => config_path('laravel-logger-extension.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('laravel-logger-extension');
        }

        $this->mergeConfigFrom($source, 'laravel-logger-extension');
    }
}
