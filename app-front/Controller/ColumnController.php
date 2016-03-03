<?php
namespace Front\Controller;

use Front\Biz\ArticleBiz;
use Front\Biz\ColumnBiz;
use Front\Controller\BaseController;

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
        $columns = $this->getColumns();
        //获取相应的栏目
        $column_biz = new ColumnBiz();
        $column = $column_biz->getColumnByNickName($nickname);
        //获取所有文章
        $article_biz = new ArticleBiz();
        $articles = $article_biz->getArticles($column['id'],20);
        return view('/list')->with(array(
            'articles' => $articles,
            'column'=>$column['nickname'],
            'columns' => $columns
            ));
    }

    public function getColumns()
    {
        $biz = new ColumnBiz();
        $columns = $biz->getVisibleColumns();
        $data = array();
        foreach ($columns as $key => $column) {
            $id = $column['id'];
            $data[$id]['name'] = $column['name'];
            $data[$id]['nickname'] = $column['nickname'];
        }
        return $data;
    }
}