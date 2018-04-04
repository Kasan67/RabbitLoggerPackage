<?php
/**
 * User: kasan
 * Date: 4/2/18
 * Time: 4:42 PM
 */

namespace kashirin\rabbit_mq;


use Mockery\Exception;

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

    public function __construct(Exception $data)
    {
        $this->err_text = $data->getMessage();
        $this->err_code = $data->getCode();
        $this->stacktrace = $data->getTraceAsString();
    }


}