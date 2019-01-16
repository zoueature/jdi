<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 18-11-18
 * Time: 上午8:44
 */

return [
    "domain" => '',
    "db" => [
        'master' => [
            'host' => '',
            'port' => 3306,
            'user' => '',
            'pswd' => '',
            'name' => '',
            'charset' => 'utf-8'
        ]
    ],
    'cache' => [
        'redis' => [
            'host' => '',
            'port' => 6379,
            'auth' => ''
        ],
        "memcache" => [
            'host' => '',
            'port' => 11211
        ]
    ],
    'log' => [
        'access' => true,
        'response' => false
    ]
];
