<?php
namespace Admin\Controller;

use ZipArchive;
use Admin\Biz\TemplateBiz;
use Admin\Controller\BaseController;

class TemplateSettingController extends BaseController
{
    /**
     * 模板管理显示
     * @return [type] [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-27
     */
    public function index(){
        $biz = new TemplateBiz();
        $templates = $biz->getTemplates();
        foreach ($templates as $template) {
            $id = $template['id'];
            $data[$id]['name'] = $template['name'];
            $data[$id]['nickname'] = $template['nickname'];
            $data[$id]['description'] = $template['description'];
            $data[$id]['is_use'] = $template['is_use'];
            $data[$id]['img_src'] = '/public/tpl_img/'.$template['img_src'];
        }

        return view('template/index')->with(array(
            'templates' => $data
        ));
    }

    /**
     * 编辑模板
     * @return [type] [description]
     * @author marvin
     * @date   2016-02-25
     */
    public function doEdit()
    {
        $params = $_POST;
        if (isset($params['id']) && $params['id']) {
            $data['id'] = filter_var($params['id'], FILTER_VALIDATE_INT);
        }
        if (isset($params['name']) && $params['name']) {
            $data['name'] = filter_var($params['name'], FILTER_SANITIZE_STRING);
        }
        if (isset($params['img']) && $params['img']) {
            $img = filter_var($params['img'], FILTER_SANITIZE_STRING);
            $data['img'] = end(explode('/', $img));
        }
        if (isset($params['description']) && $params['description']) {
            $data['description'] = filter_var($params['description'], FILTER_SANITIZE_STRING);
        }
        $biz = new TemplateBiz();
        $result = $biz->updateTemplate($data);
    }

    /**
     * 模板选择
     * @return [type] [description]
     */
    public function choose()
    {
        $params = $_GET;
        if (isset($params['id']) && $params['id']) {
            $data['id'] = filter_var($params['id'], FILTER_VALIDATE_INT);
        }
        if (isset($params['name']) && $params['name']) {
            $data['name'] = filter_var($params['name'], FILTER_SANITIZE_STRING);
        }
        $biz = new TemplateBiz();
        $result = $biz->choose($data);
        return redirect('template/index');
    }


    public function upload_zip()
    {
        $exts = array('zip');
        $uploads_dir = '/uploads';
        $file = $_FILES['file'];
        $error = $this->checkError($file['error']);
        $status = false;
        $index = false;
        $article = false;
        $list = false;
        if ($error == 'ok') {
            //检查是否为正确的上传方式
            if (!is_uploaded_file($file['tmp_name'])) {
                return json('请使用正确的上传方式', 403);
            }
            //检查是否为合法的文件类型
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            if (!in_array($ext, $exts)) {
                return json('请上传正确的文件格式', 403);
            }
            //自定义文件名
            $file_name = basename($file['name'], '.' . $ext);
            $this->checkDir($file_name);
            //判断是否存在应该存在的文件，index.html, article.html, list.html
            $zip = zip_open($file['tmp_name']);
            if ($zip) {
                while ($zip_entry = zip_read($zip))
                {
                    if (zip_entry_name($zip_entry) == 'index.html') {
                        $index = true;
                    }
                    if (zip_entry_name($zip_entry) == 'article.html') {
                        $article = true;
                    }
                    if (zip_entry_name($zip_entry) == 'list.html') {
                        $list = true;
                    }
                }
                zip_close($zip);
            }
            if (!($index && $article && $list)) {
                return json('不存在相应的模板文件', 403);
            }
            $zip=new ZipArchive;//新建一个ZipArchive的对象
                if($zip->open($file['tmp_name']) === TRUE){
                $status = $zip->extractTo(ROOT . '/public/app-front/' . $file_name);
                $zip->close();//关闭处理的zip文件
            }
            if ($status) {
                $params = $_POST;
                if (isset($params['name']) && $params['name']) {
                    $data['nickname'] = filter_var($params['name'], FILTER_SANITIZE_STRING);
                }
                if (isset($params['image']) && $params['image']) {
                    $image = filter_var($params['image'], FILTER_SANITIZE_STRING);
                    $data['img_src'] = end(explode('/', $image));
                }
                if (isset($params['description']) && $params['description']) {
                    $data['description'] = filter_var($params['description'], FILTER_SANITIZE_STRING);
                }
                $data['name'] = $file_name;
                $data['dir_src'] = '/' . $file_name;
                $data['is_use'] = 0;
                $biz = new TemplateBiz();
                $result = $biz->addTemplate($data);
                return json('success');
            }
        }
        return json('文件上传失败，请重新上传', 403);
    }

    public function checkDir(&$path)
    {
        static $num = '';
        if (is_dir(ROOT . '/public/app-front/' . $path . $num)) {
            $num = $num != '' ? ++$num : 1;
            $this->checkDir($path);
        } else {
            $path .= $num;
        }
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

    public function deleteTemplate()
    {
        $params = $_GET;
        if (isset($params['id']) && $params['id']) {
            $id = filter_var($params['id'], FILTER_VALIDATE_INT);
        }
        if (isset($params['name']) && $params['name']) {
            $name = filter_var($params['name'], FILTER_SANITIZE_STRING);
        }
        $biz = new TemplateBiz();
        $result = $biz->deleteTemplate($id);
        if ($result) {
            deldir(ROOT . '/public/app-front/' . $name);
        }
        return redirect('template/index');
    }
}