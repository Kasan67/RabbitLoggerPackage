<?php
/**
 * User: kasan
 * Date: 3/29/18
 * Time: 4:57 PM
 */

namespace kashirin\rabbit_mq;


use Ramsey\Uuid\Uuid;

/**
 * Class LogEntity
 * @package kashirin\rabbit_mq
 */
class LogEntity
{
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

    /**
     * LogEntity constructor.
     * @param $message
     * @param $type
     * @param $response
     * @param $facility
     */
    public function __construct($message, $type, $response, $facility)
    {
        $this->extref = Uuid::uuid4()->toString();
        $this->type_msg = $type;

        // в зависимости от типа создаем нужное тело запроса при помощи фабрики
        $factory = new BodyFactory();
        $this->data_type = $this->getLog($factory->create($type, $message, $response));

        // информация о хостах
        $this->data_obj = $this->getLog(new ObjectInfoEntity($facility));

        //TODO get SID from Chameleon
    }

    /**
     * @param null $obj
     * @return array
     */
    public function getLog($obj = null): array
    {
        return ($obj) ? get_object_vars($obj) : get_object_vars($this);
    }

}