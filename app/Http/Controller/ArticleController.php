<?php
    /**
    * 
    */
    class ArticleController
    {
        public function index(){
            $article = model('article');
            $pageData = $article->all();
            $count = count($pageData);

            return view('article/index')->with(array(
                'count' => $count,
                'pageData' => $pageData
            ));
        }

        public function add(){
            return view('article/add');
        }

        public function doAdd(){
            $article = model('article');
            $result = $article->addArticle();
            $page = $result ? 'index' : '/error';
            return redirect($page);
        }

        public function edit(){
            $article = model('article');
            $pageData = $article->getOne();
            return view('article/edit')->with($pageData);
        }

        public function doEdit(){
            $article = model('article');
            $result = $article->editArticle();
            $page = $result ? 'index' : '/error';
            return redirect($page);
        }

        public function doDelete(){
            $article = model('article');
            $result = $article->deleteArticle();
            $page = $result ? 'index' : '/error';
            return redirect($page);
        }
    }
?>