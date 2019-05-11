<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 19-1-18
 * Time: 下午8:04
 */

namespace Net;


class HttpRequest
{
    public $method; //请求方式
    public $host; //请求host
    public $uri; //请求uri
    public $ip; //客户端IP
    public $input; //get和post的请求参数
    public $origin; //请求源

    public function __construct()
    {
        $this->method = $this->getServer('REQUEST_METHOD');
        $this->host = $this->getServer('HTTP_HOST');
        $this->uri = $this->getServer('REQUEST_URI');
        $this->ip = $this->getRemoteIp();
        $this->input = $this->getInput();
        $this->origin = $this->getServer('HTTP_ORIGIN');
    }

    private function getInput() :array
    {
        $input = array_merge($_GET, $_POST);
        if (!empty($input)) {
            foreach ($input as $key => &$value) {
                $value = addcslashes(htmlentities($value));
            }
        } else {
            $input = [];
        }
        return $input;
    }

    public function input(string $key, $default = null)
    {
        $wantValue = $this->input[$key];
        if ($wantValue === null && $default !== null) {
            return $default;
        }
        return $wantValue;
    }

    /* ----------------------------------------
     * 获取GET参数
     * ----------------------------------------
     */
    public function get($key = '', $default = null, $filter = 'addslashes')
    {
        $val = $this->getParam('GET', $key, $filter);
        if ($val === null) {
            $val = $default;
        }
        return $val;
    }

    /* ----------------------------------------
     * 获取POST参数
     * ----------------------------------------
     */
    public function post($key = '', $default = null, $filter = 'addslashes')
    {
        $val = $this->getParam('POST', $key, $filter);
        if ($val === null) {
            $val = $default;
        }
        return $val;
    }

    /* ----------------------------------------
     * 获取所有的请求参数
     * ----------------------------------------
     */
    public function request($key = '', $filter = 'addslashes')
    {
        if (!empty($key)) {
            return $this->getParam('REQUEST', $key);
        }
        $all = $this->getParam('REQUEST', '', $filter);
        return $all;
    }

    private function getParam($method, $key = '', $filter = '')
    {
        switch ($method) {
            case 'GET':
                $all = $_GET;
                break;
            case 'POST':
                $all = $_POST;
                break;
            default:
                $all = $_REQUEST;
        }
        if (empty($key)) {
            if (!empty($filter)) {
                foreach ($all as &$value) {
                    $value = $filter($value);
                }
            }
            return $all;
        }
        $value = $all[$key] ?? null;
        if (!empty($filter) && $value !== null) {
            $value = $filter($value);
        }
        return $value;
    }

    public function getServer(string $key, $default = null)
    {
        $wantValue = $_SERVER[$key] ?? null;
        if ($wantValue === null && $default !== null) {
            return $default;
        }
        return $wantValue;
    }

    public function getHost()
    {
        return $this->host;
    }

    private function getRemoteIp()
    {
        $forward = $this->getServer('HTTP_X_FORWARDED_FOR');
        if (!empty($forward)) {
            return $forward;
        } else if (!empty($this->getServer('REMOTE_ADDR'))) {
            return $forward;
        }
        return '';
    }

    public function file($filename)
    {
        return $_FILES[$filename] ?? [];
    }
}
