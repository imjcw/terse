<?php
    namespace App\Http\Controller;

    use App\Biz\FileBiz;
    use App\Http\Controller\BaseController;
    use App\Service\TemplateService;
    /**
    * 
    */
    class FileController
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
            $path = ROOT.'/resources/app-front/template_01'.$path_name;
            $isMatched = preg_match('/\/(\w+)(-\w+)*(\/(\w+)(-\w+)*)*\//', $path_name, $matches);
            if (!$isMatched) {
                $matche = '';
            }else{
                $matche = substr($matches[0],0,-1);
            }
            $pageData = $file_biz->readDir($path);
            $count = count($pageData['file']) + count($pageData['dir']);
            $data = array();
            foreach ($pageData['file'] as $key => $filename) {
                $ext = pathinfo($filename['item'],PATHINFO_EXTENSION);
                $data['file'][$key]['class'] = $this->icon[$ext];
                $data['file'][$key]['action'] = $filename['action'];
                $data['file'][$key]['name'] = basename($filename['item'],'.'.$ext);
                $data['file'][$key]['ext'] = '.'.$ext;
            }
            foreach ($pageData['dir'] as $key => $dir) {
                $ext = pathinfo($dir['item'],PATHINFO_EXTENSION);
                $data['dir'][$key]['class'] = $this->icon['folder'];
                $data['dir'][$key]['action'] = $dir['action'];
                $data['dir'][$key]['name'] = $dir['item'];
            }

            //$templates = $file_biz->getTemplates();
            
            return view('file/index')->with(array(
                'pageData' => $data,
                'realPath' => $path_name,
                'return' => $matche
            ));
        }

        //编辑页面
        public function edit()
        {//dd(dirname(__FILE__));
            $path = isset($_GET['path']) ? $_GET['path'] : '';
            self::$url = 'http://'.$_SERVER['HTTP_HOST'].'/resources/show/template_01'.$path;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, self::$url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            $content = curl_exec($curl);
            curl_close($curl);
            $ext = pathinfo($path,PATHINFO_EXTENSION);
            $exts = array('html','js');
            if (!in_array($ext, $exts)) {
                $content = '';
            }
            return view('file/edit')->with(array('content' => $content, 'filename' => basename($path)));
        }

        public function view()
        {dd('heh');
            $content = $_POST['content'];
            dd(file_put_contents(ROOT.'/resources/show/template_01/text.txt', $content));
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
            if (!file_exists(ROOT.'/resources/show/template_01'.$path)) {
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
            # code...
        }

        public function readTemplates()
        {
            $file_biz = new FileBiz();
            $path = ROOT.'/resources/show'.$path_name;
            $pageData = $file_biz->readDir($path);
            $data = array();
            foreach ($pageData['dir'] as $key => $value) {
                $data[$key]['name'] = $value['item'];
                $data[$key]['dir_src'] = $path.'/'.$value['item'];
                if (file_exists($path.'/'.$value['item'].'/info.jpg')) {
                    $data[$key]['img_src'] = '/resources/show/'.$value['item'].'/info.jpg';
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
    }