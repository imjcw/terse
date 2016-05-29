<?php
namespace Admin\Controller;

use Admin\Biz\AdminBiz;
use Admin\Controller\BaseController;
use Lib\Filter\Filter;

class AdminSettingController extends BaseController
{
    /**
     * 管理员首页
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-24
     */
    public function index(){
        //获取所有管理员数据
        $biz = new AdminBiz();
        $admins = $biz->getAdmins();
        //组合数据
        foreach ($admins as $admin) {
            $id = $admin['id'];
            $data[$id]['name'] = $admin['name'];
            $data[$id]['nickname'] = $admin['nickname'];
            $data[$id]['is_use'] = $admin['is_use'];
            $data[$id]['create_time'] = date('Y-m-d', strtotime($admin['create_time']));
        }
        $msg = getMsg();
        return view('admin/index')->with(array(
            'i' => 1,
            'admins' => $data,
            'msg' => $msg
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
        //过滤变量
        $filter = new Filter();
        $data = $filter->make($params,array(
            'nickname' => 'string',
            'name' => 'required | string',
            'password' => 'required | string',
            'description' => 'string',
            ));
        if ($filter->error()) {
            dd($filter->error());
        }
        //新增管理员
        $biz = new AdminBiz();
        $result = $biz->addAdmin($data);
        $_SESSION['msg'] = $result ? '添加管理员成功！' : '添加管理员失败！';
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
        //过滤操作
        $filter = new Filter();
        $data = $filter->make($params,array(
            'id' => 'required | int'
            ));
        if ($filter->error()) {
            dd($filter->error());
        }
        //获取管理员
        $biz = new AdminBiz();
        $admin = $biz->getAdmin($data['id']);
        return view('admin/edit')->with($admin);
    }

    /**
     * 管理员编辑操作
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-25
     */
    public function doEdit(){
        $filter = new Filter();
        $get = $_GET;
        $post = $_POST;
        $params = array_merge($get,$post);
        //过滤操作
        $data = $filter->make($params,array(
            'id' => 'required | int | min:1',
            'nickname' => 'required | string',
            'name' => 'required | string',
            'password' => 'required | string',
            'description' => 'string',
            ));
        if ($filter->error()) {
            dd($filter->error());
        }
        //更新管理员
        $biz = new AdminBiz();
        $result = $biz->updateAdmin($data['id'], $data);
        $_SESSION['msg'] = $result ? '编辑管理员成功！' : '编辑管理员失败！';
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
        //过滤操作
        $filter = new Filter();
        $data = $filter->make($params,array(
            'id' => 'required | int'
            ));
        if ($filter->error()) {
            dd($filter->error());
        }
        if ($data['id'] == $_SESSION['user_id']) {
            return json('不能删除自己！',403);
        }
        $biz = new AdminBiz();
        $result = $biz->deleteAdmin($data['id']);
        $_SESSION['msg'] = $result ? '删除管理员成功！' : '删除管理员失败！';
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
        $filter = new Filter();
        $data = $filter->make($params,array(
            'id' => 'required | int',
            'status' => 'required | int',
            ));
        if ($filter->error()) {
            dd($filter->error());
        }
        if ($data['id'] == $_SESSION['user_id']) {
            return json('不能禁用自己！',403);
        }
        $biz = new AdminBiz();
        $result = $biz->changeVisible($data['id'],$data['status']);
        return $result ? json('success！') : json('fault！', 403);
    }
}