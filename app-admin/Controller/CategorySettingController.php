<?php
namespace Admin\Controller;

use Admin\Biz\CategoryBiz;
use Admin\Biz\ArticleBiz;
use Admin\Controller\BaseController;
use Admin\Exception\TranslateException;
use Lib\Filter\Filter;

class CategorySettingController extends BaseController
{
    /**
     * 栏目管理首页
     * @return [type]     [description]
     * @author marvin
     * @date   2016-02-23
     */
    public function index(){
        /* 获取所有栏目 */
        $biz = new CategoryBiz();
        $categorys = $biz->getCategorys();

        /* 拼凑数据 */
        $data = array();
        foreach ($categorys as $category) {
            $id = $category['id'];
            $data[$id]['name'] = $category['name'];
            $data[$id]['nickname'] = $category['nickname'];
            $data[$id]['is_show'] = $category['is_show'];
            $data[$id]['articles'] = $category['article_nums'];
            $data[$id]['description'] = $category['description'];
        }
        $msg = getMsg();

        return view('category/index')->with(array(
            'categorys' => $data,
            'msg' => $msg
        ));
    }

    /**
     * 添加栏目页显示
     * @author marvin
     * @date   2016-02-23
     */
    public function add(){
        return view('category/add');
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
        $filter = new Filter();
        $data = $filter->make($params,array(
            'name'        => 'required | string',
            'nickname'    => 'required | string',
            'description' => 'string'
            ));

        //添加栏目
        $biz = new CategoryBiz();
        $result = $biz->addCategory($data);
        if ($result) {
            $data['id'] = $result;
            if (!$this->writeRoutes($data)) {
                $_SESSION['msg'] = '路由更新失败！请编辑该栏目！';
                return redirect('/category/index');
            }            
        }

        //设置提示信息
        $_SESSION['msg'] = $result ? '添加栏目成功！' : '添加栏目失败！';
        return redirect('/category/index');
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
        $biz = new CategoryBiz();
        $category = $biz->getCategory($id);
        return view('category/edit')->with($category);
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

        $biz = new CategoryBiz();
        $result = $biz->updateCategory($data);
        if ($result) {
            if (!$this->writeRoutes($data)) {
                $_SESSION['msg'] = '路由更新失败！请重新编辑该栏目！';
                return redirect('/category/index');
            }            
        }

        $_SESSION['msg'] = $result ? '编辑栏目成功！' : '编辑栏目失败！';
        return redirect('/category/index');
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

        $category_biz = new CategoryBiz();
        $result = $category_biz->deleteCategory($id);
        if ($result) {
            $article_biz = new ArticleBiz();
            if (isset($params['article']) && $params['article']) {
                $article_biz->deleteArticlesByCategoryId($id);
            } else {
                $article_biz->updateCategoryId($id);
            }
            $data['id'] = $id;
            if (!$this->writeRoutes($data, 'delete')) {
                $_SESSION['msg'] = '路由更新失败！请手动更新！';
                return redirect('/category/index');
            }
        }
        $_SESSION['msg'] = $result ? '删除栏目成功！' : '删除栏目失败！';
        return redirect('/category/index');
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
        $biz = new CategoryBiz();
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
            $routes[$name] = array();
        }
        //写入app-front中的routes.php
        $str_start = "<?php\n";
        $str = '$routes = '.var_export($routes,true);
        $str_end = ';';
        return file_put_contents(ROOT.'/app-front/routes.php', $str_start.$str.$str_end);
    }
}