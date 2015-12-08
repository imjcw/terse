<?php
    /**
    * 错误页
    */
    class ErrorController
    {
        public function index(){
            Response::view('error');
        }
    }
?>