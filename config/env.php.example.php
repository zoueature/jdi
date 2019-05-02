<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 18-11-18
 * Time: 上午8:44
 */

return [
    "domain" => '',
    'application' => 'jdi',
    "db" => [
        'master' => [
            'host' => '127.0.0.1',
            'port' => 3306,
            'user' => '',
            'pswd' => '',
            'name' => '',
            'prefix' => 't_',
            'charset' => 'utf-8',
            'driver' => 'pdo_mysql' //pdo_mysql, pdo_sqlite, pdo_pgsql, pdo_oci, oci8, ibm_db2, pdo_sqlsrv, mysqli, drizzle_pdo_mysql, sqlanywhere, sqlsrv
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
    ],
    'redis' => [
        'master' => [
            'host' => '127.0.0.1',
            'port' => 6379,
            'auth' => ''
        ]
    ],
    'memcache' => [
        [
            'host' => '127.0.0.1',
            'port' => 11211
        ]
    ],
    'log' => [
        'path'=> '',
        'switch' => [
            'access' => true,
            'response' => false,
            'sql' => true
        ]
    ],
    'driver' => [
        'queue' => '', //备选redis， beanstalk，
        'cache' => '', //备选redis， memcache
    ]
];
