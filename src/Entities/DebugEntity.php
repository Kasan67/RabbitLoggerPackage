<?php
/**
 * User: kasan
 * Date: 4/3/18
 * Time: 9:19 AM
 */

namespace kashirin\rabbit_mq\Entities;


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
        if (!$this->debug_msg = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)) {
            $this->debug_msg = json_last_error();
        }
    }
}