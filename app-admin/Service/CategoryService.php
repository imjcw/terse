<?php
namespace Admin\Service;

use Admin\Model\CategoryModel;

class CategoryService
{
    /**
     * 获取所有栏目
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function getCategorys()
    {
        $model = new CategoryModel();
        return $model->all();
    }

    /**
     * 通过ID获取栏目
     * @param  [type] $id [description]
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function getCategory($id)
    {
        $model = new CategoryModel();
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
    public function addCategory($params)
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

        $model = new CategoryModel();
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
    public function updateCategory($params)
    {
        $model = new CategoryModel();
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
    public function deleteCategory($id)
    {
        $model = new CategoryModel();
        if (isset($id) && $id) {
            $model = $model->where('id', $id);
        }
        return $model->delete();
    }

    /**
     * 根据ID获取category
     * @param  [type] $id [description]
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-14
     */
    public function getCategoryByIds($ids)
    {
        $model = new CategoryModel();
        if (isset($ids) && is_array($ids) && !empty($ids)) {
            $model = $model->whereIn('id', $ids);
        }
        return $model->all();
    }

    /**
     * 根据name获取category
     * @param  [type] $name [description]
     * @return [type]       [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function getCategoryByNickName($nickname)
    {
        $model = new CategoryModel();
        if (isset($nickname) && $nickname) {
            $model = $model->where('nickname', $nickname);
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
        $model = new CategoryModel();
        if (isset($id) && $id) {
            $model = $model->where('id', $id);
            $category = $model->select('article_nums')->one();
        }
        if ($action == 'add') {
            $category['article_nums']++;
        }
        if ($action == 'subtract') {
            $category['article_nums']--;
        }
        $model->update(array('article_nums' => $category['article_nums']));
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
        $model = new CategoryModel();
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
            $model = new CategoryModel();
            $result = $model->where($field, $name)->all();
        }
        return $result;
    }
}