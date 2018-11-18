<?php
/**
 * Created by PhpStorm.
 * User: eature
 * Date: 18-11-18
 * Time: 上午8:38
 */

error_reporting(E_ALL);
require '../vendor/autoload.php';

define('ROOT', dirname(dirname(__FILE__)));
$config = require '../config/env.php';
$app = new \App\Boot\App($config);
$application_config = [
    'log' => ROOT.'/logs/',
    'application' => 'eature'
];
config($application_config);
try {
    $app->run();
} catch (Exception $e) {
    //TODO 打日志
}