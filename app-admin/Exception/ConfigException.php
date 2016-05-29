<?php
namespace Admin\Exception;

use Admin\Service\SettingService;
class ConfigException
{
    /**
     * 获取当前启用的模板
     * @return [String] [模板名]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-02-04
     */
    public function getCurrentTemplate()
    {
        $service = new SettingService();
        $template = $service->getCurrentTemplate();
        return $template['value'];
    }

    public function setWebname()
    {
        $service = new SettingService();
        $template = $service->getWebname();
        $_SESSION['webname'] = $template['value'];
    }
}