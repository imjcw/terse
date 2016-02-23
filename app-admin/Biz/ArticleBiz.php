<?php
namespace Admin\Biz;

use Admin\Service\ColumnService;
use Admin\Service\ArticleService;
use Admin\Service\ContentService;

class ArticleBiz
{
    public function getAll()
    {
        $article_service = new ArticleService();
        return $article_service->getAllArticles();
    }

    public function getOne($id = 0)
    {
        if (empty($id)) {
            return false;
        }

        $column_service = new ArticleService();
        $article = $column_service->getOneArticle($id);

        if (!$article) {
            return false;
        }

        $content_service = new ContentService();
        $content = $content_service->getContentById($article['content_id']);

        $article['content'] = $content['content'];

        return $article;
    }

    public function addArticle($data = array())
    {
        if (empty($data)) {
            return false;
        }

        $content_service = new ContentService();
        $content_id = $content_service->insertContent(array('content' => $data['content']));

        if (!$content_id) {
            return false;
        }
        unset($data['content']);
        $data['content_id'] = $content_id;

        $article_service = new ArticleService();
        return $article_service->addOneArticle($data);
    }

    public function editArticle($id, $data)
    {
        $content = $data['content'];
        unset($data['content']);
        $column_service = new ArticleService();
        $content_id = $column_service->editOneArticle($id, $data);

        $content_service = new ContentService();
        $result = $content_service->updateContentById($content_id, array('content' => $content));

        return $result;
    }

    public function deleteArticle($id = 0)
    {
        if (empty($id)) {
            return false;
        }

        $article_service = new ArticleService();
        return $article_service->updateOneArticleStatus($id);
    }

    public function getArticlesByColumnIds($column_ids)
    {
        $service = new ArticleService();
        return $service->getArticlesByColumnIds($column_ids);
    }
    public function search($params)
    {
        $service = new ArticleService();
        return $service->search($params);
    }

    public function changeVisible($id,$status)
    {
        $service = new ArticleService();
        return $service->changeVisible($id,$status);
    }

    /**
     * 删除栏目后，更改栏目下所有文章的栏目ID
     * @param  [type]     $id [description]
     * @return [type]         [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function updateColumnId($id)
    {
        $service = new ArticleService();
        return $service->updateColumnId($id);
    }

    public function deleteArticlesByColumnId($id)
    {
        $service = new ArticleService();
        return $service->deleteArticlesByColumnId($id);
    }
}