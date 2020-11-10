<?php

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
