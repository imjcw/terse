<?php
namespace Admin\Controller;

use Admin\Biz\ColumnBiz;
use Admin\Biz\ArticleBiz;
use Admin\Controller\BaseController;
use Admin\Exception\TranslateException;

class ColumnSettingController extends BaseController
{
    public function index(){
        $column_biz = new ColumnBiz();
        $columns = $column_biz->getAll();
        $column_ids = array_column($columns,'id');

        $article_biz = new ArticleBiz();
        $articles = $article_biz->getArticlesByColumnIds($column_ids);
        foreach ($articles as $article) {
            $id = $article['column_id'];
            $count[$id] = isset($count[$id]) ? ++$count[$id] : 1;
        }
        foreach ($columns as $column) {
            $id = $column['id'];
            $data[$id]['name'] = $column['name'];
            $data[$id]['nickname'] = $column['nickname'];
            $data[$id]['description'] = $column['description'];
            $data[$id]['articles'] = isset($count[$id]) ? $count[$id] : 0;
        }
        $msg = getMsg();

        return view('column/index')->with(array(
            'count' => $count,
            'pageData' => $data,
            'msg' => $msg
        ));
    }

    public function add(){
        return view('column/add');
    }

    public function doAdd(){
        $data = $_POST;
        if (empty($data)) {
            return returnJson('error');
        }

        $column_biz = new ColumnBiz();
        $result = $column_biz->addColumn($data);
        $translate = new TranslateException();
        $name = $translate->get_pinyin($data['name']);
        require(ROOT.'/app-front/routes.php');
        $routes['article'][] = $name;
        $str_start = "<?php\n";
        $str = '$routes = '.var_export($routes,true);
        $str_end = ';';
        file_put_contents(ROOT.'/app-front/routes.php', $str_start.$str.$str_end);
        $page = $result ? 'index' : '/error';
        $_SESSION['msg'] = $result ? '添加栏目成功！' : '添加栏目失败！';
        return redirect($page);
    }

    public function edit(){
        $id = intval($_GET['id']);
        if (empty($id)) {
            return returnJson('error');
        }
        $column_biz = new ColumnBiz();
        $pageData = $column_biz->getOne($id);
        return view('column/edit')->with($pageData);
    }

    public function doEdit(){
        $id = intval($_GET['id']);
        if (empty($id)) {
            return returnJson('error');
        }
        $data = $_POST;
        if (empty($data)) {
            return returnJson('error');
        }

        $column_biz = new ColumnBiz();
        $result = $column_biz->editColumn($data, $id);
        $_SESSION['msg'] = $result ? '编辑栏目成功！' : '编辑栏目失败！';
        return redirect('index');
    }

    public function doDelete(){
        $id = intval($_GET['id']);
        if (empty($id)) {
            return returnJson('error');
        }

        $column_biz = new ColumnBiz();
        $result = $column_biz->deleteColumn($id);
        $page = $result ? 'index' : '/error';
        $_SESSION['msg'] = $result ? '删除栏目成功！' : '删除栏目失败！';
        return redirect($page);
    }
}