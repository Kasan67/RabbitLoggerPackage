<?php
/**
 * User: kasan
 * Date: 4/2/18
 * Time: 4:29 PM
 */

namespace kashirin\rabbit_mq\Entities;


/**
 * Class AbstractFactoryBody
 * @package kashirin\rabbit_mq
 */
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

    /**
     * @param string $type
     * @param $data
     * @param null $response
     * @return BodyInterface
     */
    abstract protected function createBody(string $type, $data, $response = null): BodyInterface;

    /**
     * @param string $type
     * @param $data
     * @param null $response
     * @return BodyInterface
     */
    public function create(string $type, $data, $response = null): BodyInterface
    {
        return $this->createBody($type, $data, $response);
    }

}