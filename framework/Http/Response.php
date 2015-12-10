<?php
    /**
    *  请求
    */
    class Response extends Page
    {
        public function view($name = ''){
            $page = Page::init();
            $page->exportToBrowser($name);
        }

        public function redirect($url = '', $http_code = 200){
            header("Location: $url", true, $http_code);
            return true;
        }
    }
?>