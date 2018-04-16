<?php
/**
 * User: kasan
 * Date: 3/29/18
 * Time: 4:34 PM
 */

namespace kashirin\rabbit_mq;

use PhpAmqpLib\Connection\AMQPSocketConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class RabbitLogger
 * @package kashirin\rabbit_mq
 */
class RabbitLogger
{
    /**
     * @var array
     */
    private $config;

    /**
     * @var \PhpAmqpLib\Channel\AMQPChannel
     */
    private $channel;

    /**
     * Init RabbitMQ
     *
     * @param array $config - config data
     * @throws \Exception - Required fields doesn't exist
     */
    public function __construct($config)
    {
        $this->_checkRequiredFields($config);

        $connection = new AMQPSocketConnection(
            $config['host'],
            $config['port'],
            $config['user'],
            $config['password'],
            $config['vhost']
        );

        $this->channel = $connection->channel();
        $this->channel->queue_declare($this->config['queue'], false, true, false, false, false);
        //$this->channel->exchange_declare($this->config['exchange'], 'direct', false, true, false);
        //$this->channel->queue_bind($this->config['queue'], $this->config['exchange'], $this->config['key']);

    }

    /**
     * @param $data
     * @throws \AMQPChannelException
     * @throws \AMQPConnectionException
     * @throws \AMQPExchangeException
     */
    public function send($data)
    {
        if ($this->channel instanceof \AMQPExchange) {
            $this->channel->publish(
                $data,
                $this->config['key'],
                0,
                ['delivery_mode' => 2, 'content_type' => 'application/json']
            );
        } else {
            $this->channel->basic_publish(
                $this->createAmqpMessage($data),'',$this->config['queue']
            );
        }
    }

    /**
     * @param  string      $data
     * @return AMQPMessage
     */
    private function createAmqpMessage($data)
    {
        return new AMQPMessage(
            (string) $data,
            array(
                'delivery_mode' => 2,
                'content_type' => 'application/json',
            )
        );
    }

    /**
     * Check Required fields
     *
     * @param $config - config data
     * @throws \Exception -
     */
    protected function _checkRequiredFields($config)
    {
        if (!isset($config['host']))
            throw new \Exception("Variable host doesn't exist");

        if (!isset($config['port']))
            throw new \Exception("Variable port doesn't exist");

        if (!isset($config['user']))
            throw new \Exception("Variable username doesn't exist");

        if (!isset($config['password']))
            throw new \Exception("Variable password doesn't exist");

        if (!isset($config['queue']))
            throw new \Exception("Variable queue doesn't exist");

        if (!isset($config['vhost']))
            $config['vhost'] = '/';

        if (!isset($config['key']))
            $config['key'] = '';

        if (!isset($config['exchange']))
            $config['exchange'] = '';

        $this->config = $config;
    }
}