<?php
namespace Admin\Biz;

use Admin\Service\ColumnService;

class ColumnBiz
{
    /**
     * 获取所有栏目
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function getColumns()
    {
        $service = new ColumnService();
        return $service->getColumns();
    }

    /**
     * 通过ID获取栏目
     * @param  [type]  $id [description]
     * @return [type]      [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function getColumn($id)
    {
        $service = new ColumnService();
        return $service->getColumn($id);
    }

    /**
     * 添加栏目
     * @param  [type] $data [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function addColumn($data)
    {
        $data['create_time'] = NULL;

        $service = new ColumnService();
        //检测栏目名是否重复
        $result = $service->checkExit('name',$data['name']);
        if ($result) {
            return false;
        }
        //检测栏目昵称是否重复
        if (isset($data['nickname']) && $data['nickname']) {
            $result = $service->checkExit('nickname',$data['nickname']);
            if ($result) {
                return false;
            }
        }
        //新建栏目
        return $service->addColumn($data);
    }

    public function updateColumn($data)
    {
        $service = new ColumnService();
        //检测栏目名是否重复
        $result = $service->checkExit('name',$data['name']);
        if ($result) {
            if ($result[0]['id'] != $data['id']) {
                return false;
            }
        }
        //检测栏目昵称是否重复
        if (isset($data['nickname']) && $data['nickname']) {
            $result = $service->checkExit('nickname',$data['nickname']);
            if ($result) {
                if ($result[0]['id'] != $data['id']) {
                    return false;
                }
            }
        }
        //更新栏目
        return $service->updateColumn($data);
    }

    /**
     * 删除
     * @param  integer    $id [description]
     * @return [type]         [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function deleteColumn($id)
    {
        $service = new ColumnService();
        return $service->deleteColumn($id);
    }

    /**
     * 根据ID获取column
     * @param  [type] $id [description]
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-15
     */
    public function getColumnByIds($id)
    {
        $service = new ColumnService();
        return $service->getColumnByIds($id);
    }

    public function getColumnByName($name)
    {
        $service = new ColumnService();
        return $service->getColumnByName($name);
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
        $service = new ColumnService();
        return $service->changeVisible($id, $status);
    }
}