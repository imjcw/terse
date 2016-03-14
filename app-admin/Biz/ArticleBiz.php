<?php
namespace Admin\Biz;

use Admin\Service\ColumnService;
use Admin\Service\ArticleService;
use Admin\Service\ContentService;
use Admin\Service\TagService;

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
        //获取标签
        $tags = explode(',', $data['tags']);
        //检测是否存在，存在则更新nums，不存在则新增
        $tag_service = new TagService();
        $exist_tags = $tag_service->getExistTags($tags);
        foreach ($exist_tags as $key => $value) {
            $name = $value['name'];
            $tagg[$name]['id'] = $value['id'];
            $tagg[$name]['nums'] = $value['nums'];
        }
        foreach ($tags as $tag) {
            if (isset($tagg[$tag])) {
                $update_nums[$tag] = $tagg[$tag]['nums'];
            } else {
                $add_tag[] = $tag;
            }
        }
        if (isset($update_nums)) {
            $tag_service->updateNums($update_nums);
        }
        if (isset($add_tag)) {
            $tag_service->addTag($add_tag);
        }
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
        $article_id = $article_service->addArticle($data);
        //添加关系
        $tag_ids = $tag_service->getExistTags($tags,'id');
        $tag_service->addRelation($article_id,$data['category'],$tag_ids);
        return true;
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
     * @param  array $id [description]
     * @return [type]      [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function disableArticle($data)
    {
        $column_service = new ColumnService();
        $column_service->updateArticleNums($data['column'],'subtract');
        $service = new ArticleService();
        return $service->changeArticleStatus($data['id'],0);
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