<?php


namespace LaravelLoggerExtension\Guzzle;


use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;

use Illuminate\Support\Facades\Log;
use Psr\Http\Message\ResponseInterface;

class Client extends \GuzzleHttp\Client
{
    /**
     * Client constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $passedHandler = $config['handler'] ?? null;

        if (!$passedHandler && !($passedHandler instanceof HandlerStack)) {
            $config['handler'] = $this->getHandlerStack($config);
        }

        parent::__construct($config);
    }

    /**
     * @param $config
     * @return HandlerStack
     */
    protected function getHandlerStack($config): HandlerStack
    {
        $channels = $config['log_channels'];
        $formatter = $config['log_formatter'];
        $defaultLogLevel = $config['log_default_level'];

        $handlerStack = HandlerStack::create();

        $mapResponse = Middleware::mapResponse(function (ResponseInterface $response) {
            $response->getBody()->rewind();
            return $response;
        });

        $handlerStack->push($mapResponse);

        foreach ($channels as $channel) {
            $handlerStack->push(Middleware::log(Log::channel($channel), $formatter, $defaultLogLevel));
        }

        return $handlerStack;
    }
}
