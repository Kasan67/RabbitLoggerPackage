<?php
/**
 * User: kasan
 * Date: 4/2/18
 * Time: 4:29 PM
 */

namespace kashirin\rabbit_mq;


abstract class AbstractFactoryBody
{
    /**  - error - сообщение об ошибке */
    const ERROR = 'error';

    /** - info - информационное сообщение */
    const INFO = 'info';

    /** - inrequest - данные поступившего запроса и отправленного ответа */
    const REQUEST = 'inrequest';

    /** - debug - отладочная информация */
    const DEBUG = 'debug';

    abstract protected function createBody(string $type, $data): BodyInterface;

    public function create(string $type, $data): BodyInterface
    {
        $obj = $this->createBody($type, $data);

        return $obj;
    }
}