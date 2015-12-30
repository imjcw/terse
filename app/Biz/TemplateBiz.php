<?php
    namespace App\Biz;

    use App\Service\TemplateService;
    /**
    * Admin Biz
    */
    class TemplateBiz
    {
        public function getAll()
        {
            dd(scandir(ROOT.'/resources/show'));
            //$admin_service = new TemplateService();
            //return $admin_service->getAllAdmins();
        }
    }