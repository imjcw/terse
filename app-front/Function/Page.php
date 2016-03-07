<?php
use Front\Biz\ArticleBiz;
use Front\Biz\ColumnBiz;

$column_data = array();
/**
 * 栏目
 */
if (!function_exists('column')) {
    function column(){
        $biz = new ColumnBiz();
        $columns = $biz->getVisibleColumns();
        $data = array();
        foreach ($columns as $key => $column) {
            $id = $column['id'];
            $data[$id]['name'] = $column['name'];
            $data[$id]['url'] = '/'.$column['nickname'];
        }
        global $column_data;
        $column_data = $data;
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
        global $column_data;
        if (empty($column_data)) {
            $column_data = column();
        }
        $data = array();
        foreach ($articles as $key => $article) {
            //column
            $column = $column_data[$article['column_id']];
            $data[$key]['column_name'] = $column['name'];
            $data[$key]['column_url'] = $column['url'];
            //article
            $data[$key]['title'] = $article['title'];
            $data[$key]['nickname'] = $article['nickname'];
            $data[$key]['url'] = "{$column['url']}/{$article['nickname']}.".TEMPLATE_TYPE;
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
        global $column_data;
        if (empty($column_data)) {
            $column_data = column();
        }
        $data = array();
        foreach ($articles as $key => $article) {
            //column
            $column = $column_data[$article['column_id']];
            $data[$key]['column_name'] = $column['name'];
            $data[$key]['column_url'] = $column['url'];
            //article
            $data[$key]['title'] = $article['title'];
            $data[$key]['nickname'] = $article['nickname'];
            $data[$key]['url'] = "{$column['url']}/{$article['nickname']}.".TEMPLATE_TYPE;
        }
        return $data;
    }
}

/**
 * 最新文章
 */
if (!function_exists('news')) {
    function news($num){
        $article_biz = new ArticleBiz();
        $articles = $article_biz->getNew($num);
        global $column_data;
        if (empty($column_data)) {
            $column_data = column();
        }
        $data = array();
        foreach ($articles as $key => $article) {
            //column
            $column = $column_data[$article['column_id']];
            $data[$key]['column_name'] = $column['name'];
            $data[$key]['column_url'] = $column['url'];
            //article
            $data[$key]['title'] = $article['title'];
            $data[$key]['author'] = $article['author'];
            $data[$key]['nickname'] = $article['nickname'];
            $data[$key]['url'] = "{$column['url']}/{$article['nickname']}.".TEMPLATE_TYPE;
            $data[$key]['description'] = $article['description'];
            $data[$key]['create_time'] = $article['create_time'];
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

if (!function_exists('columnlist')) {
    function columnlist(){
        $route = $_SESSION['route'];
        $nickname = end($route);
        //获取相应的栏目
        $column_biz = new ColumnBiz();
        $column = $column_biz->getColumnByNickName($nickname);
        //获取所有文章
        $article_biz = new ArticleBiz();
        $articles = $article_biz->getArticles($column['id'],20);
        $data = array();
        foreach ($articles as $key => $article) {
            //column
            $data[$key]['column_name'] = $column['name'];
            $data[$key]['column_url'] = '/'.$column['nickname'];
            //article
            $data[$key]['title'] = $article['title'];
            $data[$key]['author'] = $article['author'];
            $data[$key]['nickname'] = $article['nickname'];
            $data[$key]['url'] = "/{$column['nickname']}/{$article['nickname']}.".TEMPLATE_TYPE;
            $data[$key]['description'] = $article['description'];
            $data[$key]['create_time'] = $article['create_time'];
        }
        return $data;
    }
}