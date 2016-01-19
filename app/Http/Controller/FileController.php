<?php
    namespace App\Http\Controller;

    use App\Biz\FileBiz;
    use App\Http\Controller\BaseController;
    /**
    * 
    */
    class FileController
    {
        public static $url;

        public function index()
        {
            $path = isset($_GET['path']) ? $_GET['path'] : '';
            $file_biz = new FileBiz();
            $pageData = $file_biz->readDir($path);
            $count = count($pageData['file']) + count($pageData['dir']);

            $templates = $file_biz->getTemplates();
            
            return view('file/index')->with(array(
                'count' => $count,
                'realPath' => $path,
                'pageData' => $pageData,
                'templates' => $templates
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
    }