<?php
use Lib\View\Page;
/**
* 模板命令
*/

/**
* 加载通配模板
*/
if (!function_exists('extend')) {
    function extend($path = ''){
        if (empty($path)) {
            returnJson('1002', '模板路径错误！');
        }else{
            $page = Page::init();
            $page->extend($path);
        }
    }
}

/**
* 启用
*/
if (!function_exists('start')) {
    function start(){
        $page = Page::init();
        $page->start();
    }
}

/**
* 停止
*/
if (!function_exists('stop')) {
    function stop(){
        $page = Page::init();
        $page->stop();
    }
}

/**
* 输出
*/
if (!function_exists('export')) {
    function export(){
        $page = Page::init();
        $page->export();
    }
}

/**
* 指定js，css路径
*/
if (!function_exists('want')) {
    function want($obj = ''){
        $pos = strpos($obj, '/');
        if ($pos) {
           echo '/public/'.$obj;
        }else{
           echo '/public'.$obj;
        }
    }
}

?>