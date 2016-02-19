<?php
namespace Front\Biz;

use Admin\Service\ArticleService;
use Admin\Service\ContentService;

class ArticleBiz
{
    public function get($article_id, $column_id)
    {
        $column_service = new ArticleService();
        $article = $column_service->getOneArticle($article_id);

        if ($article['column_id'] !== $column_id) {
            return false;
        }

        $content_service = new ContentService();
        $content = $content_service->getContentById($article['content_id']);

        $article['content'] = $content['content'];

        return $article;
    }
}