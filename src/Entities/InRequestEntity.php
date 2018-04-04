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


    public function __construct($request, $response)
    {
        $this->duration = $this->getDuration($request->server->get('REQUEST_TIME'), $request->server->get('REQUEST_TIME_FLOAT'));
        $this->request_uri = $request->fullUrl();
        $this->request_headers = $request->headers->all();
        $this->request_body = $request->all();
        $this->request_type = $request->getMethod();

//        $this->response_code = $response->getCode();
//        $this->response_body = $response->body->all();
//        $this->response_headers = $response->headers->all();
    }

    private function getDuration($start, $end)
    {
        return $end - $start;
    }
}