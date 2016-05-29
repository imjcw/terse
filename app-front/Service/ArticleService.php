<?php
namespace Front\Service;

use Front\Model\ArticleModel;

class ArticleService
{
    public function getPre($id)
    {
        $model = new ArticleModel();
        $sql = "SELECT * FROM `article` where `id` < " . $id . " ORDER BY `id` DESC";
        $result = $model->query($sql);
        return $model->toArray($result, 0);
    }
    public function getNext($id)
    {
        $model = new ArticleModel();
        $sql = "SELECT * FROM `article` where `id` > " . $id;
        $result = $model->query($sql);
        return $model->toArray($result, 0);
    }
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
        return $model->orderBy('views')->paginate($num)->all();
    }

    /**
     * 获取最新文章
     * @param  [type] $num [description]
     * @return [type]      [description]
     * @author marvin
     * @date   2016-03-03
     */
    public function getNew($num, $category_id = null)
    {
        $model = new ArticleModel();
        if ($category_id) {
            $model = $model->where('category_id', $category_id);
        }
        $model = $model->where('is_show',1);
        $model = $model->where('is_use',1);
        return $model->orderBy('id')->paginate($num)->all();
    }

    public function hasView($id)
    {
        $model = new ArticleModel();
        $article = $model->select('views')->where('id',$id)->one();
        $model->where('id',$id)->update(array('views'=> ++$article['views']));
    }
}