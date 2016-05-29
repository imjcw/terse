<?php
use Lib\Routing\Route;
use Admin\Exception\ConfigException;

require '../vendor/autoload.php';
define('ROOT', dirname(__FILE__).'/..');
define('APP_NAME', 'Admin');
define('TEMPLATE_TYPE', getConfig('template'));
define('TEMPLATE_NAME', ConfigException::getCurrentTemplate());
session_start();
date_default_timezone_set('Asia/Shanghai');
if (!isset($_SESSION['webname'])) {
	ConfigException::setWebname();
}
$route = Route::init();
$route->run();