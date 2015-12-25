<?php
    namespace Routing;
    /**
    * 路由获取
    */
    class Route
    {
        protected static $init;

        public static function init(){
            if (!self::$init) {
                self::$init = new Route();
            }
            return self::$init;
        }

        protected function getUri(){
            $uri = substr($_SERVER['REQUEST_URI'], 1);
            return $uri ? $uri : '/';
        }

        protected function getBaseUri(){
            $uri = $this->getUri();
            $pos = strpos($uri, '?');
            $baseUri = $pos ? substr($uri, 0, $pos) : $uri;
            return $baseUri;
        }

        public function run(){
            $uri = $this->getBaseUri();
            $data = explode('/', $uri);
            $routes = getRoutes();
            foreach ($data as $value) {
                if (isset($controller)) {
                    $this->newController($controller, $value);
                    break;
                }
                if (in_array($value, $routes)) {
                    $controller = ucfirst($value);
                    $controller .= 'Controller';
                }
            }
            if (!isset($controller) && $uri !== '/') {
                redirect('/error/index');
            }
        }

        protected function newController($controller = '', $method = ''){
            require_once 'app/Http/Controller/'.$controller.'.php';
            $contol = new $controller;
            $methods = get_class_methods($contol);
            if (in_array($method, $methods)) {
                $view = $contol->$method();
                if (is_object($view)) {
                    $view->compile();
                }
            }else{
                redirect('/error/index');
            }
        }
    }
?>