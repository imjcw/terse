<?php
    namespace App\Biz;

    use App\Services\ArticleService;

    /**
    * Article Biz
    */
    class ArticleBiz
    {
        public function getAll()
        {
            $article_service = new ArticleService();
            return $article_service->getAllArticles();
        }
    }