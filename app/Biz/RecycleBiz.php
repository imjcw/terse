<?php
    namespace App\Biz;

    use App\Service\ArticleService;
    /**
    * Admin Biz
    */
    class RecycleBiz
    {
        public function getAll()
        {
            $article_service = new ArticleService();
            return $article_service->getAllDeletedArticles();
        }

        public function deleteArticle($id = 0)
        {
            if (empty($id)) {
                return false;
            }

            $article_service = new ArticleService();
            return $article_service->deleteOneArticle($id);
        }
    }