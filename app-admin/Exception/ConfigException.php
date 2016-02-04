<?php
namespace App\Exception;

use App\Service\SettingService;
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
}