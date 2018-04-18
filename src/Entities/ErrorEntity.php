<?php
/**
 * User: kasan
 * Date: 4/2/18
 * Time: 4:42 PM
 */

namespace kashirin\rabbit_mq\Entities;


/**
 * Class ErrorEntity
 * @package kashirin\rabbit_mq
 */
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

    /**
     * ErrorEntity constructor.
     * @param \Throwable $exception
     */
    public function __construct(\Throwable $exception)
    {
        $this->err_text = $exception->getMessage();
        $this->err_code = $exception->getCode();
        $this->stacktrace = $exception->getTraceAsString();
    }


}