<?php
    /**
    *  请求
    */
    class Response extends Page
    {
        protected static $init;

        public static function init(){
            if (!self::$init) {
                self::$init = new Response();
            }
            return self::$init;
        }

        public function view($name = ''){
            $page = Page::init();
            return $page->exportToBrowser($name);
        }

        public function redirect($url = '', $http_code = 200){
            header("Location: $url", true, $http_code);
            return true;
        }
    }
?>