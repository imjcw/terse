<?php
    namespace App\Service;

    use App\Model\SettingModel;

    /**
    * Setting Service
    */
    class SettingService
    {
        public function getOne()
        {
            $setting_model = new SettingModel();
            return $setting_model
                        ->where('id', 1)
                        ->one();
        }

        public function updateSystemInfo($data)
        {
            $setting_model = new SettingModel();
            return $setting_model
                        ->where('id', 1)
                        ->update($data);
        }
    }