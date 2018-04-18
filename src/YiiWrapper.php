<?php
/**
 * User: kasan
 * Date: 4/18/18
 * Time: 12:41 PM
 */

namespace kashirin\rabbit_mq;

use yii\base\BootstrapInterface;
use yii\base\Configurable;


class YiiWrapper extends Log implements Configurable, BootstrapInterface
{

    /**
     * Construct
     *
     * @param array $config - Конфиги компонента
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    /**
     * @param \yii\base\Application|\WebApplication $app
     */
    public function bootstrap($app)
    {

    }


}