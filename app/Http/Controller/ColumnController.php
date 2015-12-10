<?php
    /**
    * 
    */
    class ColumnController extends Connection
    {
        public function test(){
            Response::view('column/test');
        }
        public $table = '`column`';
        public $pageData = '';
        public $count = '';

        public function index(){
            $this->connect();
            $this->pageData = $this->all();
            $this->count = count($this->pageData);
            Response::view('column/index');
        }

        public function add(){
            Response::view('column/add');
        }

        public function doAdd(){
            $data = $_POST;
            $this->connect();
            $result = $this->insert($data);
            $page = $result ? 'index' : '/error';
            Response::redirect($page);
        }

        public function edit(){
            $id = $_GET['id'];
            $this->connect();
            $this->pageData = $this->one('`id` = '.$id);
            Response::view('column/edit');
        }

        public function doEdit(){
            $id = $_GET['id'];
            $data = $_POST;
            $this->connect();
            $result = $this->update($data,array('id' => $id));
            $page = $result ? 'index' : '/error';
            Response::redirect($page);
        }

        public function doDelete(){
            $id = $_GET['id'];
            $this->connect();
            $result = $this->delete(array('id' => $id));
            $page = $result ? 'index' : '/error';
            Response::redirect($page);
        }
    }
?>