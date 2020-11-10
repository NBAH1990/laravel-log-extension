<?php

namespace LaravelLoggerExtension\Monolog\Handler;

use Fluent\Logger\FluentLogger;
use Monolog\Formatter\FluentdFormatter;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

/**
 * Class FluentdHandler
 * @package LaravelLoggerExtension\Monolog\Handler
 */
class FluentdHandler extends AbstractProcessingHandler
{
    /**
     * @var FluentLogger
     */
    protected $fluentLogger;

    /**
     * FluentdHandler constructor.
     * @param string $host
     * @param string $port
     * @param int $level
     * @param bool $bubble
     */
    public function __construct(string $host, string $port, $level = Logger::DEBUG, bool $bubble = true)
    {
        parent::__construct($level, $bubble);

        $this->fluentLogger = new FluentLogger($host, $port);

        $this->setFormatter(new FluentdFormatter());
    }

    /**
     * @param array $record
     */
    protected function write(array $record): void
    {
        $this->fluentLogger->post(
            $record['level_name'],
            [
                'message' => $record['message'],
                'context' => $record['context']
            ]
        );
    }
}
