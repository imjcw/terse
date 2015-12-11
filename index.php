<?php
require_once 'framework/Support/Helper.php';
require_once 'framework/View/Page.php';
require_once 'framework/Database/Connection.php';
require_once 'framework/Routing/Route.php';
require_once 'framework/Http/Response.php';
require_once 'app/Http/Routes.php';
require_once 'framework/Support/Functions.php';
define('ROOT', dirname(__FILE__));

$route = new Route();
$uri = $route->getBaseUri();
if ($uri !== '/') {
    $data = explode('/', $uri);
    foreach ($data as $value) {
        if (isset($controller)) {
            require_once 'app/Http/Controller/'.$controller.'.php';
            $contol = new $controller;
            $methods = get_class_methods($contol);
            if (in_array($value, $methods)) {
                $view = $contol->$value();
                if (is_object($view)) {
                    $view->compile();
                }
            }
            break;
        }
        if (in_array($value, $routers)) {
            $controller = ucfirst($value);
            $controller .= 'Controller';
        }
    }
}
?>