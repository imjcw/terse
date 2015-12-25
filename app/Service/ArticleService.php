<?php
    namespace App\Service;

    use App\Model\ArticleModel;

    /**
    * Article Service
    */
    class ArticleService
    {
        public function getAllArticles()
        {
            $article_model = new ArticleModel();
            return $article_model->all();
        }

        public function getOneArticle($id = 0)
        {
            if (empty($id)) {
                return false;
            }

            $article_model = new ArticleModel();
            return $article_model
                        ->where('id', $id)
                        ->one();
        }

        public function addOneArticle($data = array())
        {
            if (empty($data)) {
                return false;
            }
            $data['create_time'] = NULL;

            $article_model = new ArticleModel();
            return $article_model->insert($data);
        }

        public function editOneArticle($id = 0, $data = array())
        {
            if (empty($id)) {
                return false;
            }

            if (empty($data)) {
                return false;
            }

            $article_model = new ArticleModel();
            $result = $article_model
                        ->where('id', $id)
                        ->update($data);
            if (!$result) {
                return false;
            }

            $content_id = $article_model
                                ->select('content_id')
                                ->where('id', $id)
                                ->one();
            return $content_id['content_id'];
        }
    }