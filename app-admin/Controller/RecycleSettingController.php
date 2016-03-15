<?php
namespace Admin\Controller;

use Admin\Biz\RecycleBiz;
use Admin\Biz\CategoryBiz;
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
        $category_ids = array_column($articles,'category_id');
        //获取相应的栏目
        $category_biz = new CategoryBiz();
        $categorys = $category_biz->getCategoryByIds($category_ids);
        //组合数据
        $data = $this->buildPageData($articles,$categorys);
        $msg = getMsg();

        return view('recycle/index')->with(array(
            'i' => 0,
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
        if (isset($params['category']) && $params['category']) {
            $category = intval($params['category']);
        }

        $biz = new RecycleBiz();
        $result = $biz->reuseArticle($id);
        if ($result) {
            $category_service = new CategoryBiz();
            $category_service->updateArticleNums($category,'add');
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
    public function buildPageData($articles,$categorys)
    {
        foreach ($categorys as $categorys) {
            $category_name[$categorys['id']] = $categorys['name'];
        }
        $data = array();
        //拼接相应的数据
        foreach ($articles as $article) {
            $id = $article['id'];
            $data[$id]['title'] = $article['title'];
            $data[$id]['author'] = $article['author'];
            $data[$id]['category_id'] = $article['category_id'];
            $data[$id]['category'] = $category_name[$article['category_id']];
            $data[$id]['content_id'] = $article['content_id'];
            $data[$id]['create_time'] = $article['create_time'];
        }
        return $data;
    }
}