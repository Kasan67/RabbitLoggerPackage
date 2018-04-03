<?php
/**
 * User: kasan
 * Date: 4/3/18
 * Time: 9:19 AM
 */

namespace kashirin\rabbit_mq;


class DebugEntity implements BodyInterface
{

    /**
     * @var - текст ошибки.
     */
    public $debug_msg;

    public function __construct($data)
    {
        $this->debug_msg = $data['message'];
    }
}