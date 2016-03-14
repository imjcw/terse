<?php
namespace Admin\Service;

use Admin\Model\TagModel;
use Admin\Model\TagRelationShipsModel;

class TagService
{
    public function getTags()
    {
        $model = new TagModel();
        return $model->all();
    }

    public function getExistTags($tags, $filter = '')
    {
        $model = new TagModel();
        if ($filter) {
            $model = $model->select($filter);
        }
        return $model->whereIn('name',$tags)->all();
    }

    public function addTag($params)
    {
        $data = array();
        $model = new TagModel();
        foreach ($params as $key => $param) {
            $data[$key]['name'] = $param;
        }
        return $model->insert($data);
    }

    public function updateNums($params)
    {
        $model = new TagModel();
        foreach ($params as $key => $value) {
            $model->where('name',$key)->update(array('nums' => ++$value));
        }
        return true;
    }

    public function addRelation($article_id, $category_id, $tag_ids)
    {
        $data = array();
        $model = new TagRelationShipsModel();
        foreach ($tag_ids as $key => $tag_id) {
            $data[$key]['article_id'] = $article_id;
            $data[$key]['category_id'] = $category_id;
            $data[$key]['tag_id'] = $tag_id['id'];
        }
        return $model->insert($data);
    }
}