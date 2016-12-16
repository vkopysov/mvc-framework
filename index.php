<?php
/**
 * Created by PhpStorm.
 * User: phpstudent
 * Date: 14.12.16
 * Time: 14:49
 */

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('ROOT', dirname(__FILE__));


require_once ROOT . '/app/Components/loader.php';

$router = new \Components\Router();
$router->run();

