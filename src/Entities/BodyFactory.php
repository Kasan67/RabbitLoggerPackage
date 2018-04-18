<?php
/**
 * User: kasan
 * Date: 4/2/18
 * Time: 11:29 AM
 */

namespace kashirin\rabbit_mq\Entities;


/**
 * Class BodyFactory
 * @package kashirin\rabbit_mq
 */
class BodyFactory extends AbstractFactoryBody
{

    /**
     * @param string $type
     * @param $request
     * @param null $response
     * @return BodyInterface
     */
    protected function createBody(string $type, $request, $response = null): BodyInterface
    {
        switch ($type) {
            case parent::REQUEST:
                $body = new InRequestEntity($request, $response);
                break;
            case parent::ERROR:
                $body = new ErrorEntity($request);
                break;
            case parent::INFO:
                $body = new InfoEntity($request);
                break;
            case parent::DEBUG:
                $body = new DebugEntity($request);
                break;
            default:
                throw new \InvalidArgumentException("$type is not a valid log-type");
        }

        return $body;
    }

}