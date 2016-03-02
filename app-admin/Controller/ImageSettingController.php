<?php
namespace Admin\Controller;

use Admin\Biz\ImageBiz;
use Admin\Controller\BaseController;
use Admin\Biz\FileBiz;

class ImageSettingController extends BaseController
{
    /**
     * 展示文章页面
     * @return [type]     [description]
     * @author marvin <imjcw@imjcw.com>
     * @date   2016-01-25
     */
    public function index(){
        $biz = new ImageBiz();
        $data = $biz->getImage();
        $files = $this->buildPageDataFile($data);
        $url = getSystem('url');
        if (strlen($url) == (strripos($url, '/') + 1)) {
            $url = substr($url, 0, -1);
        }
        return view('image/index')->with(array(
            'data' => $files,
            'url' => $url
        ));
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
            $data[$key]['name'] = $file['name'].'.'.$file['ext'];
            $data[$key]['size'] = $file['size'];
        }
        return $data;
    }

    public function delete()
    {
        $param = $_POST;
        $src = ROOT.'/app-front/images/'.$param['image'];
        $ext = pathinfo($param['image'], PATHINFO_EXTENSION);
        $file = basename($param['image'],'.'.$ext);
        $biz = new ImageBiz();
        $data = $biz->delete($file);
        if (file_exists($src)) {
            unlink($src);
            return json('success');
        }
        return json('fail',403);
    }

    public function deleteMulti()
    {
        $param = $_POST;
        $images = explode(',', $param['checked']);
        array_pop($images);
        foreach ($images as $image) {
            $src = ROOT.'/app-front/images/'.$image;
            if (file_exists($src)) {
                unlink($src);
                $ext = pathinfo($image, PATHINFO_EXTENSION);
                $files[] = basename($image,'.'.$ext);
            } else {
                $error[] = $image.'删除失败!';
            }
        }
        $biz = new ImageBiz();
        $data = $biz->deleteMulti($files);
        if (isset($error)) {
            return json($error,403);
        }
        return json('success');
    }

    public function upload()
    {
        $exts = array('jpg','png','gif');
        $file = $_FILES['upload'];
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
            $file_name = $this->rewriteFileName($file['name'],$ext);
            $data['name'] = basename($file_name,'.'.$ext);
            $data['ext'] = $ext;
            $data['size'] = $this->computeSize($file['size']);
            $biz = new ImageBiz();
            $biz->addImage($data);
            //移动文件到指定文件夹
            $status = move_uploaded_file($file['tmp_name'], ROOT.'/app-front/images/'.$file_name);
            chmod(ROOT.'/app-front/images/'.$file_name, 0766);
            echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($callback,'".'http://front.marvin.cn/images/'.$file_name."','');</script>";
        }
        //return $status ? json('success！') : json('fault！', 403);
    }

    public function computeSize($size)
    {
        $arr = array('B', 'KB', 'MB');
        $i = 0;

        while ($size > 1024) {
            $size /= 1024;
            $i++;
        }

        return round($size, 2).$arr[$i];
    }

    public function rewriteFileName($old_name,$ext)
    {
        $new_name = md5($old_name.time()).'.'.$ext;
        if (file_exists(ROOT.'/app-front/images/'.$new_name)) {
            $this->checkFileName($old_name,$ext);
        }
        return $new_name;
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

}