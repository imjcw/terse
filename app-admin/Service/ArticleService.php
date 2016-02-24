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

    public function getAllDeletedArticles()
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
        if (isset($params['column']) && $params['column']) {
            $data['column_id'] = $params['column'];
        }
        if (isset($params['description']) && $params['description']) {
            $data['description'] = $params['description'];
        }
        if (isset($params['content']) && $params['content']) {
            $data['content_id'] = $params['content'];
        }
        $data['create_time'] = NULL;

        $model = new ArticleModel();
        return $model->insert($data);
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
        if (isset($params['column']) && $params['column']) {
            $data['column_id'] = $params['column'];
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
    public function disableArticle($id, $status = 0)
    {
        $model = new ArticleModel();
        if (isset($id) && $id) {
            $model = $model->where('id', $id);
        }
        $result = $model->update(array('is_use' => $status));
        return $result;
    }

    public function deleteOneArticle($id = 0)
    {
        if (empty($id)) {
            return false;
        }

        $article_model = new ArticleModel();
        $content_id = $article_model
                            ->select('content_id')
                            ->where('id', $id)
                            ->one();

        $result = $article_model
                    ->where('id', $id)
                    ->delete();

        return $content_id;
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
        if (isset($params['column']) && $params['column']) {
            $model = $model->where('column_id',$params['column']);
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
    public function updateColumnId($id)
    {
        $model = new ArticleModel();
        if (isset($id) && $id) {
            $model = $model->where('column_id',$id);
        }
        return $model->update(array('column_id' => 0,'is_show'=>0));
    }

    /**
     * 删除该栏目下的文章
     * @param  [type] $id [description]
     * @return [type]         [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function deleteArticlesByColumnId($id)
    {
        $model = new ArticleModel();
        if (isset($id) && $id) {
            $model = $model->where('column_id',$id);
        }
        return $model->delete();
    }
}