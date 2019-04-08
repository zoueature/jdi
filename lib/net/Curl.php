<?php
/**
 * Created by PhpStorm.
 * User: Zou
 * Date: 2019/2/12
 * Time: 17:32
 */

namespace Net;


use Core\Cache;

class Curl
{
    private $cache;//默认使用redis
    private $curl;

    public function __construct(Cache $cache)
    {
        $this->setCache($cache);
        $this->init();
    }

    public function refreshCookie()
    {
        $this->cache->hGetAll();
    }

    private function init()
    {
        $curl = curl_init();
        $this->curl = $curl;
        $this->setHeader([
            CURLOPT_RETURNTRANSFER => true
        ]);
    }

    public function setOption(array $option)
    {
        curl_setopt_array($this->curl, $option);
    }

    public function get(string $url, array $params)
    {

    }

    public function post()
    {

    }

    public function getCookie()
    {

    }

    public function setCookie()
    {

    }

    public function setHeader()
    {

    }

    public function getHeader()
    {

    }

    public function setCache(Cache $cache)
    {
        $this->cache = $cache;
    }
}