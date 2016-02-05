<?php
namespace Admin\Controller;

use Admin\Biz\AuthBiz;

class AuthController
{
    function __construct(){
        session_start();
    }

    /**
     * 展示登陆页面
     * @return [type]     [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-25
     */
    public function login(){
        if (isset($_SESSION['user_id'])) {
            return redirect('/article/index');
        }
        return view('auth/login');
    }

    /**
     * 登陆操作
     * @return [type]     [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-25
     */
    public function doLogin(){
        $login_info = $_POST;

        if (!isset($login_info['name'])) {
            return json('error', '用户名不能为空！');
        }

        if (!isset($login_info['password'])) {
            return json('error', '密码不能为空！');
        }

        $username = strval($login_info['name']);
        $password = strval($login_info['password']);

        $auth_biz = new AuthBiz();
        $result = $auth_biz->checkAuth($username, $password);
        if ($result) {
            $_SESSION['user_id'] = $result;
            return redirect('/article-setting/index');
        }
        return json('error', '用户名或密码错误！');
    }

    /**
     * 退出登陆操作
     * @return [type]     [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-25
     */
    public function outLogin()
    {
        session_unset();
        session_destroy();
        return redirect('/auth/login');
    }
}