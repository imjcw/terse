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

        return view('admin/index')->with(array(
            'admins' => $admins
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
        $id = intval($_GET['id']);
        if (empty($id)) {
            return json('error', '参数错误！');
        }

        $biz = new AdminBiz();
        $pageData = $biz->getAdmin($id);

        return view('admin/edit')->with($pageData);
    }

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
        $result = $biz->editAdmin($id, $data);
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
}