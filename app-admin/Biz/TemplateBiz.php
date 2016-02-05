<?php
namespace Admin\Biz;

use Admin\Service\TemplateService;
use Admin\Service\SettingService;

class TemplateBiz
{
    public function getAll()
    {
        dd(scandir(ROOT.'/resources/show'));
        //$admin_service = new TemplateService();
        //return $admin_service->getAllAdmins();
    }

    /**
     * 从数据库读取所有的模板信息
     * @return [type] [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-27
     */
    public function getTemplates()
    {
        $file_service = new TemplateService();
        $result = $file_service->getTemplates();
        return $result;
    }

    /**
     * 选择模板
     * @param  [type]     $name [description]
     * @return [type]           [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-28
     */
    public function choose($name)
    {
        $file_service = new TemplateService();
        $result = $file_service->choose($name);
        if ($result) {
            $setting_service = new SettingService();
            $result = $setting_service->updateTemplateInfo(array('template_name' => $name));
        }
        return $result;
    }
}