<?php
    namespace App\Http\Controller;

    use App\Biz\TemplateBiz;
    use App\Http\Controller\BaseController;
    /**
    * 
    */
    class TemplateController extends BaseController
    {
        public function index(){
            $template_biz = new TemplateBiz();
            $templates = $template_biz->getTemplates();
            $count = count($templates);

            return view('template/index')->with(array(
                'count' => $count,
                'templates' => $templates
            ));
        }

        public function choose()
        {
            $name = $_GET['name'];
            $template_biz = new TemplateBiz();
            $result = $template_biz->choose($name);
            $page = $result ? 'index' : '/error';
            return redirect($page);
        }
    }