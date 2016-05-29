<?php
namespace Admin\Service;

use Admin\Model\TemplateModel;

/**
* Article Service
*/
class TemplateService
{
    /**
     * 从数据库读取所有的模板信息
     * @return [type] [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-27
     */
    public function getTemplates()
    {
        $model = new TemplateModel();
        return $model->all();
    }

    /**
     * 添加模板
     * @param  [type]     $data [description]
     * @author marvin
     * @date   2016-02-25
     */
    public function addTemplate($data)
    {
        $model = new TemplateModel();
        return $model->insert($data);
    }

    /**
     * 编辑模板
     * @param  [type] $params [description]
     * @return [type]         [description]
     * @author marvin
     * @date   2016-02-25
     */
    public function updateTemplate($params)
    {
        $model = new TemplateModel();
        if (isset($params['id']) && $params['id']) {
            $model = $model->where('id',$params['id']);
        }
        if (isset($params['name']) && $params['name']) {
            $data['nickname'] = $params['name'];
        }
        if (isset($params['description']) && $params['description']) {
            $data['description'] = $params['description'];
        }
        if (isset($params['img']) && $params['img']) {
            $data['img_src'] = $params['img'];
        }
        return $model->update($data);
    }

    /**
     * 选择模板
     * @param  [type] $name [description]
     * @return [type]       [description]
     * @author marvin
     * @date   2016-02-25
     */
    public function choose($id)
    {
        $model = new TemplateModel();
        $model->where('is_use',1)->update(array('is_use'=>0));
        return $model->where('id',$id)->update(array('is_use'=>1));
    }

    public function deleteTemplate($id)
    {
        $model = new TemplateModel();
        $model->where('id', $id);
        return $model->delete();
    }
}