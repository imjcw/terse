<?php
use Lib\Routing\Route;

require 'vendor/autoload.php';
define('ROOT', dirname(__FILE__));
$route = Route::init();
$route->run();