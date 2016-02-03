<?php
    namespace App\Http\Controller;
    
    /**
    * 错误页
    */
    class ErrorSettingController
    {
        public function index(){
            return view('error');
        }
    }