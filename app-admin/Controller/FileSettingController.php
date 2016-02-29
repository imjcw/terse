<?php
namespace Admin\Controller;

use Admin\Biz\FileBiz;
use Admin\Controller\BaseController;
use Admin\Service\TemplateService;

class FileSettingController extends BaseController
{
    protected $icon = array(
        'html' => 'html5',
        'css' => 'css3',
        'js' => 'file code outline',
        'jpg' => 'file image outline',
        'gif' => 'file image outline',
        'png' => 'file image outline',
        'folder' => 'folder outline'
    );

    public static $url;

    /**
     * 文件管理显示
     * @return [type] [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-27
     */
    public function index()
    {
        $path_name = isset($_GET['path']) ? $_GET['path'] : '';
        $file_biz = new FileBiz();
        $path = ROOT.'/public/app-front/'.TEMPLATE_NAME.$path_name;
        $isMatched = preg_match('/\/(\w+)(-\w+)*(\/(\w+)(-\w+)*)*\//', $path_name, $matches);
        if (!$isMatched) {
            $matche = '';
        }else{
            $matche = substr($matches[0],0,-1);
        }
        $result = $file_biz->readDir($path);
        if (isset($result['file'])) {
            $files = $this->buildPageDataFile($result['file']);
            $data['file'] = $files['file'];
        }
        if (isset($result['dir'])) {
            $dirs = $this->buildPageDataDir($result['dir']);
            $data['dir'] = $dirs['dir'];
        }
        
        return view('file/index')->with(array(
            'data' => $data,
            'realPath' => $path_name,
            'return' => $matche
        ));
    }

    //编辑页面
    public function edit()
    {
        $params = $_GET;
        $exts = array('html','js','css');
        if (isset($params['path']) && $params['path']) {
            $path = filter_var($params['path'], FILTER_SANITIZE_STRING);
        }
        if (isset($params['ext']) && $params['ext']) {
            $ext = filter_var($params['ext'], FILTER_SANITIZE_STRING);
        }
        if (!in_array($ext, $exts)) {
            return redirect('/file/index');
        }
        $src = ROOT.'/public/app-front/'.TEMPLATE_NAME.$path.'.'.$ext;
        $content = file_get_contents($src);
        return view('file/edit')->with(array(
            'content' => $content,
            'name' => basename($path),
            'dir' => dirname($path),
            'ext' => $ext
            ));
    }

    public function doEdit()
    {
        $params = $_POST;
        $exts = array('html','js','css');
        if (isset($params['name']) && $params['name']) {
            $name = filter_var($params['name'], FILTER_SANITIZE_STRING);
        }
        if (isset($params['old_name']) && $params['old_name']) {
            $old_name = filter_var($params['old_name'], FILTER_SANITIZE_STRING);
        }
        if (isset($params['dir']) && $params['dir']) {
            $dir = filter_var($params['dir'], FILTER_SANITIZE_STRING);
        }
        if (isset($params['ext']) && $params['ext']) {
            $ext = filter_var($params['ext'], FILTER_SANITIZE_STRING);
        }
        if (isset($params['content']) && $params['content']) {
            $content = $params['content'];
        }
        if (!in_array($ext, $exts)) {
            return redirect('/file/index');
        }
        $src = ROOT.'/public/app-front/'.TEMPLATE_NAME.$dir.'/'.$name.'.'.$ext;
        if (!file_exists($src)) {
            return false;
        }
        $result = file_put_contents($src,$content);
        return redirect('file/index'); 
    }

    public function view()
    {dd('heh');
        $content = $_POST['content'];
        dd(file_put_contents(ROOT.'/public/show/template_01/text.txt', $content));
        return;
    }

    /**
     * 删除文件
     * @return [type] [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-27
     */
    public function delete()
    {
        $path = isset($_GET['path']) ? $_GET['path'] : '';

        //判断文件是否存在
        if (!file_exists(ROOT.'/resources/show/'.TEMPLATE_NAME.$path)) {
            return "文件不存在！";
        }
        //判断是否为文件夹
        if (!is_dir(ROOT.'/resources/show/template_01'.$path)) {
            $result = unlink(ROOT.'/resources/show/template_01'.$path);
        }else {//待写，删除文件夹及其下面的文件
            $result = rmdir(ROOT.'/resources/show/template_01'.$path);
        }
        //判断是否删除成功
        if (!$result) {
            return "文件删除失败！";
        }
        return "文件删除成功！";
    }

    public function deldir($path)
    {
        # code...
    }

