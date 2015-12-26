<?php
    namespace App\Http\Controller;

    use App\Biz\ColumnBiz;
    use App\Http\Controller\BaseController;
    /**
    * 
    */
    class ColumnController extends BaseController
    {
        public $pageData = '';
        public $count = '';

        public function index(){
            $column_biz = new ColumnBiz();
            $this->pageData = $column_biz->getAll();
            $this->count = count($this->pageData);

            return view('column/index')->with(array(
                'count' => $this->count,
                'pageData' => $this->pageData
            ));
        }

        public function add(){
            return view('column/add');
        }

        public function doAdd(){
            $data = $_POST;
            if (empty($data)) {
                return returnJson('error');
            }

            $column_biz = new ColumnBiz();
            $result = $column_biz->addColumn($data);
            $page = $result ? 'index' : '/error';
            return redirect($page);
        }

        public function edit(){
            $id = intval($_GET['id']);
            if (empty($id)) {
                return returnJson('error');
            }
            $column_biz = new ColumnBiz();
            $this->pageData = $column_biz->getOne($id);
            return view('column/edit')->with($this->pageData);
        }

        public function doEdit(){
            $id = intval($_GET['id']);
            if (empty($id)) {
                return returnJson('error');
            }
            $data = $_POST;
            if (empty($data)) {
                return returnJson('error');
            }

            $column_biz = new ColumnBiz();
            $result = $column_biz->editColumn($data, $id);
            $page = $result ? 'index' : '/error';
            return redirect($page);
        }

        public function doDelete(){
            $id = intval($_GET['id']);
            if (empty($id)) {
                return returnJson('error');
            }

            $column_biz = new ColumnBiz();
            $result = $column_biz->deleteColumn($id);
            $page = $result ? 'index' : '/error';
            return redirect($page);
        }
    }
?>