<?php
    /**
    * 
    */
    class ArticleController extends Connection
    {
        public $table = '`recycle`';
        public $pageData = '';
        public $count = '';

        public function index(){
            $this->connect();
            $this->pageData = $this->all();
            $this->count = count($this->pageData);
            return view('recycle/index')->with(array(
                'count' => $this->count,
                'pageData' => $this->pageData
            ));
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