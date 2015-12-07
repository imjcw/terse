<?php
    /**
    * 
    */
    class TestController extends Connection
    {
        public $table = '`column`';
        public $pageData = '';

        public function index(){
            $this->connect();
            $this->pageData = $this->all();
            Response::view('column/index');
        }

        public function add(){
            Response::view('column/add');
        }

        public function doAdd(){
            echo "string";
        }

        public function edit(){
            Response::view('column/edit');
        }

        public function doEdit(){
            echo "string";
        }
    }
?>