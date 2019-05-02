<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 18-11-24
 * Time: 上午10:11
 */

namespace Core\Common;


use Core\Abs\NoSql;
use Core\Abs\Facade;

class Cache extends Facade
{
    private static $driver;
    private static $driverMap = [
        'redis' => Redis::class,
        'memcache' => Memcache::class
    ];

	public function __construct()
	{
		$driver = config('driver');
		$cacheDriver = $driver['cache'] ?: 'redis';
		self::$driver = $cacheDriver;
	}

	public static function getFactClassName()
    {
        return self::$driverMap[self::$driver];
    }
}















