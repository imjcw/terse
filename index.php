<?php
require_once 'framework/Support/Helper.php';
require_once 'framework/Database/Connection.php';
require_once 'framework/Routing/Route.php';
require_once 'framework/Http/Response.php';
define('ROOT', dirname(__FILE__));

$route = new Route();
$uri = $route->getBaseUri();
if ($uri !== '/') {
    $data = explode('/', $uri);
    $controller = ucfirst($data[0]);
    $controller .= 'Controller';
    $action = isset($data[1]) ? $data[1] : 'index';
    if ($controller != 'Favicon.icoController') {
        require_once 'app/Http/Controller/'.$controller.'.php';
        //call_user_func(array($controller.'Controller' , 'index'));
        //$controller::$action();
        $test = new $controller;
        $test->$action();
    }
}
?>