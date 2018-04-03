<?php
/**
 * User: kasan
 * Date: 4/2/18
 * Time: 4:41 PM
 */

namespace kashirin\rabbit_mq;


class InRequestEntity implements BodyInterface
{

    /**
     * @var - время выполнения запроса (мс)
     */
    public $duration;

    /**
     * @var - полный URI-запрос
     */
    public $request_uri = '';

    /**
     * @var - тело запроса
     */
    public $request_body;

    /**
     * @var - заголовок http пакета
     */
    public $request_headers;

    /**
     * @var - тип запроса (например, get/post)
     */
    public $request_type;

    /**
     * @var - код ответа (например, 200, 404)
     */
    public $response_code;

    /**
     * @var - тело ответа
     */
    public $response_body;

    /**
     * @var - служебная информация, заголовок http пакета.
     */
    public $response_headers;


    public function __construct($data)
    {
        $this->duration = $data['message'];
        $this->request_uri = $data['code'];
        $this->request_headers = $data['trace'];
        $this->request_body = $data['trace'];
        $this->request_type = $data['trace'];
        $this->response_code = $data['trace'];
        $this->response_body = $data['trace'];
        $this->response_headers = $data['trace'];
    }
}