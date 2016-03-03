<?php
namespace Front\Controller;

use Front\Biz\ArticleBiz;
use Front\Biz\ColumnBiz;
use Front\Controller\BaseController;

class ArticleController
{
    /**
     * 模板管理显示
     * @return [type] [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-27
     */
    public function index(){
        $route = $_SESSION['route'];
        $article_name = end($route);
        $nickname = $route[count($route) - 2 ];
        //获取相应的栏目
        $column_biz = new ColumnBiz();
        $column = $column_biz->getColumnByNickName($nickname);
        $data = $column_biz->getVisibleColumns();
        foreach ($data as $key => $value) {
            $id = $value['id'];
            $columns[$id]['name'] = $value['name'];
            $columns[$id]['nickname'] = $value['nickname'];
        }

        //获取所有文章
        $article_biz = new ArticleBiz();
        $article = $article_biz->get($article_name,$column['id']);
        $articles = $this->relate($column['id'],10);
        $clicks = $this->clicks(10);
        if (!$article) {
            redirect('/404');
        }
        return view('/article')->with(array('data' => $article,'column' => $column,'columns' => $columns,'articles' => $articles,'clicks' => $clicks));
    }

    public function relate($id, $num)
    {
        $biz = new ArticleBiz();
        return $biz->getArticles($id, $num);
    }

    public function clicks($num)
    {
        $biz = new ArticleBiz();
        return $biz->getClicks($num);
    }
}