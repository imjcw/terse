<?php
namespace Admin\Controller;

use Admin\Biz\TemplateBiz;
use Admin\Controller\BaseController;

class TemplateSettingController extends BaseController
{
    /**
     * 模板管理显示
     * @return [type] [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-27
     */
    public function index(){
        $biz = new TemplateBiz();
        $templates = $biz->getTemplates();
        foreach ($templates as $template) {
            $id = $template['id'];
            $data[$id]['name'] = $template['name'];
            $data[$id]['nickname'] = $template['nickname'];
            $data[$id]['description'] = $template['description'];
            $data[$id]['is_use'] = $template['is_use'];
            $data[$id]['img_src'] = '/public/tpl_img/'.$template['img_src'];
        }

        return view('template/index')->with(array(
            'templates' => $data
        ));
    }

    /**
     * 编辑模板
     * @return [type] [description]
     * @author marvin
     * @date   2016-02-25
     */
    public function doEdit()
    {
        $params = $_POST;
        if (isset($params['id']) && $params['id']) {
            $data['id'] = filter_var($params['id'], FILTER_VALIDATE_INT);
        }
        if (isset($params['name']) && $params['name']) {
            $data['name'] = filter_var($params['name'], FILTER_SANITIZE_STRING);
        }
        if (isset($params['img']) && $params['img']) {
            $img = filter_var($params['img'], FILTER_SANITIZE_STRING);
            $data['img'] = end(explode('/', $img));
        }
        if (isset($params['description']) && $params['description']) {
            $data['description'] = filter_var($params['description'], FILTER_SANITIZE_STRING);
        }
        $biz = new TemplateBiz();
        $result = $biz->updateTemplate($data);
    }

    /**
     * 模板选择
     * @return [type] [description]
     */
    public function choose()
    {
        $params = $_GET;
        if (isset($params['id']) && $params['id']) {
            $data['id'] = filter_var($params['id'], FILTER_VALIDATE_INT);
        }
        if (isset($params['name']) && $params['name']) {
            $data['name'] = filter_var($params['name'], FILTER_SANITIZE_STRING);
        }
        $biz = new TemplateBiz();
        $result = $biz->choose($data);
        return redirect('template/index');
    }
}