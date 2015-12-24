<?php
    namespace App\Services;

    use App\Models\ArticleModel;

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
    }