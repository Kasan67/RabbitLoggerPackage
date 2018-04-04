<?php
/**
 * User: kasan
 * Date: 3/29/18
 * Time: 4:57 PM
 */

namespace kashirin\rabbit_mq;

use Monolog\Logger;

class LogEntity
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
     * @var - уникальный идентификатор операции;
     */
    public $extref;

    /**
     * @var - тип записи (error, info, inrequest, debug)
     */
    public $type_msg;

    /**
     * @var - содержит расширенную информацию о событии логирования, в зависимости от его типа (type)
     */
    public $data_type;

    /**
     * @var - идентификатор сессии, от имени которой выполняется операция
     */
    public $sid;

    /**
     * @var - информация о продукте
     */
    public $data_obj;

    public function __construct($message, $type, $response)
    {
        $this->extref = $message['cookie'];

        // в зависимости от типа создаем нужное тело запроса
        $factory = new BodyFactory();
        $this->data_type = $factory->create($type, $message, $response);

        // информация о хостах
        $this->data_obj = new ObjectInfoEntity($message);
    }

    public function getLog()
    {
        return get_class_vars($this);
    }

}