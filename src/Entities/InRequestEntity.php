<?php
/**
 * User: kasan
 * Date: 4/2/18
 * Time: 4:41 PM
 */

namespace kashirin\rabbit_mq\Entities;


use Illuminate\Http\Request;

/**
 * Class InRequestEntity
 * @package kashirin\rabbit_mq
 */
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


    /**
     * InRequestEntity constructor.
     * @param $request
     * @param $response
     */
    public function __construct($request, $response)
    {
        $isYii = get_class($request) == 'yii\web\Request';
        $this->duration = $this->getDuration($_SERVER['REQUEST_TIME_FLOAT']);
        $this->request_uri = ($isYii) ? $request->getAbsoluteUrl() : $request->fullUrl();
        $this->request_headers = ($isYii) ? $request->headers->toArray() : $request->headers->all();

        if ($isYii) {
            $this->request_body = ($request->getRawBody()) ? $request->getRawBody() : $request->getQueryParams();
        } else {
            $this->request_body = $request->all();
        }

        $this->request_type = $request->getMethod();
        $this->response_code = ($isYii) ? $response->getstatusCode() : $response->status();
        $this->response_body = ($isYii) ? $response->data : $response->getOriginalContent();
        $this->response_headers =  ($isYii) ? $response->headers->toArray() : $response->headers->all();
    }

    /**
     * @param $time
     * @return float
     */
    private function getDuration($time)
    {
        return round((microtime(true) -  number_format($time, 3, '.', '')), 3) * 1000 . ' ms';
    }
}