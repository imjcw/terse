<?php
    /**
    * 
    */
    class ArticleController extends Connection
    {
        public $table = '`article`';
        public $pageData = '';
        public $count = '';

        public function index(){
            $this->connect();
            $this->pageData = $this->all();
            $this->count = count($this->pageData);
            return view('article/index')->with(array(
                'count' => $this->count,
                'pageData' => $this->pageData
            ));
        }

        public function add(){
            return view('article/add');
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
            return view('article/edit')->with($this->pageData);
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
?>