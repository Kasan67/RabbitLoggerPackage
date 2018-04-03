<?php
/**
 * User: kasan
 * Date: 4/2/18
 * Time: 3:00 PM
 */

namespace kashirin\rabbit_mq;

use Monolog\Formatter\NormalizerFormatter;

class RabbitLogFormatter extends NormalizerFormatter
{
    private $type;

    public function __construct(?string $dateFormat = 'yyyyMMdd HH:mm:ss.SSS', $type = Log::DEBUG)
    {
        parent::__construct($dateFormat);

        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     */
    public function format(array $record)
    {
        $record = parent::format($record);
        $message = new LogEntity($record, $this->type);
        $message = $message->getLog();

        return $this->toJson($message) . "\n";
    }


}