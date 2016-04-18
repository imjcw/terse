<?php
namespace Admin\Biz;

use Admin\Service\TemplateService;
use Admin\Service\SettingService;

class TemplateBiz
{
    /**
     * 从数据库读取所有的模板信息
     * @return [type] [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-27
     */
    public function getTemplates()
    {
        $service = new TemplateService();
        return $service->getTemplates();
    }

    /**
     * 编辑模板
     * @param  [type] $data [description]
     * @return [type]       [description]
     * @author marvin
     * @date   2016-02-25
     */
    public function updateTemplate($data)
    {
        $service = new TemplateService();
        return $service->updateTemplate($data);
    }

    /**
     * 选择模板
     * @param  [type] $data [description]
     * @return [type]       [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-28
     */
    public function choose($data)
    {
        $template_service = new TemplateService();
        $result = $template_service->choose($data['id']);
        if ($result) {
            $handle = opendir(ROOT . '/storage/views/app-front');
            while (($name = readdir($handle)) != false) {
                if ($name == '.' || $name == '..' || $name == '.gitignore') {
                    continue;
                }
                unlink(ROOT . '/storage/views/app-front/' . $name);
            }
            $setting_service = new SettingService();
            $result = $setting_service->updateTemplateInfo(array('template_name' => $data['name']));
        }
        return $result;
    }
}