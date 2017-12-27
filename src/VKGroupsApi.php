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
    private $params = [];


    const API_URL = 'https://api.vk.com/method/';

    /**
     * VKGroupsApi constructor.
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Устанавливает параметры запроса
     * @param $params
     * @return $this
     */
    public function setParams($params)
    {
        $this->params = $params;
        $this->params["access_token"] = $this->token;

        return $this;
    }


    /**
     * @param $api_method
     * @param $params
     * @return array|object|string
     */
    public function request($api_method, $params)
    {
        $this->setParams($params);

        $response = \Httpful\Request::get(
            self::API_URL . $api_method . "?" . http_build_query($this->params)
        )
            ->send();

        return $response->body;
    }
}
