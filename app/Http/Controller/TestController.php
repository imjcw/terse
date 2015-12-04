<?php
require_once ROOT.'/framework/Database/Connection.php';
    /**
    * 
    */
    class Test extends Connection
    {
        public $table = '`column`';

        public function index(){
            $mysql = new Connection();
            $mysql->connect();
            Helper::dd($mysql->all());
        }
    }
?>