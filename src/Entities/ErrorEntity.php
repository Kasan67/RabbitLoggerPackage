<?php
/**
 * User: kasan
 * Date: 4/2/18
 * Time: 4:42 PM
 */

namespace kashirin\rabbit_mq;


class ErrorEntity implements BodyInterface
{
    /**
     * @var - текст ошибки
     */
    public $err_text;

    /**
     * @var - код логической или системной ошибки (если есть такой)
     */
    public $err_code = '';

    /**
     * @var - stacktrace возникновения ошибки.
     */
    public $stacktrace;

    public function __construct($data)
    {
        $this->err_text = $data['message'];
        $this->err_code = $data['code'];
        $this->stacktrace = $data['trace'];
    }


}