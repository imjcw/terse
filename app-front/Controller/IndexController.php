<?php
namespace Front\Controller;

use Admin\Biz\ArticleBiz;
use Admin\Biz\ColumnBiz;
use Front\Controller\BaseController;

class IndexController
{
    /**
     * 模板管理显示
     * @return [type] [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-27
     */
    public function index(){
    	$pattern = '/\@(\w+) *\@/';
    	$subject = "@section('sidebar')
            This is the master sidebar.
        @end
        <";
    	dd(preg_match($pattern, $subject));
        return view('/index');
    }
}