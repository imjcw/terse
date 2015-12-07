<?php
    /**
    * 数据库操作
    */
    class Connection
    {
        /*
        * 数据库配置信息
        */
        protected $config = [];

        /*
        * 数据库连接
        */
        protected $con = [];

         function __construct()
         {
             //$this->config = $this->getConfig();
         }

         /*
         * 获取配置信息
         */
         protected function getConfig(){
             $config_file_path = ROOT.'/config.php';
             if (isset($config_file_path)) {
                 include $config_file_path;
             }else{
                 Helper::dd('配置文件不存在，或者路径错误！');
             }

             if (isset($database)) {
                 return $database;
             }
         }

         /*
         * 数据库连接
         */
         public function connect()
         {
            $this->config = $this->getConfig();
            $this->con = mysql_connect(
                    $this->config['DB_HOST'],
                    $this->config['DB_USERNAME'],
                    $this->config['DB_PASSWORD']
                );
            if (!$this->con) {
                Helper::returnJson('1001', '数据库连接错误！');
            }//Helper::dd($this->table);

            $con_db = mysql_select_db($this->config['DB_NAME'], $this->con);
            if (!$con_db) {
                Helper::returnJson('1001', '数据库不存在！');
            }

            mysql_query('set names utf8');
         }

         /*
         * 获取所有数据
         */
        public function all(){
            $sql = 'SELECT * FROM '.$this->table;
            $result = mysql_query($sql, $this->con);
            return $this->toArray($result);
        }

        /*
         * 将从数据库查到的数据转化为数组
         */
        protected function toArray($result = null){
            $data = [];
            while ($row = mysql_fetch_assoc($result)) {
                $data[] = $row;
            }
            return $data;
        }
    }
?>