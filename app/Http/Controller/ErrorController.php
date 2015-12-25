<?php
    namespace App\Http\Controller;
    
    /**
    * 错误页
    */
    class ErrorController
    {
        public function index(){
            return view('error');
        }
    }
?>