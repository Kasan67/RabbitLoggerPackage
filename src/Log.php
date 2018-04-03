<?php
/**
 * User: kasan
 * Date: 4/2/18
 * Time: 10:22 AM
 */

namespace kashirin\rabbit_mq;

use Monolog\Logger;
use Monolog\Handler\AmqpHandler;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Psr\Log\LoggerInterface;

class Log extends Logger implements LoggerInterface
{
    private $config;
    private $channel;

    public function __construct($config, $handlers = array(), $processors = array())
    {
        parent::__construct($config['name'], $handlers, $processors);

        $this->config = $config;

        $connection = new AMQPStreamConnection($config['host'], $config['port'], $config['user'], $config['password']);
        $this->channel = $connection->channel();

    }

    public function addWarning($message, array $context = array())
    {
        $rmqhandler = new AmqpHandler($this->channel, $this->config['name'], Logger::WARNING);
        $rmqhandler->setFormatter(new RabbitLogFormatter($this->config['name']));
        $this->pushHandler($rmqhandler);

        return parent::addWarning($message, $context);
    }

    public function addAlert($message, array $context = array())
    {
        $rmqhandler = new AmqpHandler($this->channel, $this->config['name'], Logger::ALERT);
        $rmqhandler->setFormatter(new RabbitLogFormatter($this->config['name']));
        $this->pushHandler($rmqhandler);

        return parent::addAlert($message, $context);
    }
}