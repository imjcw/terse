<?php
namespace Admin\Service;

use Admin\Model\ColumnModel;

class ColumnService
{
    public function getAllColumns()
    {
        $column_model = new ColumnModel();
        return $column_model->all();
    }

    public function getOneColumn($id = 0)
    {
        $column_model = new ColumnModel();
        return $column_model
                    ->where(array('id' => $id, 'is_use' => 1))
                    ->one();
    }

    public function insertNewColumn($data = array())
    {
        $column_model = new ColumnModel();
        return $column_model->insert($data);
    }

    public function editOneColumn($data = array(), $id = 0)
    {
        $column_model = new ColumnModel();
        return $column_model
                    ->where('id', $id)
                    ->update($data);
    }

    public function updateOneColumnStatus($id = 0, $status = 0)
    {
        $column_model = new ColumnModel();
        return $column_model
                    ->where(array('id' => $id, 'is_use' => 1))
                    ->update(array('is_use' => $status));
    }

    public function deleteOneColumn($id = 0)
    {
        $column_model = new ColumnModel();
        return $column_model
                    ->where('id', $id)
                    ->delete();
    }

    public function checkExit($name = '')
    {
        $column_model = new ColumnModel();
        $result = $column_model
                    ->where('name', $name)
                    ->all();

        return $result;
    }

    /**
     * 根据ID获取column
     * @param  [type] $id [description]
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-14
     */
    public function getColumnByIds($id)
    {
        $model = new ColumnModel();
        if (isset($id) && is_array($id)) {
            $model = $model->whereIn('id', $id);
        }
        return $model->all();
    }

    public function getColumnByName($name)
    {
        $model = new ColumnModel();
        if (isset($name) && $name) {
            $model = $model->where('name', $name);
        }
        return $model->one();
    }
}