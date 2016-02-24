<?php
namespace Admin\Biz;

use Admin\Service\ColumnService;
use Admin\Service\ArticleService;
use Admin\Service\ContentService;

class ArticleBiz
{
    /**
     * 获取所有文章
     * @return [type] [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function getArticles()
    {
        $service = new ArticleService();
        return $service->getArticles();
    }

    /**
     * 获取文章
     * @param  [type] $id [description]
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function getArticle($id)
    {
        //获取指定ID的文章
        $column_service = new ArticleService();
        $article = $column_service->getArticle($id);

        //获取指定ID的文章内容
        $content_service = new ContentService();
        $content = $content_service->getContent($article['content_id']);

        //组合数据
        $article['content'] = $content['content'];

        return $article;
    }

    /**
     * 添加文章
     * @param  [type] $data [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function addArticle($data)
    {
        //写入文章内容
        $content_service = new ContentService();
        $content_id = $content_service->addContent(array('content' => $data['content']));
        //判断返回ID是否存在
        if (!$content_id) {
            return false;
        }

        //更新栏目表中的文章数
        $column_service = new ColumnService();
        $column_service->updateArticleNums($data['column'],'add');

        //组合数据
        $data['content'] = $content_id;

        $article_service = new ArticleService();
        return $article_service->addArticle($data);
    }

    /**
     * 更新文章
     * @param  [type]     $id   [description]
     * @param  [type]     $data [description]
     * @return [type]           [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function updateArticle($id, $data)
    {
        $content = $data['content'];
        unset($data['content']);
        //更新文章表
        $column_service = new ArticleService();
        $result = $column_service->updateArticle($id, $data);
        if (!$result) {
            return false;
        }
        //更新文章内容表
        $content_service = new ContentService();
        $result = $content_service->updateContent($data['content_id'], array('content' => $content));

        //更新栏目表中的文章数
        if ($data['column'] != $data['old_column']) {
            $column_service = new ColumnService();
            $column_service->updateArticleNums($data['column'],'add');
            $column_service->updateArticleNums($data['old_column'],'subtract');
        }

        return $result;
    }

    /**
     * 逻辑删除文章
     * @param  integer $id [description]
     * @return [type]      [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function disableArticle($id)
    {
        $service = new ArticleService();
        return $service->disableArticle($id);
    }

    /**
     * 搜索文章
     * @param  [type] $params [description]
     * @return [type]         [description]
     * @author marvin
     * @date   2016-02-24
     */
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