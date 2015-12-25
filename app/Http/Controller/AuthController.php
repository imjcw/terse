<?php
    namespace App\Http\Controller;

    use App\Biz\AuthBiz;
    /**
    * 登陆
    */
    class AuthController
    {
        function __construct(){
            session_start();
        }

        public function login(){
            if ($_SESSION['user_id']) {
                return redirect('/article/index');
            }
            return view('auth/login');
        }

        public function doLogin(){
            $login_info = $_POST;

            if (!isset($login_info['name'])) {
                return json('error', '用户名不能为空！');
            }

            if (!isset($login_info['password'])) {
                return json('error', '密码不能为空！');
            }

            $username = $login_info['name'];
            $password = $login_info['password'];

            $auth_biz = new AuthBiz();
            $result = $auth_biz->checkAuth($username, $password);
            if ($result) {
                $_SESSION['user_id'] = $result;
                return redirect('/article/index');
            }
            return json('error', '用户名或密码错误！');
        }

        public function outLogin()
        {
            session_unset();
            session_destroy();
            return redirect('/auth/login');
        }
    }