    public function rename()
    {
        $params = $_POST;
        if (isset($params['new_name']) && $params['new_name']) {
            $data['new_name'] = filter_var($params['new_name'], FILTER_SANITIZE_STRING);
        }
        if (isset($params['old_name']) && $params['old_name']) {
            $data['old_name'] = filter_var($params['old_name'], FILTER_SANITIZE_STRING);
        }
        if (isset($params['path']) && $params['path']) {
            $data['path'] = filter_var($params['path'], FILTER_SANITIZE_STRING);
        }
        if (isset($params['ext']) && $params['ext']) {
            $data['ext'] = filter_var($params['ext'], FILTER_SANITIZE_STRING);
        }
        $old_name = $data['old_name'].'.'.$data['ext'];
        $new_name = $data['new_name'].'.'.$data['ext'];
        $path = $data['path'];
        $old_url = ROOT.'/public/app-front/'.TEMPLATE_NAME.$path.'/'.$old_name;
        //判断文件是否存在
        if (!file_exists($old_url)) {
            return "文件不存在！";
        }
        if (rename($old_url,ROOT.'/public/app-front/'.TEMPLATE_NAME.$path.'/'.$new_name)) {
            return "成功！";
        } else {
            return "失败！";
        }
    }

    public function readTemplates()
    {
        $file_biz = new FileBiz();
        $path = ROOT.'/public/show'.$path_name;
        $pageData = $file_biz->readDir($path);
        $data = array();
        foreach ($pageData['dir'] as $key => $value) {
            $data[$key]['name'] = $value['item'];
            $data[$key]['dir_src'] = $path.'/'.$value['item'];
            if (file_exists($path.'/'.$value['item'].'/info.jpg')) {
                $data[$key]['img_src'] = '/public/show/'.$value['item'].'/info.jpg';
            } else {
                $data[$key]['img_src'] = $path.'/info.jpg';
            }
        }
        $template_service = new TemplateService();
        foreach ($data as $key => $value) {
            $result = $template_service->addTemplates($value);
        }
        return $result;
    }

    public function upload()
    {
        $exts = array('html','css','js','jpg','png','gif');
        //if (!file_exists(ROOT.'/uploads')) {
        //    mkdir(ROOT.'/uploads', 0755, true);
        //    chmod(ROOT.'/uploads', 0755);
        //}
        $uploads_dir = '/uploads';
        $file = $_FILES['file'];
        $error = $this->checkError($file['error']);
        $status = false;
        if ($error == 'ok') {
            //检查是否为正确的上传方式
            if (!is_uploaded_file($file['tmp_name'])) {
                dd('请使用正确的上传方式');
            }
            //检查是否为合法的文件类型
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            if (!in_array($ext, $exts)) {
                dd('请上传正确的文件格式');
            }
            //自定义文件名
            $file_name = $file['name'];
            //移动文件到指定文件夹
            $status = move_uploaded_file($file['tmp_name'], ROOT.'/app-admin/public/tpl_img/'.$file_name);
            chmod(ROOT.'/app-admin/public/tpl_img/'.$file_name, 0766);
        }
        return $status ? json('success！') : json('fault！', 403);
    }

    /**
     * 检测上传文件错误
     * @param  int $error 错误码
     * @return string 
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-02-01
     */
    public function checkError($error)
    {
        switch ($error) {
            case 0:
                $result = 'ok';
                break;

            case 1:
            case 2:
                $result = '上传文件过大';
                break;

            case 3:
                $result = '文件部分上传成功';
                break;

            case 4:
                $result = '未选择上传文件';
                break;

            case 5:
            case 6:
                $result = '无临时目录';
                break;

            case 7:
            case 8:
                $result = '系统错误';
                break;

            default:
                $result = '系统错误';
                break;
        }
        return $result;
    }

    public function createFolder()
    {
        $folder = $_POST['name'];
        if (file_exists(ROOT.'/resources/app-front/template_01/'.$folder)) {
            return false;
        }
        mkdir(ROOT.'/resources/app-front/template_01/'.$folder, 0777, true);
        chmod(ROOT.'/resources/app-front/template_01/'.$folder, 0777);
    }

    /**
     * 组合文件数据
     * @param  [type] $files [description]
     * @return [type]       [description]
     * @author marvin
     * @date   2016-02-29
     */
    public function buildPageDataFile($files)
    {
        foreach ($files as $key => $file) {
            $ext = pathinfo($file['item'],PATHINFO_EXTENSION);
            $data['file'][$key]['class'] = $this->icon[$ext];
            $data['file'][$key]['action'] = $file['action'];
            $data['file'][$key]['name'] = basename($file['item'],'.'.$ext);
            $data['file'][$key]['ext'] = $ext;
        }
        return $data;
    }

    /**
     * 组合文件夹数据
     * @param  [type] $dirs [description]
     * @return [type]       [description]
     * @author marvin
     * @date   2016-02-29
     */
    public function buildPageDataDir($dirs)
    {
        foreach ($dirs as $key => $dir) {
            $data['dir'][$key]['class'] = $this->icon['folder'];
            $data['dir'][$key]['action'] = $dir['action'];
            $data['dir'][$key]['name'] = $dir['item'];
        }
        return $data;
    }
}