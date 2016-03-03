<?php
namespace Front\Service;

use Front\Model\ArticleModel;

class ArticleService
{
    public function getArticle($name)
    {
        $model = new ArticleModel();
        $model = $model->where('is_show',1);
        $model = $model->where('is_use',1);
        return $model->where('nickname',$name)->one();
    }

    public function getArticles($column_id, $num = 20)
    {
        $model = new ArticleModel();
        $model = $model->where('is_show',1);
        $model = $model->where('is_use',1);
        if (isset($column_id) && $column_id) {
            $model = $model->where('column_id',$column_id);
        }
        return $model->paginate($num)->all();
    }

    public function getClicks($num)
    {
        $model = new ArticleModel();
        $model = $model->where('is_show',1);
        $model = $model->where('is_use',1);
        return $model->paginate($num)->all();
    }

    /**
     * 获取推荐文章
     * @param  [type] $num [description]
     * @return [type]      [description]
     * @author marvin
     * @date   2016-03-03
     */
    public function getRecommend($num)
    {
        $model = new ArticleModel();
        $model = $model->where('is_show',1);
        $model = $model->where('is_use',1);
        return $model->orderBy('id')->paginate($num)->all();
    }

    /**
     * 获取热门文章
     * @param  [type] $num [description]
     * @return [type]      [description]
     * @author marvin
     * @date   2016-03-03
     */
    public function getHot($num)
    {
        $model = new ArticleModel();
        $model = $model->where('is_show',1);
        $model = $model->where('is_use',1);
        return $model->orderBy('id')->paginate($num)->all();
    }

    /**
     * 获取最新文章
     * @param  [type] $num [description]
     * @return [type]      [description]
     * @author marvin
     * @date   2016-03-03
     */
    public function getNew($num)
    {
        $model = new ArticleModel();
        $model = $model->where('is_show',1);
        $model = $model->where('is_use',1);
        return $model->orderBy('id')->paginate($num)->all();
    }
}