<?php
use Lib\Routing\Route;
use Admin\Exception\ConfigException;

require '../vendor/autoload.php';
define('ROOT', dirname(__FILE__).'/..');
define('APP_NAME', 'Front');
define('TEMPLATE_TYPE', getConfig('template'));
define('TEMPLATE_NAME', ConfigException::getCurrentTemplate());
$route = Route::init();
$route->run();