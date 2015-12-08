<?php
    /**
    *  请求
    */
    class Response
    {
        public function view($name = ''){
            ob_start();
            require_once ROOT.'/resources/views/'.$name.'.html';
            return ob_end_flush();
        }

        public function redirect($url = '', $http_code = 200){
            header("Location: $url", true, $http_code);
            return true;
        }
    }
?>