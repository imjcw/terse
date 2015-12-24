<?php
    namespace App\Http\Controller;

    use App\Biz\ArticleBiz;
    /**
    * Article Controller
    */
    class ArticleController
    {
        public function index(){
            $article_biz = new ArticleBiz();
            $pageData = $article_biz->getAll();
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
            $data = $_POST;
            if (empty($data)) {
                return json('error');
            }

            $article_biz = new ArticleBiz();
            $result = $article_biz->addArticle($data);
            $page = $result ? 'index' : '/error';
            return redirect($page);
        }

        public function edit(){
            $id = intval($_GET['id']);
            if (empty($id)) {
                return json('error');
            }

            $article_biz = new ArticleBiz();
            $pageData = $article_biz->getOne($id);
            return view('article/edit')->with($pageData);
        }

        public function doEdit(){
            $id = intval($_GET['id']);
            if (empty($id)) {
                return json('error');
            }
            $data = $_POST;
            if (empty($data)) {
                return json('error');
            }

            $article_biz = new ArticleBiz();
            $pageData = $article_biz->editArticle($id, $data);
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