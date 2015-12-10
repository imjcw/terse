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
                 returnJson('配置文件不存在，或者路径错误！');
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
                returnJson('1001', '数据库连接错误！');
            }//Helper::dd($this->table);

            $con_db = mysql_select_db($this->config['DB_NAME'], $this->con);
            if (!$con_db) {
                returnJson('1001', '数据库不存在！');
            }

            mysql_query('set names utf8');
         }

         /*
         * 执行sql语句
         */
        public function query($sql = ''){
            $result = mysql_query($sql, $this->con);
            return $result;
        }

         /*
         * 新增
         */
        public function insert($data = []){
            if (is_array($data)) {
                $result = $this->makeData($data);
                $set = implode(',', $result['key']);
                $con = implode(',', $result['value']);
            }else{
                return false;
            }
            $sql = 'INSERT INTO '.$this->table.' ('.$set.') VALUES ('.$con.')';
            $result = mysql_query($sql, $this->con);
            return $result;
        }

         /*
         * 更新
         */
        public function update($field = [], $where = []){
            $data = is_array($field) ? $this->makeSet($field) : $field;
            $set = implode(',', $data);

            $condition = is_array($where) ? $this->makeSet($where) : $where;
            $con = implode(' and ', $condition);
            $sql = 'UPDATE '.$this->table.' SET '.$set.' WHERE '.$con;
            $result = mysql_query($sql, $this->con);
            return $result;
        }

         /*
         * 删除
         */
        public function delete($where = []){
            $condition = is_array($where) ? $this->makeSet($where) : $where;
            $con = implode(' and ', $condition);
            $sql = 'DELETE FROM '.$this->table.' WHERE '.$con;
            $result = mysql_query($sql, $this->con);
            return $result;
        }

         /*
         * 获取所有数据
         */
        public function all($field = 'id', $order = 'DESC'){
            $sql = 'SELECT * FROM '.$this->table.' ORDER BY `'.$field.'` '.$order;
            $result = mysql_query($sql, $this->con);
            return $this->toArray($result);
        }

         /*
         * 获取总数
         */
        public function count(){
            $sql = 'SELECT COUNT(*) FROM '.$this->table;
            $result = mysql_query($sql, $this->con);
            $num = $this->toArray($result, 0);
            return $num['COUNT(*)'];
        }

         /*
         * 获取一条数据
         */
        public function one($field = ''){
            $sql = 'SELECT * FROM '.$this->table.' WHERE '.$field;
            $result = mysql_query($sql, $this->con);
            return $this->toArray($result, 0);
        }

        /*
         * 将从数据库查到的数据转化为数组
         */
        protected function toArray($result = null, $one = ''){
            $data = [];
            while ($row = mysql_fetch_assoc($result)) {
                $data[] = $row;
            }
            return $one !== 0 ? $data : $data[$one];
        }

        /**
        * 处理数组，拼凑 data
        * @param $array 数组
        * @return $info array()
        * @author marvin <imjcw@imjcw.com>
        */
        public function makeData($array)
        {
            foreach ($array as $key => $value) {
                $info['key'][] = '`'.$key.'`';
                $info['value'][] = '\''.$value.'\'';
            }
            return $info;
        }

        /**
        * 处理数组，拼凑 set
        * @param $array 数组
        * @return $info array()
        * @author marvin <imjcw@imjcw.com>
        */
        public function makeSet($array)
        {
            foreach ($array as $key => $val) {
                if ($key == 'build_time') {
                    $key = 'fix_time';
                }
                $info[] = '`'.$key.'` = \''.$val.'\'';
            }
            return $info;
        }
    }
?>