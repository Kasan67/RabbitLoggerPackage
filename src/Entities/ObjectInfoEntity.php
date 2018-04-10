<?php
/**
 * User: kasan
 * Date: 4/2/18
 * Time: 11:18 AM
 */

namespace kashirin\rabbit_mq;


/**
 * Class ObjectInfoEntity
 * @package kashirin\rabbit_mq
 */
class ObjectInfoEntity implements BodyInterface
{

    /**
     * @var - дата и время события в формате "yyyyMMdd HH:mm:ss.SSS"
     */
    public $dt;

    /**
     * @var - адрес удалённого узла
     */
    public $local_host;

    /**
     * @var - - ip-адрес хоста, с которым проходит обмен данными
     */
    public $remote_host;

    /**
     * @var - название проекта согласно документации (имя в гите относительно папки)
     */
    public $obj_id;

    /**
     * @var -  путь к приложению
     */
    public $app_path;

    /**
     * ObjectInfoEntity constructor.
     * @param $facility
     */
    public function __construct($facility)
    {
        $dateObj = \DateTime::createFromFormat('U.u', $_SERVER['REQUEST_TIME_FLOAT']);

        $this->dt = $dateObj->format('Y-m-d H:i:s:u');
        $this->local_host = $_SERVER['HTTP_HOST'];
        $this->remote_host = $_SERVER['REMOTE_ADDR'];
        $this->obj_id = $facility;
        $this->app_path = $_SERVER['DOCUMENT_ROOT'];
    }

}