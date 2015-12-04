<?php
    /**
    * 路由获取
    */
    class Route
    {
        /*
        * 获取Uri
        */
        public function getUri(){
            return isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
        }
    }
?>