<?php
namespace Front\Controller;

use Front\Biz\ArticleBiz;
use Front\Biz\CategoryBiz;
use Front\Controller\BaseController;

class CategoryController
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
        $categorys = $this->getCategorys();
        //获取相应的栏目
        $category_biz = new CategoryBiz();
        $category = $category_biz->getCategoryByNickName($nickname);
        //获取所有文章
        $article_biz = new ArticleBiz();
        $articles = $article_biz->getArticles($category['id'],20);
        return view('/list')->with(array(
            'articles' => $articles,
            'category'=>$category['nickname'],
            'categorys' => $categorys
            ));
    }

    public function getCategorys()
    {
        $biz = new CategoryBiz();
        $categorys = $biz->getVisibleCategorys();
        $data = array();
        foreach ($categorys as $key => $category) {
            $id = $category['id'];
            $data[$id]['name'] = $category['name'];
            $data[$id]['nickname'] = $category['nickname'];
        }
        return $data;
    }
}