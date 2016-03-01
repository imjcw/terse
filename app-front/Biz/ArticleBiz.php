<?php
namespace Front\Biz;

use Front\Service\ArticleService;
use Admin\Service\ContentService;

class ArticleBiz
{
    public function get($article_name, $column_id)
    {
        $article_service = new ArticleService();
        $article = $article_service->getArticle($article_name);

        if ($article['column_id'] !== $column_id) {
            return false;
        }

        $content_service = new ContentService();
        $content = $content_service->getContent($article['content_id']);

        $article['content'] = htmlspecialchars_decode($content['content']);

        return $article;
    }

    public function getArticles($column_id)
    {
        $service = new ArticleService();
        return $service->getArticles($column_id);
    }
}