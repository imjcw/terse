<?php
namespace Admin\Service;

use Admin\Model\AdminModel;

class AdminService
{
    /**
     * 获取所有管理员
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function getAdmins()
    {
        $model = new AdminModel();
        return $model->all();
    }

    /**
     * 获取管理员
     * @param  [type] $id [description]
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-25
     */
    public function getAdmin($id)
    {
        $model = new AdminModel();
        if (isset($id) && $id) {
            $model = $model->where('id',$id);
        }
        return $model->where('is_use',1)->one();
    }

    /**
     * 添加管理员
     * @param  [type] $params [description]
     * @author marvin
     * @date   2016-02-25
     */
    public function addAdmin($params)
    {
        $model = new AdminModel();
        if (isset($params['nickname']) && $params['nickname']) {
            $data['nickname'] = $params['nickname'];
        }
        if (isset($params['name']) && $params['name']) {
            $data['name'] = $params['name'];
        }
        if (isset($params['password']) && $params['password']) {
            $data['password'] = $params['password'];
        }
        if (isset($params['description']) && $params['description']) {
            $data['description'] = $params['description'];
        }
        $data['create_time'] = NULL;
        return $model->insert($data);
    }

    /**
     * 更新管理员信息
     * @param  [type] $id     [description]
     * @param  [type] $params [description]
     * @return [type]         [description]
     * @author marvin
     * @date   2016-02-25
     */
    public function updateAdmin($id, $params)
    {
        $model = new AdminModel();
        if (isset($id) && $id) {
            $model = $model->where('id',$id);
        }
        if (isset($params['nickname']) && $params['nickname']) {
            $data['nickname'] = $params['nickname'];
        }
        if (isset($params['name']) && $params['name']) {
            $data['name'] = $params['name'];
        }
        if (isset($params['password']) && $params['password']) {
            $data['password'] = $params['password'];
        }
        if (isset($params['description']) && $params['description']) {
            $data['description'] = $params['description'];
        }

        return $model->update($data);
    }

    /**
     * 删除管理员
     * @param  integer $id [description]
     * @return [type]      [description]
     * @author marvin
     * @date   2016-02-25
     */
    public function deleteAdmin($id)
    {
        $model = new AdminModel();
        if (isset($id) && $id) {
            $model = $model->where('id',$id);
        }

        return $model->delete();
    }

    /**
     * 检查是否存在
     * @param  array $params [description]
     * @return [type]       [description]
     * @author marvin
     * @date   2016-02-25
     */
    public function checkExit($params)
    {
        $model = new AdminModel();
        if (isset($params['name']) && $params['name']) {
            $model = $model->where('name',$params['name']);
        }
        if (isset($params['nickname']) && $params['nickname']) {
            $model = $model->orWhere('nickname',$params['nickname']);
        }

        return $model->all();
    }

    /**
     * 验证用户名密码
     * @param  string $username [description]
     * @param  string $password [description]
     * @return [type]           [description]
     * @author marvin
     * @date   2016-02-25
     */
    public function checkUserInfo($username, $password)
    {
        $model = new AdminModel();
        if (isset($username) && $username) {
            $model = $model->where('name',$username);
        }
        if (isset($password) && $password) {
            $model = $model->where('password',$password);
        }
        return $model->where('is_use',1)->one();
    }

    /**
     * 启用/禁用管理员
     * @param  [type]  $id     [description]
     * @param  integer $status [description]
     * @return [type]             [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function changeVisible($id,$status=0)
    {
        $model = new AdminModel();
        if (isset($id) && $id) {
            $model = $model->where('id',$id);
        }
        return $model->update(array('is_use' => $status));
    }
}