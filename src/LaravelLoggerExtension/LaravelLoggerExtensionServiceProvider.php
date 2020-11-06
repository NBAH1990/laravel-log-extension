<?php


namespace LaravelLoggerExtension;


use Illuminate\Support\ServiceProvider;

class LaravelLoggerExtensionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $source = realpath($raw = __DIR__.'/./config/laravel-logger-extension.php') ?: $raw;

        $this->publishes([$source => config_path('laravel-logger-extension.php')], 'config');
        $this->mergeConfigFrom($source, 'laravel-logger-extension');
    }
}
