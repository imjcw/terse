<?php
namespace Admin\Biz;

use Admin\Service\CategoryService;
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
        $article_service = new ArticleService();
        $article = $article_service->getArticle($id);

        //获取指定ID的文章内容
        $content_service = new ContentService();
        $content = $content_service->getContent($article['content_id']);

        //组合数据
        $article['content'] = $content['content'];
        $tag_service = new TagService();
        $relations = $tag_service->getRelationsByArticleId($id);
        $tag_ids = array_column($relations, 'tag_id');
        $tags = $tag_service->getTagsByIds($tag_ids);
        $article['tags'] = array_column($tags,'name');
        $article['tags_input'] = implode(',',$article['tags']);
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
        //写入文章内容
        $content_service = new ContentService();
        $content_id = $content_service->addContent(array('content' => $data['content']));
        //判断返回ID是否存在
        if (!$content_id) {
            return false;
        }

        //更新栏目表中的文章数
        $category_service = new CategoryService();
        $category_service->updateArticleNums($data['category'],'add');

        //组合数据
        $data['content'] = $content_id;

        $article_service = new ArticleService();
        $article_id = $article_service->addArticle($data);
        //添加关系
        $tag_service = new TagService();
        //检测是否存在，存在则更新nums，不存在则新增
        $this->tag($tags);
        $tag_ids = $tag_service->getExistTags($tags,'id');
        $tag_service->addRelation($article_id,$data['category'],$tag_ids);
        return true;
    }

    /**
     * 更新文章
     * @param  [type] $id   [description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function updateArticle($id, $data)
    {
        $content = $data['content'];
        unset($data['content']);
        //更新文章表
        $category_service = new ArticleService();
        $result = $category_service->updateArticle($id, $data);
        if (!$result) {
            return false;
        }
        //更新文章内容表
        $content_service = new ContentService();
        $result = $content_service->updateContent($data['content_id'], array('content' => $content));

        //更新栏目表中的文章数
        if ($data['category'] != $data['old_category']) {
            $category_service = new CategoryService();
            $category_service->updateArticleNums($data['category'],'add');
            $category_service->updateArticleNums($data['old_category'],'subtract');
        }

        $tags = explode(',', $data['tags']);
        $old_tags = explode(',', $data['old_tags']);
        foreach ($old_tags as $tag) {
            if (!in_array($tag,$tags)) {
                $delete[] = $tag;
            }
        }
        foreach ($tags as $tag) {
            if (!in_array($tag, $old_tags)) {
                $new[] = $tag;
            }
        }
        $tag_service = new TagService();
        if (isset($delete)) {
            $delete_tags = $tag_service->getExistTags($delete);
            foreach ($delete_tags as $key => $tag) {
                $ids[] = $tag['id'];
                if ($tag['nums'] == 1) {
                    $delete_ids[] = $tag['id'];
                } else {
                    $update_names[$tag['name']] = $tag['nums'];
                }
            }
            $tag_service->deleteRelations($ids,$id);
            if (isset($delete_ids)) {
                $tag_service->deleteTags($delete_ids);
            }
            if (isset($update_names)) {
                $tag_service->updateNums($update_names,'delete');
            }
        }
        if (isset($new)) {
            $this->tag($new);
            $tag_ids = $tag_service->getExistTags($new,'id');
            $tag_service->addRelation($id,$data['category'],$tag_ids);
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
        $category_service = new CategoryService();
        $category_service->updateArticleNums($data['category'],'subtract');
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
    public function updateCategoryId($id)
    {
        $service = new ArticleService();
        return $service->updateCategoryId($id);
    }

    public function deleteArticlesByCategoryId($id)
    {
        $service = new ArticleService();
        return $service->deleteArticlesByCategoryId($id);
    }

    public function tag($params)
    {
        $service = new TagService();
        //获取已存在的tag
        $exist_tags = $service->getExistTags($params);
        foreach ($exist_tags as $key => $value) {
            $name = $value['name'];
            $tags[$name]['id'] = $value['id'];
            $tags[$name]['nums'] = $value['nums'];
        }
        //查看哪些需要更新，哪些需要新增
        foreach ($params as $tag) {
            if (isset($tags[$tag])) {
                $update[$tag] = $tags[$tag]['nums'];
            } else {
                $add[] = $tag;
            }
        }
        //判断更新/增加
        if (isset($update)) {
            $service->updateNums($update,'add');
        }
        if (isset($add)) {
            $service->addTag($add);
        }
    }
}