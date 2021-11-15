<?php

namespace Tq\Qbs\V1;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class HttpClient
{
    /**
     * @var string
     */
    protected $base_url = "https://mskzkt.jse.edu.cn/wxapp/api/question_base/v1/";

    /**
     * @var Client
     */
    private $client;


    public function __construct()
    {
        $this->client = new Client(["base_uri" => $this->base_url]);
    }

    /**
     * POST 请求
     * @param $uri
     * @param $form_params
     * @return ResponseInterface
     */
    public function post($uri, $form_params = [], $headers = [])
    {
        return $this->client->post($uri, [
            'form_params' => $form_params,
            'headers' => $headers
        ]);
    }


    /**
     * GET 请求
     * @param $uri
     * @param $query
     * @param $headers
     * @return ResponseInterface
     */
    public function get($uri, $query = [], $headers = [])
    {
        return $this->client->get($uri, [
            'query' => $query,
            'headers' => $headers
        ]);
    }
}
