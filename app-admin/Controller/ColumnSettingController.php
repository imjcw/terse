<?php
namespace Admin\Controller;

use Admin\Biz\ColumnBiz;
use Admin\Biz\ArticleBiz;
use Admin\Controller\BaseController;
use Admin\Exception\TranslateException;

class ColumnSettingController extends BaseController
{
    /**
     * 栏目管理首页
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function index(){
        /* 获取所有栏目 */
        $biz = new ColumnBiz();
        $columns = $biz->getColumns();

        /* 拼凑数据 */
        $data = array();
        foreach ($columns as $column) {
            $id = $column['id'];
            $data[$id]['name'] = $column['name'];
            $data[$id]['nickname'] = $column['nickname'];
            $data[$id]['is_show'] = $column['is_show'];
            $data[$id]['articles'] = $column['article_nums'];
            $data[$id]['description'] = $column['description'];
        }
        $msg = getMsg();

        return view('column/index')->with(array(
            'columns' => $data,
            'msg' => $msg
        ));
    }

    /**
     * 添加栏目页显示
     * @author marvin
     * @date   2016-02-23
     */
    public function add(){
        return view('column/add');
    }

    /**
     * 添加栏目操作
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function doAdd(){
        $params = $_POST;
        //字段验证
        if (isset($params['name']) && $params['name']) {
            $data['name'] = strval($params['name']);
        }
        if (isset($params['nickname']) && $params['nickname']) {
            $data['nickname'] = strval($params['nickname']);
        }
        if (isset($params['description']) && $params['description']) {
            $data['description'] = strval($params['description']);
        }

        //添加栏目
        $biz = new ColumnBiz();
        $result = $biz->addColumn($data);
        if ($result) {
            $data['id'] = $result;
            if (!$this->writeRoutes($data)) {
                $_SESSION['msg'] = '路由更新失败！请编辑该栏目！';
                return redirect('/column-setting/index');
            }            
        }

        //设置提示信息
        $_SESSION['msg'] = $result ? '添加栏目成功！' : '添加栏目失败！';
        return redirect('/column-setting/index');
    }

    /**
     * 编辑栏目页显示
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function edit(){
        $params = $_GET;
        if (isset($params) && $params['id']) {
            $id = intval($params['id']);
        }
        $biz = new ColumnBiz();
        $column = $biz->getColumn($id);
        return view('column/edit')->with($column);
    }

    /**
     * 编辑栏目操作
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function doEdit(){
        $params = $_GET;
        if (isset($params) && $params['id']) {
            $data['id'] = intval($params['id']);
        }
        $params = $_POST;
        //字段验证
        if (isset($params['name']) && $params['name']) {
            $data['name'] = strval($params['name']);
        }
        if (isset($params['nickname']) && $params['nickname']) {
            $data['nickname'] = strval($params['nickname']);
        }
        if (isset($params['description']) && $params['description']) {
            $data['description'] = strval($params['description']);
        }

        $biz = new ColumnBiz();
        $result = $biz->updateColumn($data);
        if ($result) {
            if (!$this->writeRoutes($data)) {
                $_SESSION['msg'] = '路由更新失败！请重新编辑该栏目！';
                return redirect('/column-setting/index');
            }            
        }

        $_SESSION['msg'] = $result ? '编辑栏目成功！' : '编辑栏目失败！';
        return redirect('/column-setting/index');
    }

    /**
     * 删除栏目操作
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function doDelete(){
        $params = $_GET;
        if (isset($params['id']) && $params['id']) {
            $id = intval($params['id']);
        }

        $column_biz = new ColumnBiz();
        $result = $column_biz->deleteColumn($id);
        if ($result) {
            $article_biz = new ArticleBiz();
            if (isset($params['article']) && $params['article']) {
                $article_biz->deleteArticlesByColumnId($id);
            } else {
                $article_biz->updateColumnId($id);
            }
            $data['id'] = $id;
            if (!$this->writeRoutes($data, 'delete')) {
                $_SESSION['msg'] = '路由更新失败！请手动更新！';
                return redirect('/column-setting/index');
            }
        }
        $_SESSION['msg'] = $result ? '删除栏目成功！' : '删除栏目失败！';
        return redirect('/column-setting/index');
    }

    /**
     * 栏目启用/禁用开关
     * @param  integer $id     [description]
     * @param  integer $status [description]
     * @return [type]          [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function changeVisible()
    {
        $id = intval($_POST['id']);
        $status = intval($_POST['status']);
        $biz = new ColumnBiz();
        $result = $biz->changeVisible($id,$status);
        return $result ? json('success！') : json('fault！', 403);
    }

    /**
     * 重写路由
     * @param  [type]     $data [description]
     * @return [type]           [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function writeRoutes($data, $action='')
    {
        require(ROOT.'/app-front/routes.php');
        if ($action == 'delete') {
            unset($routes['article'][$data['id']]);
        } else {
            //检测是否存在nickname，不存在则拼音化栏目名
            if (isset($data['nickname']) && $data['nickname']) {
                $name = $data['nickname'];
            } else {
                $translate = new TranslateException();
                $name = $translate->get_pinyin($data['name']);
            }
            $routes['article'][$data['id']] = $name;
        }
        //写入app-front中的routes.php
        $str_start = "<?php\n";
        $str = '$routes = '.var_export($routes,true);
        $str_end = ';';
        return file_put_contents(ROOT.'/app-front/routes.php', $str_start.$str.$str_end);
    }
}