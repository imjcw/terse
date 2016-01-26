<?php
namespace App\Biz;

use App\Biz\BaseBiz;
use App\Service\AdminService;

class AdminBiz extends BaseBiz
{
    public function getAll()
    {
        $admin_service = new AdminService();
        return $admin_service->getAllAdmins();
    }

    public function getOne($id = 0)
    {
        if (empty($id)) {
            return false;
        }

        $admin_service = new AdminService();
        $admin = $admin_service->getOneAdmin($id);
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