Package contains:

* laravel/lumen + monolog -> fluentd integration;
* guzzle requests log middleware;

___

***To install the package use:***
```
composer require nbah1990/laravel-logger-extension
```

___

***How to use fluentd integration:***

1) Add to the `logging.php` config a new channel:

```php
        'fluentd' => [
            'driver' => 'monolog',
            'handler' => \LaravelLoggerExtension\Monolog\Handler\FluentdHandler::class,
            'level' => 'debug',
            'handler_with' => [
                'host' => env('FLUENTD_HOST'),
                'port' => env('FLUENTD_PORT')
            ],
        ]
```


___

***How to use guzzle/http log integration:***

1) Create or publish the config `laravel-logger-extension.php`(you can find default config here `vendor/nbah1990/laravel-logger-extension/src/LaravelLoggerExtension/config/laravel-logger-extension.php`.
By default, it looks like:
```php
return [
    // pass true to enable log of all guzzle requests
    'guzzle_log_integration_enabled' => false,

    // guzzle client config with additions for logger
    'guzzle_log_integration' => [
        // you can add other guzzle client settings here

        // you can set your own handler for guzzle client
        // 'handler' => new \GuzzleHttp\HandlerStack(),

        // pass channels that should be used to write logs, they should be defined in the 'logging.php' configuration
        'log_channels' => [

        ],

        // format of the log message
        'log_formatter' => new \GuzzleHttp\MessageFormatter(
            '{method}({code}) - {uri} - {req_body} - {res_body} - {req_headers} - {error}'
        ),
        
        //by default all responses will be wrote with this level
        'log_default_level' => \Psr\Log\LogLevel\LogLevel::DEBUG
    ]
];

```
