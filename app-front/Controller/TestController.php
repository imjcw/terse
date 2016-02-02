<?php
    namespace App\Http\Controller;

    use App\Biz\ArticleBiz;
    /**
    * 
    */
    class TestController
    {
        public function test(){
            return view('file/test');
        }

        public function post()
        {
            dd($_POST);
        }

        public function get()
        {
            parse_str($_POST['data'], $data);
            return json('2000', '成功');
        }
    }