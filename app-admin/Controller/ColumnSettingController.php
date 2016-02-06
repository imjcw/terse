<?php
namespace Admin\Controller;

use Admin\Biz\ColumnBiz;
use Admin\Controller\BaseController;
use Admin\Exception\TranslateException;

class ColumnSettingController extends BaseController
{
    public function index(){
        $column_biz = new ColumnBiz();
        $pageData = $column_biz->getAll();
        $count = count($pageData);

        return view('column/index')->with(array(
            'count' => $count,
            'pageData' => $pageData
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
        //mkdir(ROOT.'/storage/'.$name, 0755, true);
        //chmod(ROOT.'/storage/'.$name, 0755);
        $page = $result ? 'index' : '/error';
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
        $page = $result ? 'index' : '/error';
        return redirect($page);
    }

    public function doDelete(){
        $id = intval($_GET['id']);
        if (empty($id)) {
            return returnJson('error');
        }

        $column_biz = new ColumnBiz();
        $result = $column_biz->deleteColumn($id);
        $page = $result ? 'index' : '/error';
        return redirect($page);
    }
}