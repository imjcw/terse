<?php
namespace Front\Biz;

use Front\Service\ArticleService;
use Admin\Service\ContentService;

class ArticleBiz
{
    public function get($article_name, $column_id)
    {
        $column_service = new ArticleService();
        $article = $column_service->getArticle($article_name);

        if ($article['column_id'] !== $column_id) {
            return false;
        }

        $content_service = new ContentService();
        $content = $content_service->getContent($article['content_id']);

        $article['content'] = htmlspecialchars_decode($content['content']);

        return $article;
    }
}