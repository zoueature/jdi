<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 19-1-18
 * Time: 下午8:04
 */

namespace Net;


class HttpResponse
{
    public function headerArray(array $headers)
    {
        foreach ($headers as $column => $value) {
            header("$column : $value");
        }
    }

    public function header(string $column, string $value)
    {
        header("$column : $value");
    }


    public function allowCrossDomain($domain)
    {
        if (is_string($domain)) {
            if (preg_match('#/.*/#', $domain)) {
                //$domain是正则
                $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
                if (preg_match($domain, $origin)) {
                    $this->header('Access-Control-Allow-Origin', $domain);
                }
            } else {
                $this->header('Access-Control-Allow-Origin', $domain);
            }
        } else if (is_array($domain)) {
            $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
            if (in_array($origin, $domain)) {
                $this->header('Access-Control-Allow-Origin', $origin);
            }
        }
    }

    public function json($data)
    {
        $this->header('Content-Type', 'application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }
}