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
$app = new \Core\Boot\App();
try {
    $app->run();
} catch (Exception $e) {
    \Core\Logger::error($e->getMessage());
}