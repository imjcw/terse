<?php
namespace Admin\Controller;

use Admin\Biz\ArticleBiz;
use Lib\View\Pagination;
use Admin\Biz\ColumnBiz;
use Admin\Controller\BaseController;

class ArticleSettingController extends BaseController
{
    /**
     * 展示文章页面
     * @return [type]     [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-25
     */
    public function index(){//$t = new Pagination;dd($t->pagination());
        //获取所有文章
        $article_biz = new ArticleBiz();
        $articles = $article_biz->getAll();
        $column_ids = array_column($articles,'column_id');
        //获取相应的栏目
        $column_biz = new ColumnBiz();
        $columns = $column_biz->getColumnByIds($column_ids);
        //组合数据
        $data = $this->buildPageData($articles,$columns);
        $count = count($data);
        $msg = getMsg();

        return view('article/index')->with(array(
            'count' => $count,
            'pageData' => $data,
            'msg' => $msg
        ));
    }

    /**
     * 文章搜索
     * @return [type] [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-02-17
     */
    public function search()
    {
        $params = $_GET;
        if (isset($params['column'])) {
            $search['column'] = strval($params['column']);
        }
        if (isset($params['author'])) {
            $search['author'] = strval($params['author']);
        }
        //获取所有文章
        $article_biz = new ArticleBiz();
        $articles = $article_biz->search($search);
        $column_ids = array_column($articles,'column_id');
        //获取相应的栏目
        $column_biz = new ColumnBiz();
        $columns = $column_biz->getColumnByIds($column_ids);
        //组合数据
        $data = $this->buildPageData($articles,$columns);
        $count = count($data);
        $msg = getMsg();

        return view('article/index')->with(array(
            'count' => $count,
            'pageData' => $data,
            'msg' => $msg
        ));
    }

    /**
     * 改变文章显示状态
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-18
     */
    public function changeVisible()
    {
        $id = intval($_POST['id']);
        $status = intval($_POST['status']);
        $biz = new ArticleBiz();
        $result = $biz->changeVisible($id,$status);
        return $result ? json('success！') : json('fault！', 403);
    }
    /**
     * 展示文章添加页面
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-25
     */
    public function add(){
        $column_biz = new ColumnBiz();
        $column_list = $column_biz->getAll();
        return view('article/add')->with(array('column' => $column_list));
    }

    /**
     * 新增文章操作
     * @return [type]     [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-25
     */
    public function doAdd(){
        $data = $_POST;
        if (empty($data)) {
            return json('error');
        }
        $data['author'] = 'test';
        $article_biz = new ArticleBiz();
        $result = $article_biz->addArticle($data);
        $page = $result ? 'index' : '/error';
        $_SESSION['msg'] = $result ? '添加文章成功！' : '添加文章失败！';
        return redirect($page);
    }

    /**
     * 展示编辑文章页面
     * @return [type]     [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-25
     */
    public function edit(){
        $id = intval($_GET['id']);
        if (empty($id)) {
            return json('error');
        }

        $article_biz = new ArticleBiz();
        $pageData = $article_biz->getOne($id);
        $column_biz = new ColumnBiz();
        $column_list = $column_biz->getAll();
        return view('article/edit')->with(array('pageData' => $pageData, 'column' => $column_list));
    }

    /**
     * 编辑文章操作
     * @return [type]     [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-25
     */
    public function doEdit(){
        $id = intval($_GET['id']);
        if (empty($id)) {
            return json('error');
        }
        if (!filter_var($_POST['title'], FILTER_SANITIZE_STRING)) {
            dd('title');
        }else {
            $data['title'] = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
        }
        if (!filter_var($_POST['column'], FILTER_VALIDATE_INT)) {
            dd('int');
        }else {
            $data['column_id'] = filter_var($_POST['column'], FILTER_VALIDATE_INT);
        }
        if (!filter_var($_POST['description'], FILTER_SANITIZE_STRING)) {
            dd('description');
        }else {
            $data['description'] = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
        }
        if (!filter_var($_POST['content'], FILTER_SANITIZE_STRING)) {
            dd('content');
        }else {
            $data['content'] = filter_var($_POST['content'], FILTER_SANITIZE_SPECIAL_CHARS);
        }

        $article_biz = new ArticleBiz();
        $result = $article_biz->editArticle($id, $data);
        $page = $result ? 'index' : '/error';
        $_SESSION['msg'] = $result ? '修改文章成功！' : '修改文章失败！';
        return redirect($page);
    }

    /**
     * 删除文章操作
     * @return [type]     [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-25
     */
    public function doDelete(){
        $id = intval($_POST['id']);
        if (empty($id)) {
            return json('error');
        }

        $biz = new ArticleBiz();
        $result = $biz->deleteArticle($id);
        return $result ? json('删除文章成功！') : json('删除文章失败！');
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
        //拼接相应的数据
        foreach ($articles as $article) {
            $id = $article['id'];
            $data[$id]['title'] = $article['title'];
            $data[$id]['author'] = $article['author'];
            $data[$id]['description'] = $article['description'];
            $data[$id]['column_id'] = $column_name[$article['column_id']];
            $data[$id]['is_show'] = $article['is_show'];
            $data[$id]['create_time'] = $article['create_time'];
        }
        return $data;
    }
}