<?php
/**
 * User: kasan
 * Date: 4/4/18
 * Time: 10:23 AM
 */

namespace kashirin\rabbit_mq;


use Illuminate\Support\Manager;

class LoggerManager extends Manager
{

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return new Log($this->app['config']['services.rabbit_log']);
    }
}