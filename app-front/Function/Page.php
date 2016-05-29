<?php
use Front\Biz\ArticleBiz;
use Front\Biz\CategoryBiz;

$category_data = array();
/**
 * 栏目
 */
if (!function_exists('category')) {
    function category(){
        $biz = new CategoryBiz();
        $categorys = $biz->getVisibleCategorys();
        $data = array();
        foreach ($categorys as $key => $category) {
            $id = $category['id'];
            $data[$id]['name'] = $category['name'];
            $data[$id]['url'] = '/'.$category['nickname'];
        }
        global $category_data;
        $category_data = $data;
        return $data;
    }
}

/**
 * 推荐
 */
if (!function_exists('recommend')) {
    function recommend(){
        $article_biz = new ArticleBiz();
        $articles = $article_biz->getRecommend(10);
        global $category_data;
        if (empty($category_data)) {
            $category_data = category();
        }
        $data = array();
        foreach ($articles as $key => $article) {
            //category
            $category = $category_data[$article['category_id']];
            $data[$key]['category_name'] = $category['name'];
            $data[$key]['category_url'] = $category['url'];
            //article
            $data[$key]['title'] = $article['title'];
            $data[$key]['nickname'] = $article['nickname'];
            $data[$key]['url'] = "{$category['url']}/{$article['nickname']}.".TEMPLATE_TYPE;
        }
        return $data;
    }
}

/**
 * 热门文章
 */
if (!function_exists('hot')) {
    function hot($num){
        $article_biz = new ArticleBiz();
        $articles = $article_biz->getHot($num);
        global $category_data;
        if (empty($category_data)) {
            $category_data = category();
        }
        $data = array();
        foreach ($articles as $key => $article) {
            //category
            $category = $category_data[$article['category_id']];
            $data[$key]['category_name'] = $category['name'];
            $data[$key]['category_url'] = $category['url'];
            //article
            $data[$key]['title'] = $article['title'];
            $data[$key]['nickname'] = $article['nickname'];
            $data[$key]['url'] = "{$category['url']}/{$article['nickname']}.".TEMPLATE_TYPE;
        }
        return $data;
    }
}

/**
 * 最新文章
 */
if (!function_exists('news')) {
    function news($num){
        $route = $_SESSION['route'];
        $nickname = end($route);
        if ($nickname) {
            //获取相应的栏目
            $category_biz = new CategoryBiz();
            $category = $category_biz->getCategoryByNickName($nickname);
            $article_biz = new ArticleBiz();
            $articles = $article_biz->getNew($num, $category['id']);
        } else {
            $article_biz = new ArticleBiz();
            $articles = $article_biz->getNew($num);
        }
        global $category_data;
        if (empty($category_data)) {
            $category_data = category();
        }
        $data = array();
        foreach ($articles as $key => $article) {
            //category
            $category = $category_data[$article['category_id']];
            $data[$key]['category_name'] = $category['name'];
            $data[$key]['category_url'] = $category['url'];
            //article
            $data[$key]['title'] = $article['title'];
            $data[$key]['author'] = $article['author'];
            $data[$key]['nickname'] = $article['nickname'];
            $data[$key]['url'] = "{$category['url']}/{$article['nickname']}.".TEMPLATE_TYPE;
            $data[$key]['description'] = $article['description'];
            $data[$key]['views'] = $article['views'];
            $data[$key]['create_time'] = date('Y-m-d',strtotime($article['create_time']));
        }
        return $data;
    }
}

if (!function_exists('relate')) {
    function relate($ee){
        $service = new SettingService();
        $system = $service->getSystemInfo();
        foreach ($system as $info) {
            if ($info['name'] == $variable) {
                return $info['value'];
            }
        }
    }
}

if (!function_exists('categorylist')) {
    function categorylist(){
        $route = $_SESSION['route'];
        $nickname = end($route);
        //获取相应的栏目
        $category_biz = new CategoryBiz();
        $category = $category_biz->getCategoryByNickName($nickname);
        //获取所有文章
        $article_biz = new ArticleBiz();
        $articles = $article_biz->getArticles($category['id'],20);
        $data = array();
        foreach ($articles as $key => $article) {
            //category
            $data[$key]['category_name'] = $category['name'];
            $data[$key]['category_url'] = '/'.$category['nickname'];
            //article
            $data[$key]['title'] = $article['title'];
            $data[$key]['author'] = $article['author'];
            $data[$key]['nickname'] = $article['nickname'];
            $data[$key]['url'] = "/{$category['nickname']}/{$article['nickname']}.".TEMPLATE_TYPE;
            $data[$key]['description'] = $article['description'];
            $data[$key]['create_time'] = $article['create_time'];
        }
        return $data;
    }
}

if (!function_exists('tags')) {
    function tags() {

    }
}