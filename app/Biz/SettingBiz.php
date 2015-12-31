<?php
    namespace App\Biz;

    use App\Service\SettingService;
    /**
    * Setting Biz
    */
    class SettingBiz
    {
        public function getInfo()
        {
            $setting_service = new SettingService();
            return $setting_service->getOne();
        }

        public function updateSystemInfo($data = array())
        {
            if (empty($data)) {
                return false;
            }

            $setting_service = new SettingService();
            return $setting_service->updateSystemInfo($data);
        }
    }