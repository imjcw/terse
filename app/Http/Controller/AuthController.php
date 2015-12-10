<?php
    /**
    * 登陆
    */
    class AuthController
    {
        public function login(){
            view('auth/login');
        }

        public function doLogin(){
            dd($_POST);
        }
    }
?>