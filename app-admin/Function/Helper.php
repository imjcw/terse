<?php
use Admin\Service\SettingService;

if (!function_exists('getSystem')) {
    function getSystem($variable){
        $service = new SettingService();
        $system = $service->getSystemInfo();
        foreach ($system as $info) {
            if ($info['name'] == $variable) {
                return $info['value'];
            }
        }
    }
}