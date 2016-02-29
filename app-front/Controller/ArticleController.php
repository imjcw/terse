<?php
namespace Front\Controller;

use Front\Biz\ArticleBiz;
use Admin\Biz\ColumnBiz;

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
        //获取所有文章
        $article_biz = new ArticleBiz();
        $article = $article_biz->get($article_name,$column['id']);
        return view('/article')->with(array('data' => $article));
    }
}