<?php
    namespace App\Biz;

    use App\Service\AdminService;
    /**
    * Admin Biz
    */
    class AdminBiz
    {
        public function getAll()
        {
            $admin_service = new AdminService();
            return $admin_service->getAllAdmins();
        }

        public function addAdmin($data = array())
        {
            if (empty($data)) {
                return false;
            }

            $encrypt_password = $this->encrypt_password($data['name'], $data['password']);
            $data['password'] = $encrypt_password;

            $admin_service = new AdminService();
            return $admin_service->addOneAdmin($data);
        }

        public function encrypt_password($username = '', $password = '')
        {
            $string = 'asijia*&7hu34';
            $encrypt_password = md5(md5($username.$string.$password));
            return $encrypt_password;
        }
    }