<?php
namespace VK;

class VKGroupsApi
{
    /**
     * @var
     */
    private $token;

    /**
     * @var array
     */
    private $allow_request_methods = ["get", "post"];

    /**
     * @var
     */
    public $request_method;

    /**
     * @var array
     */
    private $params = [];

    /**
     * @var null
     */
    private static $instance = null;

    const API_URL = 'https://api.vk.com/method/';

    /**
     * VKGroupsApi constructor.
     * @param $token
     */
    private function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Устанавливает метод обращения к api
     * @param $request_method
     * @return $this
     * @throws \Exception
     */
    private function setRequestMethod($request_method)
    {
        if (in_array($request_method, $this->allow_request_methods)) {
            $this->request_method = $request_method;
            return $this;
        }

        throw new \Exception('Request method not alllow');
    }

    /**
     * Устанавливает параметры запроса
     * @param $params
     * @return $this
     */
    private function setParams($params)
    {
        $this->params = $params;
        $this->params["access_token"] = $this->token;

        return $this;
    }

    /**
     * Для методов API требующих обращение через GET
     * @param $api_method
     * @return array|object|string
     */
    private function get($api_method)
    {
        $response = \Httpful\Request::get(
            self::API_URL . $api_method . "?" . http_build_query($this->params)
        )
            ->send();

        return $response->body;
    }

    /**
     * Для методов API требующих обращение через POST
     * @param $api_method
     * @param $attach
     * @return array|object|string
     */
    private function post($api_method, $attach)
    {
        $response = \Httpful\Request::post(
            self::API_URL . $api_method
        )
            ->body($params)
            ->sendsType(\Httpful\Mime::FORM)
            ->attach($attach)
            ->send();

        return $response->body;
    }

    /**
     * @param $request_method
     * @param $api_method
     * @param $token
     * @param $params
     * @param array $attachment
     * @return mixed
     */
    public static function send($request_method, $api_method, $token, $params, $attachment = [])
    {
        if (self::$instance === null) {
            self::$instance = new VKGroupsApi($token);
        }

        self::$instance
            ->setRequestMethod($request_method)
            ->setParams($params);


        return self::$instance->{self::$instance->request_method}($api_method, $attachment);
    }
}
