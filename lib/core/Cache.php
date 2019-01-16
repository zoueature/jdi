<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 18-11-24
 * Time: 上午10:11
 */

namespace Core;


use Abs\NoSql;

class Cache
{
	const CACHE_LIST = [
		'Memcache',
		'Redis'
	];

	private static $cache_model;
	private static $cache;

	public function __construct(Redis $cache)
	{
		self::$cache = $cache;
	}

	private static function getModel()
	{
		$cache = config('cache');
		$instance = new $cache();
		if (empty($cache)) {
			self::$cache = new Cache($instance);
		}
		return self::$cache;
	}	

	public static function get($key)
	{
		$value = static::$cache_model->get($key);
		if (empty($value)) {
			return false;
		}
		return $value;
	}

	public static function set($key, $value, $expire)
	{
		$result = static::$cache_model->set($key, $value, $expire);
		if (empty($result)) {
			return false;
		}
		return true;
	}
}















