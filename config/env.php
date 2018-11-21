<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 18-11-18
 * Time: 上午8:44
 */

return [
    "domain" => 'www.eature.com',
    "db" => [
        'master' => [
            'type' => 'MySQL',
            'host' => '127.0.0.1',
            'port' => 3306,
            'user' => '',
            'pswd' => '',
            'name' => '',
            'charset' => 'utf-8'
        ]
    ],
    'cache' => [
        'redis' => [
            'host' => '127.0.0.1',
            'port' => 6379,
            'auth' => ''
        ],
        "memcache" => [
            'host' => '127.0.0.1',
            'port' => 11211
        ]
    ]
];






