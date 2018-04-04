<?php
/**
 * User: kasan
 * Date: 4/4/18
 * Time: 3:23 PM
 */
namespace kashirin\rabbit_mq\Middlewares;

use kashirin\rabbit_mq\Log;
use \Closure;
use Mockery\Exception;

class ResponseHandlerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $response = $next($request);

        $config['name'] = "video";
        $config['host'] = 'portal-mq.diint.ab.loc'; //http://
        $config['port'] = 5672;
        $config['user'] = 'video_user';
        $config['password'] = 'video_mq';
        $config['exchange'] = 'log.direct.ex';

        try {
            $mess = new Log($config);
            $mess->log($response, $request);

        } catch (Exception $exception) {

        }


        return $response;
    }
}