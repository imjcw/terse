<?php
namespace Admin\Service;

use Admin\Model\AdminModel;

class AdminService
{
    /**
     * 获取所有管理员
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function getAdmins()
    {
        $model = new AdminModel();
        return $model->where('is_use', 1)->all();
    }

    public function getAdmin($id = 0)
    {
        $model = new AdminModel();
        return $model
                    ->where(array('id' => $id, 'is_use' => 1))
                    ->one();
    }

    public function addOneAdmin($data = array())
    {
        $admin_model = new AdminModel();
        return $admin_model->insert($data);
    }

    public function editOneAdmin($id = 0, $data = array())
    {
        if (empty($id)) {
            return false;
        }

        if (empty($data)) {
            return false;
        }

        $admin_model = new AdminModel();
        $result = $admin_model
                    ->where('id', $id)
                    ->update($data);

        return $result;
    }

    public function deleteOneAdmin($id = 0)
    {
        if (empty($id)) {
            return false;
        }

        $admin_model = new AdminModel();
        $result = $admin_model
                    ->where('id', $id)
                    ->update(array('is_use' => 0));

        return $result;
    }

    public function checkExit($name = '')
    {
        $admin_model = new AdminModel();
        $result = $admin_model
                    ->where('name', $name)
                    ->one();

        return $result;
    }

    public function checkUserInfo($username = '', $password = '')
    {
        $admin_model = new AdminModel();
        return $admin_model
                    ->where(array('name' => $username, 'password' => $password))
                    ->one();
    }
}