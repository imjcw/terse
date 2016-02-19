<?php
namespace Admin\Controller;

use Admin\Biz\RecycleBiz;
use Admin\Controller\BaseController;

class RecycleSettingController extends BaseController
{
    /**
     * 回收站首页
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-19
     */
    public function index(){
        $biz = new RecycleBiz();
        $articles = $biz->getAll();
        $count = count($articles);

        return view('recycle/index')->with(array(
            'count' => $count,
            'data' => $articles
        ));
    }

    /**
     * 恢复文章
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-19
     */
    public function reuse()
    {
        $id = intval($_GET['id']);
        if (empty($id)) {
            return json('error', '参数错误！');
        }

        $biz = new RecycleBiz();
        $result = $biz->reuseArticle($id);
        $page = $result ? 'index' : '/error';

        return redirect($page);
    }

    /**
     * 物理删除文章
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-19
     */
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