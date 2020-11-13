<?php


namespace LaravelLoggerExtension\Monolog\Handler;


use Monolog\Handler\TelegramBotHandler;

class TelegramBotCutHandler extends TelegramBotHandler
{
    protected function write(array $record): void
    {
        $this->send(substr($record['formatted'],0,4096));
    }
}
