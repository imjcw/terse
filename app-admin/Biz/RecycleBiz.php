<?php
namespace Admin\Biz;

use Admin\Service\ArticleService;
use Admin\Service\ContentService;

class RecycleBiz
{
    /**
     * 获取所有已禁用的文章
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function getArticles()
    {
        $article_service = new ArticleService();
        return $article_service->getAllDisabledArticles();
    }

    /**
     * 物理删除文章
     * @param  array $params [description]
     * @return [type]      [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function deleteArticle($params)
    {
        $article_service = new ArticleService();
        $result = $article_service->deleteArticle($params['id']);

        if (!$result) {
            return false;
        }

        $content_service = new ContentService();
        $result = $content_service->deleteContent($params['content']);

        return $result;
    }

    /**
     * 重用文章
     * @param  [type]     $id [description]
     * @return [type]         [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function reuseArticle($id)
    {
        $service = new ArticleService();
        return $service->changeArticleStatus($id, 1);
    }
}