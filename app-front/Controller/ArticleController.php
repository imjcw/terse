<?php
namespace Front\Controller;

use Front\Biz\ArticleBiz;
use Front\Biz\CategoryBiz;
use Front\Controller\BaseController;
use Admin\Service\TagService;
use Admin\Service\AdminService;

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
        if (!$article) {
            redirect('/404');
        }
        $admin_service = new AdminService();
        $admin = $admin_service->getAdmin($article['author']);
        $article['author'] = $admin['nickname'];
        $article['create_time'] = date('Y-m-d',strtotime($article['create_time']));
        if ($article['pre_url']) {
            $article['pre_url'] = '/' . $categorys[$article['pre_url']]['nickname'] . '/' . $article['pre_nickname'] . '.html';
        } else {
            $article['pre_title'] = '无';
        }
        if ($article['next_url']) {
            $article['next_url'] = '/' . $categorys[$article['next_url']]['nickname'] . '/' . $article['next_nickname'] . '.html';
        } else {
            $article['next_title'] = '无';
        }
        $article['category_name'] = $category['name'];
        $article['category_nickname'] = $category['nickname'];
        $tag_service = new TagService();
        $relations = $tag_service->getRelationsByArticleId($article['id']);
        $tag_ids = array_column($relations, 'tag_id');
        $tmp_tags = $tag_service->getTagsByIds($tag_ids);
        $tags = array_column($tmp_tags,'name');
        $_SESSION['article'] = $article['title'];
        $article_biz->hasView($article['id']);
        return view('/article')->with(array('data' => $article, 'tags' => implode(',', $tags)));
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