<?php
namespace Front\Service;

use Front\Model\ArticleModel;

class ArticleService
{
    public function getArticle($name)
    {
        $model = new ArticleModel();
        return $model->where('is_use',1)->where('nickname',$name)->one();
    }

    public function getArticles($column_id)
    {
        $model = new ArticleModel();
        return $model->where(array('is_use' => 1,'is_show' => 1))->where('column_id',$column_id)->paginate(20)->all();
    }
}