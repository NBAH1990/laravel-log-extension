<?php

namespace LaravelLoggerExtension\Monolog\Handler;

use Fluent\Logger\FluentLogger;
use Monolog\Formatter\FluentdFormatter;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class FluentdHandler extends AbstractProcessingHandler
{
    protected $fluentLogger;

    public function __construct($level = Logger::DEBUG, bool $bubble = true)
    {
        parent::__construct($level, $bubble);

        $this->fluentLogger = new FluentLogger(
            config('laravel-logger-extension.fluentd.host'),
            config('laravel-logger-extension.fluentd.port')
        );

        $this->setFormatter(new FluentdFormatter());
    }

    protected function write(array $record): void
    {
        $this->fluentLogger->post(
            $record['level_name'],
            [
                'data' => $record['formatted']
            ]
        );
    }
}
