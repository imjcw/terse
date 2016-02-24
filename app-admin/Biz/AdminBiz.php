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

    public function addAdmin($data = array())
    {
        if (empty($data)) {
            return false;
        }

        $admin_service = new AdminService();
        $result = $admin_service->checkExit($data['name']);
        if ($result) {
            return false;
        }

        $encrypt_password = $this->encrypt_password($data['name'], $data['password']);
        $data['password'] = $encrypt_password;
        return $admin_service->addOneAdmin($data);
    }

    public function editAdmin($id = 0, $data = array())
    {
        if (empty($id)) {
            return false;
        }

        if (empty($data)) {
            return false;
        }

        $admin_service = new AdminService();
        $result = $admin_service->checkExit($data['name']);
        if ($result) {
            return false;
        }

        $encrypt_password = $this->encrypt_password($data['name'], $data['password']);
        $data['password'] = $encrypt_password;

        $result = $admin_service->editOneAdmin($id, $data);

        return $result;
    }

    public function deleteAdmin($id = 0)
    {
        if (empty($id)) {
            return false;
        }

        $admin_service = new AdminService();
        $result = $admin_service->deleteOneAdmin($id);

        return $result;
    }

    public function encrypt_password($username = '', $password = '')
    {
        $string = 'asijia*&7hu34';
        $encrypt_password = md5(md5($username.$string.$password));
        return $encrypt_password;
    }
}