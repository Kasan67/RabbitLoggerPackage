<?php
/**
 * User: kasan
 * Date: 4/2/18
 * Time: 10:22 AM
 */

namespace kashirin\rabbit_mq;

use kashirin\rabbit_mq\Entities\LogEntity;

use Psr\Log\LoggerInterface;

/**
 * Class Log
 * @package kashirin\rabbit_mq
 */
class Log implements LoggerInterface
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
     * @var string
     */
    private $facility;

    /**
     * @var RabbitLogger
     */
    private $rabbit;

    /**
     * Log constructor.
     * @param $config
     * @throws \Exception
     */
    public function __construct($config)
    {
        $this->rabbit = new RabbitLogger($config);
        $this->facility = $config['facility'];
    }

    /**
     * @param $message
     * @param $type
     * @param null $response
     *
     * @throws \AMQPChannelException
     * @throws \AMQPConnectionException
     * @throws \AMQPExchangeException
     */
    private function prepareLog($message, $type, $response = null)
    {
        $message = new LogEntity($message, $type, $response, $this->facility);
        $data = json_encode($message->getLog(),  JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $this->rabbit->send($data);
    }

    /**
     * System is unusable.
     *
     * @param string $message
     * @param array $context
     *
     * @throws \AMQPChannelException
     * @throws \AMQPConnectionException
     * @throws \AMQPExchangeException
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
     * @throws \AMQPChannelException
     * @throws \AMQPConnectionException
     * @throws \AMQPExchangeException
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
     * @throws \AMQPChannelException
     * @throws \AMQPConnectionException
     * @throws \AMQPExchangeException
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
     * @throws \AMQPChannelException
     * @throws \AMQPConnectionException
     * @throws \AMQPExchangeException
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
     * @throws \AMQPChannelException
     * @throws \AMQPConnectionException
     * @throws \AMQPExchangeException
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
     * @throws \AMQPChannelException
     * @throws \AMQPConnectionException
     * @throws \AMQPExchangeException
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
     * @throws \AMQPChannelException
     * @throws \AMQPConnectionException
     * @throws \AMQPExchangeException
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
     * @throws \AMQPChannelException
     * @throws \AMQPConnectionException
     * @throws \AMQPExchangeException
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
     * @throws \AMQPChannelException
     * @throws \AMQPConnectionException
     * @throws \AMQPExchangeException
     *
     * @return void
     */
    public function log($level, $message, array $context = array())
    {
        $this->prepareLog($message, self::REQUEST, $level);
    }



}