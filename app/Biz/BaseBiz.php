<?php
namespace App\Biz;

class BaseBiz
{
    /**
     * 密码加密
     * @param  string $username 用户名
     * @param  string $password 密码
     * @return [type] [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-25
     */
    public function encrypt_password($username = '', $password = '')
    {
        $string = 'asijia*&7hu34';
        $encrypt_password = md5(md5($username.$string.$password));
        return $encrypt_password;
    }
}