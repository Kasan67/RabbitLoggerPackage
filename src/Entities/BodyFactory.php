<?php
/**
 * User: kasan
 * Date: 4/2/18
 * Time: 11:29 AM
 */

namespace kashirin\rabbit_mq;



class BodyFactory extends AbstractFactoryBody
{

    protected function createBody(string $type, $data): BodyInterface
    {
        switch ($type) {
            case parent::REQUEST:
                $body = new InRequestEntity($data);
                break;
            case parent::ERROR:
                $body = new ErrorEntity($data);
                break;
            case parent::INFO:
                $body = new InfoEntity($data);
                break;
            case parent::DEBUG:
                $body = new DebugEntity($data);
                break;
            default:
                throw new \InvalidArgumentException("$type is not a valid log-type");
        }

        return $this->getBody($body);
    }


    public function getBody(BodyInterface $body)
    {
        return get_class_vars($body);
    }


}