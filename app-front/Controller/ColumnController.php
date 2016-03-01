<?php
namespace Front\Controller;

use Front\Biz\ArticleBiz;
use Admin\Biz\ColumnBiz;

class ColumnController
{
    /**
     * 模板管理显示
     * @return [type] [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-27
     */
    public function index(){
        $route = $_SESSION['route'];
        $nickname = end($route);
        //获取相应的栏目
        $column_biz = new ColumnBiz();
        $column = $column_biz->getColumnByNickName($nickname);
        //获取所有文章
        $article_biz = new ArticleBiz();
        $articles = $article_biz->getArticles($column['id']);
        return view('/list')->with(array('articles' => $articles,'column'=>$column['nickname']));
    }
}