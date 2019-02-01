<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 19-1-20
 * Time: 上午10:54
 */

namespace Utils;


use App\Boot\App;
use Core\Container;
use Core\Redis;

class IdGenerate
{
    const STEP = 1;

    private static $redis;

    private static function getRedis()
    {
        if (empty(self::$redis)) {
            $redis = make(Redis::class);
            self::$redis = $redis;
        }
        return self::$redis;
    }

    public static function generateId($object, $not_exists_start = 1)
    {
        $redis = self::getRedis();
        $exists = $redis->get($object);
        if ($exists === false) {
            $id_model = make('Utils\\IdGenerateModel');
            $now = $id_model->where(['object' => $object])->limit(1)->select();
            if (empty($now)) {
                $result = $id_model->insert([
                    'object' => $object,
                    'now' => $not_exists_start,
                    'step' => self::STEP
                ]);
                if (empty($result)) {
                    return false;
                }
                $start = $not_exists_start;
            } else {
                $start = $now[0]['now'];
            }
            $result = $redis->set($object, $start);
            if (empty($result)) {
                return false;
            }
            $id = $redis->incrBy($object, self::STEP);
            if (empty($id)) {
                return false;
            }
            return $id;
        }
        $id = $redis->incrBy($object, self::STEP);
        if (empty($id)) {
            return false;
        }
        return $id;
    }
}