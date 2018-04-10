<?php
/**
 * User: kasan
 * Date: 4/3/18
 * Time: 9:19 AM
 */

namespace kashirin\rabbit_mq;


/**
 * Class DebugEntity
 * @package kashirin\rabbit_mq
 */
class DebugEntity implements BodyInterface
{

    /**
     * @var - текст ошибки.
     */
    public $debug_msg;

    /**
     * DebugEntity constructor.
     * @param $data
     */
    public function __construct($data)
    {
        dd($data);
        $this->debug_msg = $data['message'];
    }
}