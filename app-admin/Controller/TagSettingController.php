<?php
namespace Admin\Controller;

use Admin\Biz\TagBiz;
use Admin\Controller\BaseController;

class TagSettingController extends BaseController
{
    public function index()
    {
        $biz = new TagBiz();
        $tags = $biz->getTags();
        return view('tag/index')->with(array(
            'tags' => $tags,
            'msg' =>''
            ));
    }
}