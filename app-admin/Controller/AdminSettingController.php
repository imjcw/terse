<?php
namespace Admin\Controller;

use Admin\Biz\AdminBiz;
use Admin\Controller\BaseController;

class AdminSettingController extends BaseController
{
    /**
     * 管理员首页
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function index(){
        $biz = new AdminBiz();
        $admins = $biz->getAdmins();
        foreach ($admins as $admin) {
            $id = $admin['id'];
            $data[$id]['nickname'] = $admin['nickname'];
            $data[$id]['name'] = $admin['name'];
            $data[$id]['is_use'] = $admin['is_use'];
            $data[$id]['create_time'] = date('Y-m-d', strtotime($admin['create_time']));
        }

        return view('admin/index')->with(array(
            'admins' => $data
        ));
    }

    /**
     * 新增管理员页面
     * @author marvin
     * @date   2016-02-24
     */
    public function add(){
        return view('admin/add');
    }

    /**
     * 新增管理员操作
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function doAdd(){
        $params = $_POST;
        if (isset($params['nickname']) && $params['nickname']) {
            $data['nickname'] = filter_var($params['nickname'], FILTER_SANITIZE_STRING);
        }
        if (isset($params['name']) && $params['name']) {
            $data['name'] = filter_var($params['name'], FILTER_SANITIZE_STRING);
        }
        if (isset($params['password']) && $params['password']) {
            $data['password'] = filter_var($params['password'], FILTER_SANITIZE_STRING);
        }
        if (isset($params['description']) && $params['description']) {
            $data['description'] = filter_var($params['description'], FILTER_SANITIZE_STRING);
        }

        $biz = new AdminBiz();
        $result = $biz->addAdmin($data);

        return redirect('admin/index');
    }

    /**
     * 编辑管理员页面
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function edit(){
        $params = $_GET;
        if (isset($params['id']) && $params['id']) {
            $id = filter_var($params['id'], FILTER_VALIDATE_INT);
        }

        $biz = new AdminBiz();
        $admin = $biz->getAdmin($id);

        return view('admin/edit')->with($admin);
    }

    /**
     * 管理员编辑操作
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-25
     */
    public function doEdit(){
        $params = $_GET;
        if (isset($params['id']) && $params['id']) {
            $id = filter_var($params['id'], FILTER_VALIDATE_INT);
        }

        $params = $_POST;
        if (isset($params['nickname']) && $params['nickname']) {
            $data['nickname'] = filter_var($params['nickname'], FILTER_SANITIZE_STRING);
        }
        if (isset($params['name']) && $params['name']) {
            $data['name'] = filter_var($params['name'], FILTER_SANITIZE_STRING);
        }
        if (isset($params['password']) && $params['password']) {
            $data['password'] = filter_var($params['password'], FILTER_SANITIZE_STRING);
        }
        if (isset($params['description']) && $params['description']) {
            $data['description'] = filter_var($params['description'], FILTER_SANITIZE_STRING);
        }

        $biz = new AdminBiz();
        $result = $biz->updateAdmin($id, $data);
        return redirect('admin/index');
    }

    /**
     * 删除管理员
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function doDelete(){
        $params = $_GET;
        if (isset($params['id']) && $params['id']) {
            $id = filter_var($params['id'], FILTER_VALIDATE_INT);
        }

        $biz = new AdminBiz();
        $result = $biz->deleteAdmin($id);
        return redirect('admin/index');
    }

    /**
     * 启用/禁用管理员
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-18
     */
    public function changeVisible()
    {
        $params = $_POST;
        if (isset($params['id']) && $params['id']) {
            $id = intval($_POST['id']);
        }
        if (isset($params['status']) && $params['status']) {
            $status = intval($_POST['status']);
        }
        $biz = new AdminBiz();
        $result = $biz->changeVisible($id,$status);
        return $result ? json('success！') : json('fault！', 403);
    }
}