<?php
namespace kashirin\rabbit_mq;
/**
 * User: kasan
 * Date: 3/29/18
 * Time: 4:34 PM
 */

use PhpAmqpLib\Wire\IO\StreamIO;
use PhpAmqpLib\Connection\AbstractConnection;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class RabbitLogger extends AbstractConnection
{

    /**
     * Init RabbitMQ
     *
     * @param array $config - config data
     * @throws \Exception - Required fields doesn't exist
     */
    public function __construct($config = [])
    {
        $this->_checkRequiredFields($config);

        $config = $this->_setDefaultValue($config);

        $io = new StreamIO(
            $config['host'],
            $config['port'],
            $config['connection_timeout'],
            $config['read_write_timeout'],
            $config['context']
        );
        $this->sock = $io->get_socket();

        parent::__construct(
            $config['username'],
            $config['password'],
            $config['vhost'],
            $config['insist'],
            $config['login_method'],
            $config['login_response'],
            $config['locale'],
            $io
        );

        // Рекурсивно подключаемся в RabbitMQ
        $this->recursive_connection($config['reconnection_attempts']);

        // save the params for the use of __clone, this will overwrite the parent
        $this->construct_params = func_get_args();
    }

    public function handle(
        ServerRequestInterface $request,
        ServerFrameInterface $frame
    ): ResponseInterface
    {
        if ($this->isBadRequest($request)) {
            return $frame->factory()
                ->createResponse("Bad Request", 400);
        }

        return $frame->next($request);
    }


    /**
     * Рекурсивно подключаемся в RabbitMQ
     *
     * @throws \Exception - Не удалось подключиться
     */
    public function recursive_connection($reconnection_attempts)
    {
        try {
            $this->connect();

        } catch (\Exception $e) {

            for ($i=0; $i<=$reconnection_attempts; $i++) {
                try {
                    $this->reconnect();
                    break;

                } catch (\Exception $e) {
                    if ($i>=$reconnection_attempts) {
                        throw new \Exception($e->getMessage());
                    }
                }
            }
        }
    }

    /**
     * Set default values
     *
     * @param $config - config data
     * @return mixed - updated config data
     */
    protected function _setDefaultValue($config)
    {
        if (!isset($config['connection_timeout']))
            $config['connection_timeout'] = 3;

        if (!isset($config['read_write_timeout']))
            $config['read_write_timeout'] = 3;

        if (!isset($config['reconnection_attempts']))
            $config['reconnection_attempts'] = 5;

        if (!isset($config['context']))
            $config['context'] = null;

        if (!isset($config['vhost']))
            $config['vhost'] = '/';

        if (!isset($config['insist']))
            $config['insist'] = false;

        if (!isset($config['login_method']))
            $config['login_method'] = 'AMQPLAIN';

        if (!isset($config['login_response']))
            $config['login_response'] = null;

        if (!isset($config['locale']))
            $config['locale'] = 'en_US';

        return $config;
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

        if (!isset($config['username']))
            throw new \Exception("Variable username doesn't exist");

        if (!isset($config['password']))
            throw new \Exception("Variable password doesn't exist");
    }

}