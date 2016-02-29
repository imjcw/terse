<?php
namespace Admin\Controller;

use Admin\Biz\TemplateBiz;
use Admin\Controller\BaseController;

class FrontController
{
    /**
     * 模板管理显示
     * @return [type] [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-27
     */
    public function view(){
        return view($this->template.'/article','front');
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