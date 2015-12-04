<?php
require_once 'framework/Support/Helper.php';
require_once 'framework/Database/Connection.php';
require_once 'framework/Routing/Route.php';
define('ROOT', dirname(__FILE__));



$uri = Route::getUri();
if ($uri !== '/') {
    $data = explode('/', $uri);
    $controller = ucfirst($data[1]);
    $action = $data[2];
    if ($controller == 'Test') {
        require_once 'app/Http/Controller/'.$controller.'Controller.php';
        //$controller::$action();
        $test = new Test();
        $test->index();
    }
}
?>