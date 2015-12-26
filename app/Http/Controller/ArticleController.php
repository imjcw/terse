<?php
    namespace App\Http\Controller;

    use App\Biz\ArticleBiz;
    use App\Biz\ColumnBiz;
    use App\Http\Controller\BaseController;
    /**
    * Article Controller
    */
    class ArticleController extends BaseController
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
            $column_biz = new ColumnBiz();
            $column_list = $column_biz->getAll();
            
            return view('article/add')->with(array('column' => $column_list));
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
            $column_biz = new ColumnBiz();
            $column_list = $column_biz->getAll();
            return view('article/edit')->with(array('pageData' => $pageData, 'column' => $column_list));
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
            $result = $article_biz->editArticle($id, $data);
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