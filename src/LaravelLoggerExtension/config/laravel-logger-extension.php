<?php

use GuzzleHttp\MessageFormatter;
use Psr\Log\LogLevel;

return [
    'guzzle_log_integration_enabled' => true,

    'guzzle_log_integration' => [
        // add other guzzle client settings here

        // set your own handler for guzzle client
        // 'handler' => new \GuzzleHttp\HandlerStack(),

        'log_channels' => [
            'daily',
            'fluentd'
        ],
        'log_formatter' => new MessageFormatter(
            '{method}({code}) - {uri} - {req_body} - {res_body} - {req_headers} - {error}'
        ),
        'log_default_level' => LogLevel::DEBUG
    ]
];
