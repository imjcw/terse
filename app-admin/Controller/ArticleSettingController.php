<?php
namespace Admin\Controller;

use Admin\Biz\ArticleBiz;
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
    public function index(){
        //获取所有文章
        $article_biz = new ArticleBiz();
        $articles = $article_biz->getArticles();
        $column_ids = array_column($articles,'column_id');
        //获取相应的栏目
        $column_biz = new ColumnBiz();
        $columns = $column_biz->getColumnByIds($column_ids);
        //组合数据
        $data = $this->buildPageData($articles,$columns);
        $msg = getMsg();

        return view('article/index')->with(array(
            'data' => $data,
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
        $msg = getMsg();

        return view('article/index')->with(array(
            'data' => $data,
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
        $params = $_POST;
        if (isset($params['id']) && $params['id']) {
            $id = intval($_POST['id']);
        }
        if (isset($params['status']) && $params['sattus']) {
            $status = intval($_POST['status']);
        }
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
        //获取栏目
        $biz = new ColumnBiz();
        $column_list = $biz->getColumns();
        //判断是否为空，没有栏目则返回添加栏目
        if (empty($column_list)) {
            $_SESSION['msg'] = '请先添加栏目！';
            return redirect('column/index');
        }
        //组合数据
        $columns = array();
        foreach ($column_list as $column) {
            $id = $column['id'];
            $columns[$id]['name'] = $column['name'];
        }
        return view('article/add')->with(array('columns' => $columns));
    }

    /**
     * 新增文章操作
     * @return [type]     [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-25
     */
    public function doAdd(){
        $params = $_POST;
        if (isset($params['title']) && $params['title']) {
            $data['title'] = filter_var($params['title'], FILTER_SANITIZE_STRING);
        }
        if (isset($params['column']) && $params['column']) {
            $data['column'] = filter_var($params['column'], FILTER_VALIDATE_INT);
        }
        if (isset($params['description']) && $params['description']) {
            $data['description'] = filter_var($params['description'], FILTER_SANITIZE_STRING);
        }
        if (isset($params['content']) && $params['content']) {
            $data['content'] = addslashes(htmlspecialchars($params['content']));
        }
        $data['author'] = 'test';
        $article_biz = new ArticleBiz();
        $result = $article_biz->addArticle($data);
        $_SESSION['msg'] = $result ? '添加文章成功！' : '添加文章失败！';
        return redirect('article/index');
    }

    /**
     * 展示编辑文章页面
     * @return [type]     [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-25
     */
    public function edit(){
        $params = $_GET;
        if (isset($params['id']) && $params['id']) {
            $id = intval($params['id']);
        }
        $article_biz = new ArticleBiz();
        $article = $article_biz->getArticle($id);
        $column_biz = new ColumnBiz();
        $column_list = $column_biz->getColumns();
        //组合数据
        $columns = array();
        foreach ($column_list as $column) {
            $id = $column['id'];
            $columns[$id]['name'] = $column['name'];
        }
        return view('article/edit')->with(array(
            'article' => $article,
            'columns' => $columns
            ));
    }

    /**
     * 编辑文章操作
     * @return [type]     [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-25
     */
    public function doEdit(){
        $params = $_GET;
        if (isset($params['id']) && $params['id']) {
            $id = intval($params['id']);
        }
        $params = $_POST;
        if (isset($params['title']) && $params['title']) {
            $data['title'] = filter_var($params['title'], FILTER_SANITIZE_STRING);
        }
        if (isset($params['column']) && $params['column']) {
            $data['column'] = filter_var($params['column'], FILTER_VALIDATE_INT);
        }
        if (isset($params['old_column']) && $params['old_column']) {
            $data['old_column'] = filter_var($params['old_column'], FILTER_VALIDATE_INT);
        }
        if (isset($params['description']) && $params['description']) {
            $data['description'] = filter_var($params['description'], FILTER_SANITIZE_STRING);
        }
        if (isset($params['content']) && $params['content']) {
            $data['content'] = addslashes(htmlspecialchars($params['content']));
        }
        if (isset($params['content_id']) && $params['content_id']) {
            $data['content_id'] = filter_var($params['content_id'], FILTER_VALIDATE_INT);
        }

        $biz = new ArticleBiz();
        $result = $biz->updateArticle($id, $data);
        $_SESSION['msg'] = $result ? '修改文章成功！' : '修改文章失败！';
        return redirect('article/index');
    }

    /**
     * 删除文章操作
     * @return [type]     [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-25
     */
    public function doDelete(){
        $params = $_GET;
        if (isset($params['id']) && $params['id']) {
            $id = intval($params['id']);
        }

        $biz = new ArticleBiz();
        $result = $biz->disableArticle($id);
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
        $data = array();
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