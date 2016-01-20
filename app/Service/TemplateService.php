<?php
    namespace App\Service;

    use App\Model\TemplateModel;

    /**
    * Article Service
    */
    class TemplateService
    {
        public function getTemplates()
        {
            $model = new TemplateModel();
            return $model->all();
        }

        public function addTemplates($data)
        {
            $model = new TemplateModel();
            return $model->insert($data);
        }

        public function choose($name)
        {
            $model = new TemplateModel();
            $model->update(array('is_use'=>0));
            return $model->where('name',$name)->update(array('is_use'=>1));
        }
    }