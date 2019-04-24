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
        $value = $all[$key];
        if (!empty($filter)) {
            $value = $filter($value);
        }
        return $value;
    }

    public function getServer(string $key, $default)
    {

    }

    public function getHost()
    {

    }

    public function getRemoteIp()
    {

    }
}
