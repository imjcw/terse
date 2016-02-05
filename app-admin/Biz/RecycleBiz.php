<?php
    namespace Admin\Biz;

    use Admin\Service\ArticleService;
    use Admin\Service\ContentService;
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
            $article = $article_service->deleteOneArticle($id);

            if (!$article) {
                return false;
            }

            $content_service = new ContentService();
            $result = $content_service->deleteOneContent($article['content_id']);

            return $result;
        }

        public function reuseArticle($id = 0)
        {
            if (empty($id)) {
                return false;
            }

            $article_service = new ArticleService();
            return $article_service->updateOneArticleStatus($id, 1);
        }
    }