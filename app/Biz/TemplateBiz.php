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

        public function getTemplates()
        {
            $file_service = new TemplateService();
            $result = $file_service->getTemplates();
            return $result;
        }

        public function choose($name)
        {
            $file_service = new TemplateService();
            $result = $file_service->choose($name);
            return $result;
        }
    }