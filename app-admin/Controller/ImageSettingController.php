<?php
namespace Admin\Controller;

use Admin\Biz\ArticleBiz;
use Admin\Biz\ColumnBiz;
use Admin\Controller\BaseController;

class ImageSettingController extends BaseController
{
    /**
     * 展示文章页面
     * @return [type]     [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-25
     */
    public function index(){
        return view('image/index')->with(array(
            'data' => $data,
            'msg' => $msg,
            'url' => $url
        ));
    }
}