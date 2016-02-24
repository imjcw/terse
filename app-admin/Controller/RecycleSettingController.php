<?php
namespace Admin\Controller;

use Admin\Biz\RecycleBiz;
use Admin\Biz\ColumnBiz;
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
        $article_biz = new RecycleBiz();
        $articles = $article_biz->getArticles();
        $column_ids = array_column($articles,'column_id');
        //获取相应的栏目
        $column_biz = new ColumnBiz();
        $columns = $column_biz->getColumnByIds($column_ids);
        //组合数据
        $data = $this->buildPageData($articles,$columns);
        $msg = getMsg();

        return view('recycle/index')->with(array(
            'articles' => $data,
            'msg' => $msg
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
        $params = $_GET;
        if (isset($params['id']) && $params['id']) {
            $id = intval($params['id']);
        }
        if (isset($params['column']) && $params['column']) {
            $column = intval($params['column']);
        }

        $biz = new RecycleBiz();
        $result = $biz->reuseArticle($id);
        if ($result) {
            $column_service = new ColumnBiz();
            $column_service->updateArticleNums($column,'add');
        }
        $_SESSION['msg'] = $result ? '恢复文章成功！' : '恢复文章失败！';
        return redirect('recycle/index');
    }

    /**
     * 物理删除文章
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-19
     */
    public function doDelete(){
        $params = $_GET;
        if (isset($params['id']) && $params['id']) {
            $data['id'] = intval($params['id']);
        }
        if (isset($params['id']) && $params['id']) {
            $data['content'] = intval($params['id']);
        }

        $biz = new RecycleBiz();
        $result = $biz->deleteArticle($data);
        $_SESSION['msg'] = $result ? '删除文章成功！' : '删除文章失败！';
        return redirect('recycle/index');
    }

    /**
     * 组合数据
     * @param  [type] $articles [description]
     * @param  [type] $columns  [description]
     * @return [type]           [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-02-18
     */
    public function buildPageData($articles,$columns)
    {
        foreach ($columns as $columns) {
            $column_name[$columns['id']] = $columns['name'];
        }
        $data = array();
        //拼接相应的数据
        foreach ($articles as $article) {
            $id = $article['id'];
            $data[$id]['title'] = $article['title'];
            $data[$id]['author'] = $article['author'];
            $data[$id]['column_id'] = $article['column_id'];
            $data[$id]['column'] = $column_name[$article['column_id']];
            $data[$id]['content_id'] = $article['content_id'];
            $data[$id]['create_time'] = $article['create_time'];
        }
        return $data;
    }
}