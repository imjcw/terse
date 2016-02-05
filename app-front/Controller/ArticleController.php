<?php
namespace Front\Controller;

class ArticleController
{
    /**
     * 模板管理显示
     * @return [type] [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-27
     */
    public function index(){
        $data['title'] = '来来来，测试一下';
        $data['content'] = '内容：来来来，测试一下';
        return view('/article')->with(array('data' => $data));
    }
}