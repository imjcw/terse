<?php
namespace Admin\Service;

use Admin\Model\SettingModel;

class SettingService
{
    /**
     * 获取所有的信息
     * @return [type] [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-28
     */
    public function getSystemInfo()
    {
        $model = new SettingModel();
        return $model->all();
    }

    /**
     * 更新系统信息
     * @param  [type] $params [description]
     * @return [type]             [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-28
     */
    public function updateSystemInfo($params)
    {
        $model = new SettingModel();
        $sql = "update `setting` SET `value` = CASE `name`";
        $where = '';
        if (isset($params['url']) && $params['url']) {
            $sql = $sql." WHEN 'url' THEN '".$params['url']."'";
            $where = $where."'url',";
        }
        if (isset($params['title']) && $params['title']) {
            $sql = $sql." WHEN 'title' THEN '".$params['title']."'";
            $where = $where."'title',";
        }
        if (isset($params['description']) && $params['description']) {
            $sql = $sql." WHEN 'description' THEN '".$params['description']."'";
            $where = $where."'description',";
        }
        if (isset($params['keywords']) && $params['keywords']) {
            $sql = $sql." WHEN 'keywords' THEN '".$params['keywords']."'";
            $where = $where."'keywords',";
        }
        if (isset($params['copyright']) && $params['copyright']) {
            $sql = $sql." WHEN 'copyright' THEN '".$params['copyright']."'";
            $where = $where."'copyright',";
        }
        $where = substr($where, 0, -1);
        $sql = $sql." END WHERE `name` in (".$where.")";
        return $model->query($sql);
    }

    /**
     * 更新模板信息
     * @param  [type] $params [description]
     * @return [type] [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-28
     */
    public function updateTemplateInfo($params)
    {
        $model = new SettingModel();
        if (isset($params['template_name']) && $params['template_name']) {
            $model = $model->where('name', 'template_name');
        }
        return $model->update(array('value' => $params['template_name']));
    }

    /**
     * 获取当前模板信息
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function getCurrentTemplate()
    {
        $model = new SettingModel();
        return $model->where('name','template_name')->one();
    }
}