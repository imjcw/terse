<?php
    use Lib\Database\Connection;
    use App\Biz\ArticleBiz;
    /**
    * 
    */
    class TestController extends Connection
    {
        public function test(){
            $test = new ArticleBiz();
            $test->hehe();
        }
    }
?>