<?php
/**
 * User: kasan
 * Date: 4/3/18
 * Time: 4:23 PM
 */

namespace kashirin\rabbit_mq;

use Illuminate\Support\ServiceProvider;

/**
 * Class RabbitLoggerServiceProvider
 * @package kashirin\rabbit_mq
 */
class RabbitLoggerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Log::class, function ($app) {
            return new Log($app['config']['services.rabbit_log']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Log::class];
    }
}


