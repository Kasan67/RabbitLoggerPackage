<?php
/**
 * User: kasan
 * Date: 3/29/18
 * Time: 4:57 PM
 */

namespace kashirin\rabbit_mq;

use Mockery\Exception;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPSocketConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Logger
{

    private $connect;
    private $config;
    private $msg;

    /**
     * @var AMQPChannel
     */
    private $ch;
    public static $logger;

    public function __construct($config)
    {
        $this->config = $config;
        try{
            $this->connect = new AMQPSocketConnection(
                $config->host,
                $config->port,
                $config->user,
                $config->pass,
                $config->vhost
            );
        }catch (\Exception $e){
            throw new Exception('Error conect to rabbit host -> '.$config->host, 360);
        }

        $type = (isset($config->type) and $config->type != '')? $config->type : 'fanout';
        $args = (isset($config->args) and $config->args != '')? $config->args : [];
        $this->prepareChannel($args, $type);
    }

    private function prepareChannel($args=[], $type='fanout')
    {

        if(isset($args) and !empty($args)) {
            foreach ($args as $key => $val) {
                $args[$key] = ['l', $val];
            }
        }

        try {
            $this->ch = $this->connect->channel();

            $this->ch->queue_declare($this->config->queue, false, true, false, false, false, $args);
            $this->ch->exchange_declare($this->config->exchange, $type, false, true, false);
            $this->ch->queue_bind($this->config->queue, $this->config->exchange);

        }catch (\Exception $e){
            throw new Exception('Error Publish Msg to Rabbit', 361);
        }
    }

    public static function getLogger($config)
    {
        if (!isset(self::$logger)) {
            self::$logger = new Logger($config);
        }
        return self::$logger;
    }

    public function publishMsg($msg, $contentType = 'application/json')
    {
        try{
            $this->msg = new AMQPMessage($msg, array('content_type' => $contentType, 'delivery_mode' => $this->config->delivery_mode));
            $this->ch->basic_publish($this->msg, $this->config->exchange);
        }catch (\Exception $e){
            throw new Exception('Error init AMQP Msg!', 362);
        }


        return true;
    }

    public function __destruct()
    {
        $this->ch->close();
        $this->connect->close();
    }
}