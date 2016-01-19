<?php
    namespace App\Service;

    use App\Model\FileModel;

    /**
    * Article Service
    */
    class FileService
    {
        public function getTemplates()
        {
            $model = new FileModel();
            return $model->all();
        }
    }