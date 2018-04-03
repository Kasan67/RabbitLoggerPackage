<?php
/**
 * User: kasan
 * Date: 4/2/18
 * Time: 11:18 AM
 */

namespace kashirin\rabbit_mq;


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

    public function __construct($data)
    {
        $this->dt = $data['message'];
        $this->local_host = $data['code'];
        $this->remote_host = $data['trace'];
        $this->obj_id = $data['trace'];
        $this->app_path = $data['trace'];
    }

}