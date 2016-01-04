<?php
    namespace App\Http\Controller;

    use App\Biz\FileBiz;
    use App\Http\Controller\BaseController;
    /**
    * 
    */
    class FileController extends BaseController
    {
        public function index()
        {
            $path = isset($_GET['path']) ? $_GET['path'] : '';
            $file_biz = new FileBiz();
            $pageData = $file_biz->readDir($path);
            $count = count($pageData['file']) + count($pageData['dir']);
            
            return view('file/index')->with(array(
                'count' => $count,
                'realPath' => $path,
                'pageData' => $pageData
            ));
        }

        public function edit()
        {
            $path = isset($_GET['path']) ? $_GET['path'] : '';
            dd($path);
        }
    }