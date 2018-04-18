<?php
/**
 * User: kasan
 * Date: 4/3/18
 * Time: 9:17 AM
 */

namespace kashirin\rabbit_mq\Entities;


/**
 * Class InfoEntity
 * @package kashirin\rabbit_mq
 */
class InfoEntity implements BodyInterface
{
    /**
     * @var - текст ошибки
     */
    public $msg_text;

    /**
     * @var - код сообщения
     */
    public $msg_code;

    /**
     * @var - stacktrace возникновения ошибки.
     */
    public $stacktrace;

    /**
     * InfoEntity constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->msg_text = $data;
        $this->msg_code = '';
    }
}