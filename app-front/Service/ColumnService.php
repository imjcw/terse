<?php
namespace Front\Service;

use Front\Model\ColumnModel;

class ColumnService
{
    /**
     * 获取所有栏目
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function getVisibleColumns()
    {
        $model = new ColumnModel();
        return $model->where('is_show',1)->all();
    }

    /**
     * 根据name获取column
     * @param  [type] $name [description]
     * @return [type]       [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function getColumnByNickName($nickname)
    {
        $model = new ColumnModel();
        if (isset($nickname) && $nickname) {
            $model = $model->where('nickname', $nickname);
        }
        return $model->one();
    }
}