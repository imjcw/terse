<?php
    namespace App\Http\Controller;

    use App\Http\Controller\BaseController;
    /**
    * 
    */
    class AdminController extends BaseController
    {
        public $table = '`admin`';
        public $pageData = '';
        public $count = '';

        public function index(){
            $this->connect();
            $this->pageData = $this->all();
            $this->count = count($this->pageData);
            return view('admin/index')->with(array(
                'count' => $this->count,
                'pageData' => $this->pageData
            ));
        }

        public function add(){
            return view('admin/add');
        }

        public function doAdd(){
            $data = $_POST;
            $this->connect();
            $result = $this->insert($data);
            $page = $result ? 'index' : '/error';
            return redirect($page);
        }

        public function edit(){
            $id = $_GET['id'];
            $this->connect();
            $this->pageData = $this->one('`id` = '.$id);
            return view('admin/edit')->with($this->pageData);
        }

        public function doEdit(){
            $id = $_GET['id'];
            $data = $_POST;
            $this->connect();
            $result = $this->update($data,array('id' => $id));
            $page = $result ? 'index' : '/error';
            return redirect($page);
        }

        public function doDelete(){
            $id = $_GET['id'];
            $this->connect();
            $result = $this->delete(array('id' => $id));
            $page = $result ? 'index' : '/error';
            return redirect($page);
        }
    }