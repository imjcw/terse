<?php
namespace Admin\Biz;

use Admin\Service\SettingService;

class SettingBiz
{
    /**
     * 获取系统信息
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function getSystemInfo()
    {
        $service = new SettingService();
        return $service->getSystemInfo();
    }

    /**
     * 更新系统信息
     * @param  array  $data [description]
     * @return [type]       [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function updateSystemInfo($data)
    {
        $service = new SettingService();
        return $service->updateSystemInfo($data);
    }
}