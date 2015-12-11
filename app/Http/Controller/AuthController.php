<?php
    /**
    * 登陆
    */
    class AuthController
    {
        public function login(){
            return view('auth/login');
        }

        public function doLogin(){
            var_dump($_POST);
        }
    }
?>