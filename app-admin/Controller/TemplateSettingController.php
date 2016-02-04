<?php
namespace Admin\Http\Controller;

use Admin\Biz\TemplateBiz;
use Admin\Http\Controller\BaseController;

class TemplateSettingController
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
        $count = count($templates);
        foreach ($templates as $key => $template) {
            $templates[$key]['img_src'] = 'http://'.$_SERVER['HTTP_HOST'].'/app-front'.$template['dir_src'].$template['img_src'];
        }

        return view('template/index')->with(array(
            'count' => $count,
            'templates' => $templates
        ));
    }

    /**
     * 模板选择
     * @return [type] [description]
     */
    public function choose()
    {
        $name = $_GET['name'];
        $template_biz = new TemplateBiz();
        $result = $template_biz->choose($name);
        $page = $result ? 'index' : '/error';
        return redirect($page);
    }
}