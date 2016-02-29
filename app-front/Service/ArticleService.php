<?php
namespace Front\Service;

use Front\Model\ArticleModel;

class ArticleService
{
    public function getArticle($name)
    {
        $model = new ArticleModel();
        return $model->where('is_use',1)->where('title',$name)->one();
    }

    public function getAllDeletedArticles()
    {
        $article_model = new ArticleModel();
        return $article_model
                    ->where('is_use', 0)
                    ->all();
    }

    public function getOneArticle($id = 0)
    {
        if (empty($id)) {
            return false;
        }

        $article_model = new ArticleModel();
        return $article_model
                    ->where('id', $id)
                    ->one();
    }

    public function addOneArticle($data = array())
    {
        if (empty($data)) {
            return false;
        }
        $data['create_time'] = NULL;

        $article_model = new ArticleModel();
        return $article_model->insert($data);
    }

    public function editOneArticle($id = 0, $data = array())
    {
        if (empty($id)) {
            return false;
        }

        if (empty($data)) {
            return false;
        }

        $article_model = new ArticleModel();
        $result = $article_model
                    ->where('id', $id)
                    ->update($data);
        if (!$result) {
            return false;
        }

        $content_id = $article_model
                            ->select('content_id')
                            ->where('id', $id)
                            ->one();
        return $content_id['content_id'];
    }

    public function updateOneArticleStatus($id = 0, $status = 0)
    {
        if (empty($id)) {
            return false;
        }

        $article_model = new ArticleModel();
        $result = $article_model
                    ->where('id', $id)
                    ->update(array('is_use' => $status));
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
}