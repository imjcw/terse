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

    public function getTagsByIds($ids)
    {
        $model = new TagModel();
        if (is_array($ids) && !empty($ids)) {
            $model = $model->whereIn('id',$ids);
        }
        return $model->all();
    }

    public function getRelations()
    {
        $model = new TagRelationShipsModel();
        return $model->all();
    }

    public function getRelationsByArticleId($id)
    {
        $model = new TagRelationShipsModel();
        if ($id) {
            $model = $model->where('article_id',$id);
        }
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

    public function deleteTags($params)
    {
        $data = array();
        $model = new TagModel();
        if (is_array($params) && !empty($params)) {
            $model = $model->whereIn('id',$params);
        }
        return $model->delete();
    }

    public function updateNums($params,$action)
    {
        $model = new TagModel();
        foreach ($params as $key => $value) {
            if ($action == 'add') {
                $model->where('name',$key)->update(array('nums' => ++$value));
            }
            if ($action == 'delete') {
                $model->where('name',$key)->update(array('nums' => --$value));
            }
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

    public function deleteRelations($params,$id)
    {
        $model = new TagRelationShipsModel();
        return $model->where('article_id',$id)->whereIn('tag_id',$params)->delete();
    }
}