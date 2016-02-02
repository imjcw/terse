<?php
    namespace App\Biz;

    use App\Service\SettingService;
    /**
    * Setting Biz
    */
    class SettingBiz
    {
        public function getAll()
        {
            $setting_service = new SettingService();
            return $setting_service->getAll();
        }

        public function updateSystemInfo($data = array())
        {
            $setting_service = new SettingService();
            return $setting_service->updateSystemInfo($data);
        }
    }