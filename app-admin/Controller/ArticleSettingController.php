<?php
namespace Admin\Controller;

use Admin\Biz\ArticleBiz;
use Admin\Biz\ColumnBiz;
use Admin\Controller\BaseController;
use Lib\Filter\Filter;

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
        $url = getSystem('url');
        if (strlen($url) == (strripos($url, '/') + 1)) {
            $url = substr($url, 0, -1);
        }
        $msg = getMsg();

        return view('article/index')->with(array(
            'i' => 0,
            'articles' => $data,
            'msg' => $msg,
            'url' => $url
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
        $url = getSystem('url');
        if (strlen($url) == (strripos($url, '/') + 1)) {
            $url = substr($url, 0, -1);
        }
        $msg = getMsg();

        return view('article/index')->with(array(
            'i' => 0,
            'articles' => $data,
            'msg' => $msg,
            'url' => $url
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
        if (isset($params['status'])) {
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
        $category_list = $biz->getColumns();
        //判断是否为空，没有栏目则返回添加栏目
        if (empty($category_list)) {
            $_SESSION['msg'] = '请先添加栏目！';
            return redirect('column/index');
        }
        //组合数据
        $categorys = array();
        foreach ($category_list as $category) {
            $id = $category['id'];
            $categorys[$id]['name'] = $category['name'];
            $categorys[$id]['nickname'] = $category['nickname'];
        }
        $url = getSystem('url');
        if (strlen($url) == (strripos($url, '/') + 1)) {
            $url = substr($url, 0, -1);
        }
        return view('article/add')->with(array('categorys' => $categorys,'url' => $url));
    }

    /**
     * 新增文章操作
     * @return [type]     [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-25
     */
    public function doAdd(){
        $params = $_POST;
        $filter = new Filter();
        $data = $filter->make($params,array(
            'title' => 'required | string',
            'nickname' => 'string',
            'category' => 'required | int | min:1',
            'tags' => 'required | string',
            'description' => 'required | string',
            ));
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
            $columns[$id]['nickname'] = $column['nickname'];
        }
        $url = getSystem('url');
        if (strlen($url) == (strripos($url, '/') + 1)) {
            $url = substr($url, 0, -1);
        }
        return view('article/edit')->with(array(
            'article' => $article,
            'columns' => $columns,
            'url' => $url
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
        if (isset($params['nickname']) && $params['nickname']) {
            $data['nickname'] = filter_var($params['nickname'], FILTER_SANITIZE_STRING);
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
            $data['id'] = intval($params['id']);
        }
        if (isset($params['column']) && $params['column']) {
            $data['column'] = intval($params['column']);
        }

        $biz = new ArticleBiz();
        $result = $biz->disableArticle($data);
        $_SESSION['msg'] = $result ? '删除文章成功！' : '删除文章失败！';
        return redirect('article/index');
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
        foreach ($columns as $value) {
            $id = $value['id'];
            $column[$id]['name'] = $value['name'];
            $column[$id]['nickname'] = $value['nickname'];
        }
        $data = array();
        //拼接相应的数据
        foreach ($articles as $article) {
            $id = $article['id'];
            $data[$id]['title'] = $article['title'];
            $data[$id]['author'] = $article['author'];
            $data[$id]['description'] = $article['description'];
            $data[$id]['column_id'] = $article['column_id'];
            $data[$id]['column'] = $column[$article['column_id']]['name'];
            $data[$id]['is_show'] = $article['is_show'];
            $data[$id]['create_time'] = $article['create_time'];
            $data[$id]['column_nickname'] = $column[$article['column_id']]['nickname'];
            $data[$id]['article_nickname'] = $article['nickname'];
        }
        return $data;
    }

    public function translate()
    {
        $param = $_GET;
        return translate($param['variable']);
    }
}