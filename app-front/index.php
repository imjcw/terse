<?php
use Lib\Routing\Route;

require 'vendor/autoload.php';
define('ROOT', dirname(__FILE__));
define('APP_NAME', 'Front');
define('TEMPLATE_TYPE', getConfig('template'));
$route = Route::init();
$route->run();