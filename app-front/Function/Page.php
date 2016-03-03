<?php
use Front\Biz\ArticleBiz;
use Front\Biz\ColumnBiz;

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
            $data[$id]['nickname'] = $column['nickname'];
        }
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
        $data = array();
        foreach ($articles as $key => $article) {
            $data[$key]['title'] = $article['title'];
            $data[$key]['nickname'] = $article['nickname'];
            $data[$key]['column_id'] = $article['column_id'];
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
        $data = array();
        foreach ($articles as $key => $article) {
            $data[$key]['title'] = $article['title'];
            $data[$key]['nickname'] = $article['nickname'];
            $data[$key]['column_id'] = $article['column_id'];
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
        $data = array();
        foreach ($articles as $key => $article) {
            $data[$key]['title'] = $article['title'];
            $data[$key]['author'] = $article['author'];
            $data[$key]['nickname'] = $article['nickname'];
            $data[$key]['column_id'] = $article['column_id'];
            $data[$key]['description'] = $article['description'];
            $data[$key]['create_time'] = $article['create_time'];
        }
        return $data;
    }
}

if (!function_exists('relate')) {
    function relate($variable){
        $service = new SettingService();
        $system = $service->getSystemInfo();
        foreach ($system as $info) {
            if ($info['name'] == $variable) {
                return $info['value'];
            }
        }
    }
}