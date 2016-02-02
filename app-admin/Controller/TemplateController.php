<?php
namespace App\Http\Controller;

use App\Biz\TemplateBiz;
use App\Http\Controller\BaseController;

class TemplateController
{
    /**
     * 模板管理显示
     * @return [type] [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-27
     */
    public function index(){dd($_SERVER);
        $biz = new TemplateBiz();
        $templates = $biz->getTemplates();
        $count = count($templates);
        foreach ($templates as $template) {
            # code...
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