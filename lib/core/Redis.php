<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 18-11-24
 * Time: 上午10:11
 */

namespace Core;


use Abs\NoSql;

class Redis implements NoSql
{
    private $not_null =['host', 'port'];
    private $redis;

    public function __construct()
    {
        try {
            $this->init();
        } catch (JdiException $e) {
            Logger::error($e->getMessage());
        }
    }

    private function init()
    {
        $config = config('cache');
        $config = $config['redis'];
        foreach ($this->not_null as $key) {
            if (empty($config[$key])) {
                throw new JdiException('Redis config error '. $key);
            }
        }
        $this->redis = new \Redis();
        $this->redis->connect($config['host'], $config['port']);
        $this->redis->auth($config['auth']);
    }

    public function get($key)
    {
        return $this->redis->get($key);
    }

    public function set($key, $value)
    {
        return $this->redis->set($key, $value);
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->redis, $name], $arguments);
    }
}