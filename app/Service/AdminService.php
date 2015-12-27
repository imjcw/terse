<?php
    namespace App\Service;

    use App\Model\AdminModel;

    /**
    * Article Service
    */
    class AdminService
    {
        public function getAllAdmins()
        {
            $admin_model = new AdminModel();
            return $admin_model
                        ->all();
        }

        public function addOneAdmin($data = array())
        {
            $admin_model = new AdminModel();
            return $admin_model->insert($data);
        }

        public function checkUserInfo($username = '', $password = '')
        {
            $admin_model = new AdminModel();
            return $admin_model
                        ->where(array('name' => $username, 'password' => $password))
                        ->one();
        }
    }