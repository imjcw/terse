<?php
use Lib\Database\Connection;
    /**
    * 
    */
    class TestController extends Connection
    {
        public function test(){
            return view('map');
        }
    }
?>