<?php
/**
 * User: kasan
 * Date: 4/4/18
 * Time: 3:23 PM
 */
namespace kashirin\rabbit_mq\Middlewares;

use Illuminate\Foundation\Application;
use kashirin\rabbit_mq\Log;
use \Closure;

/**
 * Class ResponseHandlerMiddleware
 * @package kashirin\rabbit_mq\Middlewares
 */
class ResponseHandlerMiddleware
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @var Log
     */
    private $logger;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->logger = new Log($this->app['config']['services.rabbit_log']);
    }

    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws \AMQPChannelException
     * @throws \AMQPConnectionException
     * @throws \AMQPExchangeException
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $this->logger->log($response, $request);

        return $response;
    }
}