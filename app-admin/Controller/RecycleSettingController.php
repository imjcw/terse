<?php
namespace Admin\Controller;

use Admin\Biz\RecycleBiz;
use Admin\Controller\BaseController;

class RecycleSettingController extends BaseController
{
    public function index(){
        $biz = new RecycleBiz();
        $pageData = $biz->getAll();
        $count = count($pageData);

        return view('recycle/index')->with(array(
            'count' => $count,
            'pageData' => $pageData
        ));
    }

    public function reuse()
    {
        $id = intval($_GET['id']);
        if (empty($id)) {
            return json('error', '参数错误！');
        }

        $recyle_biz = new RecycleBiz();
        $result = $recyle_biz->reuseArticle($id);
        $page = $result ? 'index' : '/error';

        return redirect($page);
    }

    public function doDelete(){
        $id = intval($_GET['id']);
        if (empty($id)) {
            return json('error', '参数错误！');
        }

        $recyle_biz = new RecycleBiz();
        $result = $recyle_biz->deleteArticle($id);
        $page = $result ? 'index' : '/error';

        return redirect($page);
    }
}