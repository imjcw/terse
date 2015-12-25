<?php
    namespace App\Biz;

    use App\Services\AuthService;

    /**
    * Auth Biz
    */
    class AuthBiz
    {
        public function checkAuth($username = '', $password = '')
        {
            $encrypt_password = $this->encrypt_password();

            $auth_service = new AuthService();
            $admin = $auth_service->checkUserInfo($username, $encrypt_password);
            if ($admin) {
                return $admin['id'];
            }
            return false;
        }

        public function encrypt_password($password = '', $username = '')
        {
            $string = 'asijia*&7hu34';
            $encrypt_password = md5(md5($username.$string.$password));
            return $encrypt_password;
        }
    }