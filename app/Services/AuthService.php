<?php
    namespace App\Services;

    use App\Models\AuthModel;

    /**
    * Article Service
    */
    class AuthService
    {
        public function checkUserInfo($username = '', $password = '')
        {
            $auth_model = new AuthModel();
            return $auth_model
                        ->where(array('name' => $username, 'password' => $password))
                        ->one();
        }
    }