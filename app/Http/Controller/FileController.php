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
            'folder' => 'folder outline'
        );

        public static $url;

        public function index()
        {
            $path_name = isset($_GET['path']) ? $_GET['path'] : '';
            $file_biz = new FileBiz();
            $path = ROOT.'/resources/show/template_01'.$path_name;
            $pageData = $file_biz->readDir($path);
            $count = count($pageData['file']) + count($pageData['dir']);
            $data = array();
            foreach ($pageData['file'] as $key => $filename) {
                $ext = pathinfo($filename['item'],PATHINFO_EXTENSION);
                $data['file'][$key]['class'] = $this->icon[$ext];
                $data['file'][$key]['action'] = $filename['action'];
                $data['file'][$key]['name'] = $filename['item'];
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
                'realPath' => $path
            ));
        }

        public function edit()
        {//dd(dirname(__FILE__));
            $path = isset($_GET['path']) ? $_GET['path'] : '';
            self::$url = 'http://marvin.club/resources/show/template_01'.$path;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, self::$url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            $content = curl_exec($curl);
            curl_close($curl);
            return view('file/edit')->with(array('content' => $content));
        }

        public function update()
        {
            $content = $_POST['content'];
            dd(file_put_contents(ROOT.'/resources/show/template_01/text.txt', $content));
            return;
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