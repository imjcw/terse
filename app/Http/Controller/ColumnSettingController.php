<?php
namespace App\Http\Controller;

use App\Biz\ColumnBiz;
use App\Http\Controller\BaseController;
use App\Exception\TranslateException;
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
        mkdir(ROOT.'/storage/'.$name, 0755, true);
        chown(ROOT.'/storage/'.$name, 'marvin');
        chmod(ROOT.'/storage/'.$name, 0755);
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