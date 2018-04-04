<?php
/**
 * User: kasan
 * Date: 4/2/18
 * Time: 10:22 AM
 */

namespace kashirin\rabbit_mq;

use Mockery\Exception;
use Monolog\Logger;
use Monolog\Handler\AmqpHandler;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Psr\Log\LoggerInterface;

class Log implements LoggerInterface //extends Logger
{
    /**  - error - сообщение об ошибке */
    const ERROR = 'error';

    /** - info - информационное сообщение */
    const INFO = 'info';

    /** - inrequest - данные поступившего запроса и отправленного ответа */
    const REQUEST = 'inrequest';

    /** - debug - отладочная информация */
    const DEBUG = 'debug';

    private $config;
    private $channel;

    public function __construct($config)
    {
        $this->_checkRequiredFields($config);

        try {
            $connection = new AMQPStreamConnection($this->config['host'], $this->config['port'], $this->config['user'], $this->config['password'], $this->config['name']);
            $this->channel = $connection->channel();
            $rmqhandler = new AmqpHandler($this->channel, $this->config['name']);
            $rmqhandler->setFormatter(new RabbitLogFormatter($this->config['name']));

//        $channel->queue_declare($this->config['exchange'], false, false, false, false);
//
//        $msg = new AMQPMessage('Hello World!');
//        $channel->basic_publish($msg, '', 'hello');
//
//        echo " [x] Sent 'Hello World!'\n";


        } catch (Exception $e){
            throw new Exception('Error connect to Rabbit', '330');
        }

    }

    public function prepareLog($message, $type, $response = null)
    {
        $message = new LogEntity($message, $type, $response);
        dd($message);
        $message = $message->getLog();
    }

//    public function addWarning($message, array $context = array())
//    {
//        $rmqhandler = new AmqpHandler($this->channel, $this->config['name'], Logger::WARNING);
//        $rmqhandler->setFormatter(new RabbitLogFormatter($this->config['name']));
//        $ff = new RabbitLogFormatter($this->config['name'], Logger::WARNING);
//        $ss = $ff->format($context);
//        dd($ss);
////        $this->pushHandler($rmqhandler);
//
//        return ;//parent::addWarning($message, $context);
//    }

//    public function addAlert($message, array $context = array())
//    {
//        $rmqhandler = new AmqpHandler($this->channel, $this->config['name'], Logger::ALERT);
//        $rmqhandler->setFormatter(new RabbitLogFormatter($this->config['name']));
////        $this->pushHandler($rmqhandler);
//
//        return parent::addAlert($message, $context);
//    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function emergency($message, array $context = array())
    {
        $this->prepareLog($message, self::ERROR);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function alert($message, array $context = array())
    {
        $this->prepareLog($message, self::ERROR);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function critical($message, array $context = array())
    {
        $this->prepareLog($message, self::ERROR);
    }

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function error($message, array $context = array())
    {
        $this->prepareLog($message, self::ERROR);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function warning($message, array $context = array())
    {
        $this->prepareLog($message, self::REQUEST);
    }

    /**
     * Normal but significant events.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function notice($message, array $context = array())
    {
        $this->prepareLog($message, self::REQUEST);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function info($message, array $context = array())
    {
        $this->prepareLog($message, self::INFO);
    }

    /**
     * Detailed debug information.
     *
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function debug($message, array $context = array())
    {
        $this->prepareLog($message, self::DEBUG);
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function log($level, $message, array $context = array())
    {
        $this->prepareLog($message, self::REQUEST, $level);
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

        if (!isset($config['name']))
            $config['name'] = '';

        $this->config = $config;
    }

}