<?php
    namespace App\Services;

    use App\Models\ContentModel;

    /**
    * Article Service
    */
    class ContentService
    {
        public function getContentById($id = 0)
        {
            if (empty($id)) {
                return false;
            }

            $content_model = new ContentModel();
            return $content_model
                        ->where('id', $id)
                        ->one();
        }

        public function insertContent($data = array())
        {
            if (empty($data)) {
                return false;
            }
            $data['create_time'] = NULL;

            $content_model = new ContentModel();
            $result = $content_model->insert($data);
            if (!$result) {
                return false;
            }
            return mysql_insert_id();
        }

        public function updateContentById($id = 0, $data = array())
        {
            if (empty($id)) {
                return false;
            }

            if (empty($data)) {
                return false;
            }

            $content_model = new ContentModel();
            return $content_model
                        ->where('id', $id)
                        ->update($data);
        }
    }