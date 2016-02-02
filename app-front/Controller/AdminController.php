<?php
    namespace App\Http\Controller;

    use App\Biz\AdminBiz;
    use App\Http\Controller\BaseController;
    /**
    * 
    */
    class AdminController extends BaseController
    {
        public function index(){
            $admin_biz = new AdminBiz();
            $pageData = $admin_biz->getAll();
            $count = count($pageData);

            return view('admin/index')->with(array(
                'count' => $count,
                'pageData' => $pageData
            ));
        }

        public function add(){
            return view('admin/add');
        }

        public function doAdd(){
            $data = $_POST;
            if (empty($data)) {
                return json('error', '请输入相关参数！');
            }

            $admin_biz = new AdminBiz();
            $result = $admin_biz->addAdmin($data);
            $page = $result ? 'index' : '/error';

            return redirect($page);
        }

        public function edit(){
            $id = intval($_GET['id']);
            if (empty($id)) {
                return json('error', '参数错误！');
            }

            $admin_biz = new AdminBiz();
            $pageData = $admin_biz->getOne($id);

            return view('admin/edit')->with($pageData);
        }

        public function doEdit(){
            $id = intval($_GET['id']);
            if (empty($id)) {
                return json('error', '参数错误！');
            }

            $data = $_POST;
            if (empty($data)) {
                return json('error', '请输入相关参数！');
            }

            $admin_biz = new AdminBiz();
            $result = $admin_biz->editAdmin($id, $data);
            $page = $result ? 'index' : '/error';

            return redirect($page);
        }

        public function doDelete(){
            $id = intval($_GET['id']);
            if (empty($id)) {
                return json('error', '参数错误！');
            }

            $admin_biz = new AdminBiz();
            $result = $admin_biz->deleteAdmin($id);
            $page = $result ? 'index' : '/error';

            return redirect($page);
        }
    }