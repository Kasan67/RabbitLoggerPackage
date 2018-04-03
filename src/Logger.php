<?php
/**
 * User: kasan
 * Date: 3/29/18
 * Time: 4:57 PM
 */

namespace kashirin\rabbit_mq;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

class Logger
{

    /** @var null - Канал взаимодействия */
    private $_channel = null;

    /** @var RabbitLogger */
    private $rabbitLogger;

    public function __construct(RabbitLogger $rabbitLogger)
    {
        $this->rabbitLogger = $rabbitLogger;
    }

    /**
     * Отправляем сообщение в RabbitMQ
     *
     * @param $channel_name - Имя канала
     * @param $data - Данные
     */
    public function sendToRabbitMQ($channel_name, $data)
    {
        try {
            $this->_getChannel()->queue_declare($channel_name, false, true, false, false);

            $msg = new AMQPMessage(
                json_encode($data),
                ['delivery_mode' => 2] # make message persistent
            );

            $this->_getChannel()->basic_publish($msg, '', $channel_name);

        } catch (\Exception $e) {
//            Yii::$app->Logger->alert(
//                'AMQP '. $channel_name .' - Exception. Cannot send data to RabbitMQ.',
//                [
//                    'message'           => $data,
//                    'exception_message' => $e->getMessage(),
//                    's_stack_trace'     => $e->getTraceAsString()
//                ]
//            );
        }
    }

    /**
     * Получаем канал сообшений
     *
     * @return null|AMQPChannel - Канал сообщений
     */
    private function _getChannel()
    {
        if ($this->_channel == null) {
            $this->_channel = $this->rabbitLogger->channel();
        }

        return $this->_channel;
    }
}