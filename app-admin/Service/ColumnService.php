<?php
namespace Admin\Service;

use Admin\Model\ColumnModel;

class ColumnService
{
    /**
     * 获取所有栏目
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function getColumns()
    {
        $model = new ColumnModel();
        return $model->all();
    }

    /**
     * 通过ID获取栏目
     * @param  [type] $id [description]
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function getColumn($id)
    {
        $model = new ColumnModel();
        if (isset($id) && $id) {
            $model = $model->where('id', $id);
        }
        return $model->one();
    }

    /**
     * 添加栏目
     * @param  [type] $params [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function addColumn($params)
    {
        if (isset($params['name']) && $params['name']) {
            $data['name'] = strval($params['name']);
        }
        if (isset($params['nickname']) && $params['nickname']) {
            $data['nickname'] = strval($params['nickname']);
        }
        if (isset($params['description']) && $params['description']) {
            $data['description'] = strval($params['description']);
        }

        $model = new ColumnModel();
        $result = $model->insert($data);
        if ($result) {
            $result = mysql_insert_id();
        }
        return $result;
    }

    /**
     * 更新栏目
     * @param  [type] $params [description]
     * @return [type]         [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function updateColumn($params)
    {
        $model = new ColumnModel();
        if (isset($params) && $params['id']) {
            $model = $model->where('id', $params['id']);
        }
        if (isset($params['name']) && $params['name']) {
            $data['name'] = strval($params['name']);
        }
        if (isset($params['nickname']) && $params['nickname']) {
            $data['nickname'] = strval($params['nickname']);
        }
        if (isset($params['description']) && $params['description']) {
            $data['description'] = strval($params['description']);
        }
        return $model->update($data);
    }

    /**
     * 删除栏目
     * @param  [type] $id [description]
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function deleteColumn($id)
    {
        $model = new ColumnModel();
        if (isset($id) && $id) {
            $model = $model->where('id', $id);
        }
        return $model->delete();
    }

    /**
     * 根据ID获取column
     * @param  [type] $id [description]
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-14
     */
    public function getColumnByIds($ids)
    {
        $model = new ColumnModel();
        if (isset($ids) && is_array($ids) && !empty($ids)) {
            $model = $model->whereIn('id', $ids);
        }
        return $model->all();
    }

    /**
     * 根据name获取column
     * @param  [type] $name [description]
     * @return [type]       [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function getColumnByName($name)
    {
        $model = new ColumnModel();
        if (isset($name) && $name) {
            $model = $model->where('name', $name);
        }
        return $model->one();
    }

    /**
     * 更新指定栏目下的文章数目
     * @param  [type] $id     [description]
     * @param  [type] $action [description]
     * @return [type]         [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function updateArticleNums($id, $action)
    {
        $model = new ColumnModel();
        if (isset($id) && $id) {
            $model = $model->where('id', $id);
            $column = $model->select('article_nums')->one();
        }
        if ($action == 'add') {
            $column['article_nums']++;
        }
        if ($action == 'subtract') {
            $column['article_nums']--;
        }
        $model->update(array('article_nums' => $column['article_nums']));
    }

    /**
     * 栏目启用/禁用开关
     * @param  integer $id     [description]
     * @param  integer $status [description]
     * @return [type]          [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function changeVisible($id, $status=0)
    {
        $model = new ColumnModel();
        if (isset($id) && $id) {
            $model = $model->where('id',$id);
        }
        return $model->update(array('is_show' => $status));
    }

    /**
     * 检测字段是否存在
     * @param  [type] $field [description]
     * @param  [type] $name  [description]
     * @return [type]        [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function checkExit($field, $name)
    {
        if (isset($field, $name) && $field && $name) {
            $model = new ColumnModel();
            $result = $model->where($field, $name)->all();
        }
        return $result;
    }
}