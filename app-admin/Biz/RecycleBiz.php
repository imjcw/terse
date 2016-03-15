<?php
namespace Admin\Biz;

use Admin\Service\ArticleService;
use Admin\Service\ContentService;
use Admin\Service\TagService;

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

        $tag_service = new TagService();
        $relations = $tag_service->getRelationsByArticleId($params['id']);
        $tag_ids = array_column($relations, 'tag_id');
        $tags = $tag_service->getTagsByIds($tag_ids);
        $tag_service->deleteRelations($tag_ids,$params['id']);
        foreach ($tags as $key => $tag) {
            if ($tag['nums'] == 1) {
                $delete[] = $tag['id'];
            } else {
                $update[$tag['name']] = $tag['nums'];
            }
        }
        if (isset($delete)) {
            $tag_service->deleteTags($tag_ids);
        }
        if (isset($update)) {
            $tag_service->updateNums($update,'delete');
        }

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