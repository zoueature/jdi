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
$config = require_once '../config/env.php';
$app = new \Core\Boot\App($config);
try {
    $app->run();
} catch (Exception $e) {
    \Core\Logger::error($e->getMessage());
}