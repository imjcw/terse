<?php
    /**
    * 登陆
    */
    class AuthController
    {
        public function login(){
            Response::view('auth/login');
        }

        public function doLogin(){
            Helper::dd($_POST);
        }
    }
?>