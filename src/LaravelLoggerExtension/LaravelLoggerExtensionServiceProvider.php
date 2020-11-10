<?php


namespace LaravelLoggerExtension;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class LaravelLoggerExtensionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $source = realpath($raw = __DIR__ . '/./config/laravel-logger-extension.php') ?: $raw;

        $this->publishes([$source => config_path('laravel-logger-extension.php')], 'config');
        $this->mergeConfigFrom($source, 'laravel-logger-extension');
    }

    public function register()
    {
        if (config('laravel-logger-extension.guzzle_log_integration_enabled') === true) {
            $this->app->bind(Client::class, function () {
                return new \LaravelLoggerExtension\Guzzle\Client(config('laravel-logger-extension.guzzle_log_integration'));
            });
        }
    }
}
