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
            $templates = $template_biz->getAll();dd($templates);
            $count = count($templates);

            return view('admin/index')->with(array(
                'count' => $count,
                'pageData' => $pageData
            ));
        }
    }