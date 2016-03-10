<?php
namespace Admin\Biz;

use Admin\Biz\BaseBiz;
use Admin\Service\AdminService;

class AdminBiz extends BaseBiz
{
    /**
     * 获取所有的管理员
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function getAdmins()
    {
        $service = new AdminService();
        return $service->getAdmins();
    }

    /**
     * 获取管理员
     * @param  [type] $id [description]
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function getAdmin($id)
    {
        $service = new AdminService();
        $admin = $service->getAdmin($id);
        $admin['password'] = '';

        return $admin;
    }

    /**
     * 添加管理员
     * @param  [type] $data [description]
     * @author marvin
     * @date   2016-02-25
     */
    public function addAdmin($data)
    {
        $service = new AdminService();
        $admins = $service->checkExit(array('name' => $data['name'],'nickname' => $data['nickname']));
        if ($admins) {
            return false;
        }

        $encrypt_password = $this->encrypt_password($data['name'], $data['password']);
        $data['password'] = $encrypt_password;
        return $service->addAdmin($data);
    }

    /**
     * 更新管理员
     * @param  [type] $id   [description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     * @author marvin
     * @date   2016-02-25
     */
    public function updateAdmin($id, $data)
    {
        $service = new AdminService();
        $admins = $service->checkExit(array('name' => $data['name'],'nickname' => $data['nickname']));
        if (count($admins) > 1) {
            return false;
        }
        if ($admins && ($admins['id'] != $data['id'])) {
            return false;
        }
        $result = $service->checkExit($data['nickname']);
        if ($result && ($result['id'] != $data['id'])) {
            return false;
        }

        $encrypt_password = $this->encrypt_password($data['name'], $data['password']);
        $data['password'] = $encrypt_password;

        $result = $service->updateAdmin($id, $data);

        return $result;
    }

    /**
     * 删除管理员
     * @param  integer $id [description]
     * @return [type]      [description]
     * @author marvin
     * @date   2016-02-25
     */
    public function deleteAdmin($id)
    {
        $service = new AdminService();
        return $service->deleteAdmin($id);
    }

    /**
     * 启用/禁用管理员
     * @param  [type] $id     [description]
     * @param  [type] $status [description]
     * @return [type]         [description]
     * @author marvin
     * @date   2016-02-25
     */
    public function changeVisible($id,$status)
    {
        $service = new AdminService();
        return $service->changeVisible($id,$status);
    }

    public function encrypt_password($username = '', $password = '')
    {
        $string = 'asijia*&7hu34';
        $encrypt_password = md5(md5($username.$string.$password));
        return $encrypt_password;
    }
}