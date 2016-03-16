<?php
namespace Front\Controller;

use Front\Biz\ArticleBiz;
use Front\Biz\CategoryBiz;
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
        $category_biz = new CategoryBiz();
        $category = $category_biz->getCategoryByNickName($nickname);
        $data = $category_biz->getVisibleCategorys();
        foreach ($data as $key => $value) {
            $id = $value['id'];
            $categorys[$id]['name'] = $value['name'];
            $categorys[$id]['nickname'] = $value['nickname'];
        }

        //获取所有文章
        $article_biz = new ArticleBiz();
        $article = $article_biz->get($article_name,$category['id']);
        $article['category_name'] = $category['name'];
        $article['category_nickname'] = $category['nickname'];
        if (!$article) {
            redirect('/404');
        }
        $_SESSION['article'] = $article['title'];
        $article_biz->hasView($article['id']);
        return view('/article')->with(array('data' => $article));
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