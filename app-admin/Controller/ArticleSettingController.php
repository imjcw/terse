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
        $pageData = $article_biz->getAll();
        $column_ids = array_column($pageData,'column_id');
        //获取相应的栏目
        $column_biz = new ColumnBiz();
        $columns = $column_biz->getColumnByIds($column_ids);
        foreach ($columns as $columns) {
            $column_name[$columns['id']] = $columns['name'];
        }
        //拼接相应的数据
        foreach ($pageData as $article) {
            $id = $article['id'];
            $data[$id]['title'] = $article['title'];
            $data[$id]['description'] = $article['description'];
            $data[$id]['column_id'] = $column_name[$article['column_id']];
            $data[$id]['is_show'] = $article['is_show'] ? '是' : '否';
            $data[$id]['create_time'] = $article['create_time'];
        }
        $count = count($data);
        $msg = getMsg();

        return view('article/index')->with(array(
            'count' => $count,
            'pageData' => $data,
            'msg' => $msg
        ));
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
        $id = intval($_GET['id']);
        if (empty($id)) {
            return json('error');
        }

        $article_biz = new ArticleBiz();
        $result = $article_biz->deleteArticle($id);
        $page = $result ? 'index' : '/error';
        $_SESSION['msg'] = $result ? '删除文章成功！' : '删除文章失败！';
        return redirect($page);
    }
}