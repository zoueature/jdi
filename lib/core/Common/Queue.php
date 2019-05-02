<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 19-1-20
 * Time: 下午12:43
 */

namespace Core\Common;


use Core\Abs\QueueI;

class Queue implements QueueI
{
    private $driver;

    public function __construct(string $driver = 'redis')
    {
        $this->init($driver);
    }

    public function init(string $driver)
    {
        $drivers = config('driver');
        if (!empty($drivers['queue'])) {
            $driver = $drivers['queue'];
        }
        switch (strtolower($driver)) {
            case 'redis':
                $instance = make(Redis::class);
                break;
            case 'memcache':
                $instance = make(Memcache::class);
                break;
            default:
                $instance = make(Redis::class);
        }
        $this->driver = $instance;
    }

    public function delete(): bool
    {
        // TODO: Implement delete() method.
    }

    public function get()
    {
        // TODO: Implement get() method.
    }

    public function put(): bool
    {
        // TODO: Implement put() method.
    }
}