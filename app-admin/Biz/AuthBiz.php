<?php
namespace Admin\Biz;

use Admin\Biz\BaseBiz;
use Admin\Service\AdminService;

class AuthBiz extends BaseBiz
{
    /**
     * 登陆验证
     * @param  string $username 用户名
     * @param  string $password 密码
     * @return [type] [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-25
     */
    public function checkAuth($username = '', $password = '')
    {
        $encrypt_password = $this->encrypt_password($username,$password);

        $auth_service = new AdminService();
        $admin = $auth_service->checkUserInfo($username, $encrypt_password);
        if ($admin) {
            return $admin['id'];
        }
        return false;
    }
}