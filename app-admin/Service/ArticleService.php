<?php
namespace Admin\Service;

use Admin\Model\ArticleModel;

class ArticleService
{
    /**
     * 获取所有文章
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function getArticles()
    {
        $model = new ArticleModel();
        return $model
                ->where(array('is_use' => 1))
                ->orderBy('id')
                ->paginate(20)
                ->all();
    }

    /**
     * 获取所有已禁用的文章
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function getAllDisabledArticles()
    {
        $article_model = new ArticleModel();
        return $article_model
                    ->where('is_use', 0)
                    ->paginate(20)
                    ->all();
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
        $model = new ArticleModel();
        if (isset($id) && $id) {
            $model = $model->where('id', $id);
        }
        return $model->one();
    }

    /**
     * 添加文章
     * @param  [type] $params [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function addArticle($params)
    {
        $data = array();
        if (isset($params['title']) && $params['title']) {
            $data['title'] = $params['title'];
        }
        if (isset($params['nickname']) && $params['nickname']) {
            $data['nickname'] = $params['nickname'];
        }
        if (isset($params['author']) && $params['author']) {
            $data['author'] = $params['author'];
        }
        if (isset($params['category']) && $params['category']) {
            $data['category_id'] = $params['category'];
        }
        if (isset($params['description']) && $params['description']) {
            $data['description'] = $params['description'];
        }
        if (isset($params['content']) && $params['content']) {
            $data['content_id'] = $params['content'];
        }
        $data['create_time'] = NULL;

        $model = new ArticleModel();
        $result = $model->insert($data);
        return mysql_insert_id();
    }

    /**
     * 更新文章
     * @param  [type] $id     [description]
     * @param  [type] $params [description]
     * @return [type]         [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function updateArticle($id, $params)
    {
        $model = new ArticleModel();
        $data = array();
        if (isset($id) && $id) {
            $model = $model->where('id', $id);
        }
        if (isset($params['title']) && $params['title']) {
            $data['title'] = $params['title'];
        }
        if (isset($params['nickname']) && $params['nickname']) {
            $data['nickname'] = $params['nickname'];
        }
        if (isset($params['category']) && $params['category']) {
            $data['category_id'] = $params['category'];
        }
        if (isset($params['description']) && $params['description']) {
            $data['description'] = $params['description'];
        }
        if (isset($params['content']) && $params['content']) {
            $data['content_id'] = $params['content'];
        }

        $result = $model->update($data);
        return $result;
    }

    /**
     * 逻辑删除文章
     * @param  integer $id     [description]
     * @param  integer $status [description]
     * @return [type]          [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function changeArticleStatus($id, $status)
    {
        $model = new ArticleModel();
        if (isset($id) && $id) {
            $model = $model->where('id', $id);
        }
        $result = $model->update(array('is_use' => $status));
        return $result;
    }

    /**
     * 物理删除文章
     * @param  [type] $id [description]
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function deleteArticle($id)
    {
        $model = new ArticleModel();
        if (isset($id) && $id) {
            $model = $model->where('id', $id);
        }
        return $model->delete();
    }

    /**
     * 搜索
     * @param  [type] $params [description]
     * @return [type]         [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function search($params)
    {
        $model = new ArticleModel();
        if (isset($params['category']) && $params['category']) {
            $model = $model->where('category_id',$params['category']);
        }
        if (isset($params['author']) && $params['author']) {
            $model = $model->where('author',$params['author']);
        }
        return $model
                ->where(array('is_use' => 1))
                ->orderBy('id')
                ->paginate(20)
                ->all();
    }

    /**
     * 显示/隐藏文章
     * @param  [type]  $id     [description]
     * @param  integer $status [description]
     * @return [type]             [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function changeVisible($id,$status=0)
    {
        $model = new ArticleModel();
        if (isset($id) && $id) {
            $model = $model->where('id',$id);
        }
        return $model->update(array('is_show' => $status));
    }

    /**
     * 更新该栏目下文章的栏目ID,文章删除时调用
     * @param  [type] $id [description]
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function updateCategoryId($id)
    {
        $model = new ArticleModel();
        if (isset($id) && $id) {
            $model = $model->where('category_id',$id);
        }
        return $model->update(array('category_id' => 0,'is_show'=>0));
    }

    /**
     * 删除该栏目下的文章
     * @param  [type] $id [description]
     * @return [type]         [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function deleteArticlesByCategoryId($id)
    {
        $model = new ArticleModel();
        if (isset($id) && $id) {
            $model = $model->where('category_id',$id);
        }
        return $model->delete();
    }
}