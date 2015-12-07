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
    }
?>